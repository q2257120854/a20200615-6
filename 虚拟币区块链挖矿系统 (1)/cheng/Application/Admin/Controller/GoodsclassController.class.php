<?php
namespace Admin\Controller;
use Admin\Controller\AdminController;

class GoodsclassController extends AdminController {
    public function index(){
        $search = $_GET['searchval'];
        if(!empty($search)){
            $map['cname'] = array("like","%$search%");
        }
        
        $viewclass = M('classify');
        $btoc = M('brandtoclass');
        $brand = M('brand');
        $c = D('Class');
        $total = $c -> classCount($map);
        $pages = new \Think\Page($total,10);
        $limit = $pages ->firstRow.','.$pages->listRows;
        $data = $c -> selectClass($map,$limit);
        foreach ($data as $key => $value) {
            $maps['cid'] = array('eq',$value['cid']);
            $bids = $btoc -> where($maps) -> field('bid') -> select();
            $bname = '';
            foreach ($bids as $bid) {
                $wb['bid'] = array('eq',$bid['bid']);
                $res = $brand -> field('bname') -> where($wb) -> find();
                $bname .= $res['bname'].',';
            }
            $data[$key]['bname'] = trim(mb_substr($bname,0,80,'utf-8'),',');
        }
        $this -> assign(data,$data);
        $this -> assign(title,'商品分类');
        $this -> assign(page,$pages->show());
        $this -> display();
    }
    
    //添加分类页面
    public function addClass(){
        $this -> assign(title,'添加分类');
        $page['action']['prev'] = "goodsclass";
        $page['title']['current'] = "添加分类";
        $page['title']['prev'] = '商品分类';
        $classes = D('Class');
        $data = $classes -> childClass(0);
        $this -> assign(classdata,$data);
        $this -> assign(page,$page);
        $this -> display();
    }
    
    //修改分类页面
    public function modifyClass(){
        $this -> assign(title,'编辑分类');
        $page['action']['prev'] = "goodsclass";
        $page['title']['current'] = "编辑分类";
        $page['title']['prev'] = '商品分类';
        $this -> assign(page,$page);

        $classes = D('Class');
        $info = $classes -> findClass($_GET['id']);
        $bpath = explode('-', $info['bpath']);
        array_pop($bpath);
        foreach ($bpath as $key => $value) {
            $path[$key] = $classes -> childClass($value);
        }
        $this -> assign('curr',$bpath);
        $this -> assign('path',$path);
        $this -> assign('class',$info);
        $this -> display();
    }

    //处理添加分类
    public function insertClass(){
        header("Content-Type:text/html;charset=utf-8");
        $insert = M('classify');
        
        if ($_POST['parentid'] == 0) {
            $_POST['cpath'] = 0;
        }else{
            $btoc = M('brandtoclass');
            $where['cid'] = array('eq',$_POST['parentid']);            
            if ($btoc->where($where)->find()) {
                $this->error('新增失败,在已使用的分类后面不能添加子分类');
                exit;
            }
            $path = $insert-> where($where) -> field('cpath') ->find();
            $_POST['cpath'] = $path['cpath'].'-'.$_POST['parentid'];
        }        
        $insert->create($_POST);
        if ($insert->add()) {
            $this->redirect('Admin/Goodsclass/index');
        }else{
            $this->error('新增失败');
        }
    }

    //处理修改分类
    public function updataClass(){
        $updata = M('classify');
        if ($_POST['parentid'] == '') {
            unset($_POST['parentid']);
        }else{
            //查询新的路径
            $c = D('Class');
            if($_POST['parentid'] == 0){
                $newpath = '0';
            }else{
                $ppath = $c -> findClass($_POST['parentid']);
                $newpath = $ppath['bpath'];
            }

            //查询原始路径
            $opath = $c -> findClass($_POST['cid']);
            $oldpath = $opath['cpath'];
            $pregstr = '/^'.$opath['bpath'].'/';

            if (preg_match($pregstr, $newpath)) {
                $this->error('不能讲父级目录放到自己的目录下');
                return;
            }

            $child = $c -> allChild($_POST['cid']);
            foreach ( $child as $value ) {
                $map['cid'] = array('eq',$value['cid']);
                $newvalue['cpath'] = str_replace($oldpath, $newpath, $value['cpath']);
                $updata-> where($map) ->save($newvalue);
            }
            $_POST['cpath'] = $newpath;
        }
        $map['cid'] = array('eq',$_POST['cid']);
        if ($updata-> where($map) ->save($_POST)) {
            $this->redirect('Admin/Goodsclass/index');
        }else{
            exit;
            $this->error('修改失败');
        }
    }

    //处理删除分类
    public function deleteClass(){
        if(!authCheck('Admin/GoodsClass/deleteClass',session('uid'))){
            echo 3;
            return;
        }
        
        $floors = M('floors');
        $map['cid'] = array('eq',$_POST['cid']);
        if ($floors->where($map)->find()) {
            echo 2;
            return;
        }        

        if($this->deleteAll($_POST['cid'])){
            echo 1;
            return;
        }
        echo 0;
    }

    //查询分类id
    public function viewClassId(){
        $map['parentid'] = array('eq',$_POST['parentid']);
        $classes = M('classify');
        $data = $classes -> where($map) -> field('cid,cname') -> select();
        if ($data) {
            echo json_encode($data);
            return;
        }
        echo 0;
    }

    //删除分类函数
    private function deleteAll($id){
        $delall = M('classify');
        $btoc = M('brandtoclass');
        $g = M('goods');
        $c = D('Class');
        $child = $c -> allChild($id);
        if ($child[0]['cname']) {
            return false;
        }

        $goods = $g -> where("gclassification=$id") -> select();
        if ($goods[0]['gname']) {
            return false;
        }

        $map['cid'] = array('eq',$id);
        $btoc -> where($map) -> delete();
        $delall -> where($map) -> delete(); 
        return true;
    }
}
