<?php
namespace Admin\Controller;
use Admin\Controller\AdminController;

class GoodsbrandController extends AdminController {
    public function index(){
        $search = $_GET['searchval'];
        if(!empty($search)){
            $map['bname'] = array("like","%$search%");
        }
        
        $viewbrand = M('brand');
        $btoc = M('brandtoclass');
        $classes = M('classify');
        $b = D('brand');
        $total = $b -> brandCount($map);
        $b -> allClass();
        $pages = new \Think\Page($total,10);
        $limit = $pages ->firstRow.','.$pages->listRows;
        $data = $b -> selectBrand($map,$limit);
        foreach ($data as $key => $value) {
            $class = $b -> allClass($value['bid']);
            $cname = '';
            foreach ($class as $vo) {
                $cname .= $vo['cname'].',';
            }
            $data[$key]['cname'] = trim($cname,',');
        }
        $this -> assign(data,$data);
        $this -> assign(title,'品牌管理');
        $this -> assign(page,$pages->show());
        $this -> display();
    }
    
    //添加品牌页面
    public function addBrand(){
        $this -> assign(title,'添加品牌');
        $page['action']['prev'] = "Goodsbrand";
        $page['title']['current'] = "添加品牌";
        $page['title']['prev'] = '品牌管理';
        $classes = M('classify');
        $c = D('Class');
        $data = $c -> childClass(0);
        foreach ($data as  $value) {
            $child = $c -> allChild($value['cid']);
            foreach ($child as $k => $v) {
                $bottom['cpath'] = array('like',"%{$v['bpath']}");
                if (!$classes->where($bottom)->select()) {
                    $child[$k]['isbottom'] = 1;
                }
            }
            $childs[] = $child;
        }
        $this -> assign(childs,$childs);
        $this -> assign(data,$data);
        $this -> assign(page,$page);
        $this -> display();
    }
    
    //修改品牌页面
    public function modifyBrand(){
        $this -> assign(title,'编辑品牌');
        $page['action']['prev'] = "Goodsbrand";
        $page['title']['current'] = "编辑品牌";
        $page['title']['prev'] = '品牌管理';

        $this -> assign(page,$page);
        $selectad = M('brand');
        $bname = $selectad -> field('bname,brandpic') -> find($_GET['id']);

        //查询分类
        $classes = M('classify');
        $btoc = M('brandtoclass');
        $c = D('Class');
        $data = $c -> childClass(0);
        foreach ($data as  $value) {
            $child = $c -> allChild($value['cid']);
            foreach ($child as $k => $v) {
                $bottom['cpath'] = array('like',"%{$v['bpath']}");
                if (!$classes->where($bottom)->select()) {                    
                    $bw['bid'] = array('eq',$_GET['id']);
                    $bw['cid'] = array('eq',$v['cid']);
                    $res = $btoc -> where($bw) -> select();
                    if ($res) {
                        $child[$k]['ishave'] = 1;
                    }
                    $child[$k]['isbottom'] = 1;
                }
            }
            $childs[] = $child;
        }

        $this -> assign(childs,$childs);
        $this -> assign(data,$data);
        $this -> assign('bname',$bname);
        $this -> display();
    }

    //处理添加品牌
    public function insertBrand(){
        $upload = new \Think\Upload();
        $upload -> exts = array('jpg','png','gif');
        $upload -> rootPath = './Public/Uploads/';
        $upinfo = $upload->upload($_FILES);
        if (!$upload->getError()) {
            $picname = $upinfo['brandpic']['savepath'].$upinfo['brandpic']['savename'];
            $tubname = implode('/th_',explode('/',$picname));
            $tubimg = new \Think\Image();
            $tubimg->open("./Public/Uploads/$picname");
            $tubimg->thumb(150,150);
            if(!$tubimg->save("./Public/Uploads/$tubname")){
                $this->error('图片生成缩略图失败！');
                return;
            }
            $brand['brandpic'] = $picname;
        }

        $insert = M('brand');
        $brand['bname'] = $_POST['bname'];
        $brand['firstchar'] = getFirstChar($brand['bname']);
        $insert->create($brand);
        if ($bid = $insert -> add()){
            foreach ($_POST['team'] as $value) {
                $btoc = M('brandtoclass');
                $add['bid'] = $bid;
                $add['cid'] = $value;
                $btoc -> create($add);
                $btoc -> add();
            }
            $this->redirect('Admin/Goodsbrand/index');
        }else{
            $this->error('添加失败');
        }
    }

    //处理更新品牌
    public function updataBrand(){
        $updata = M('brand');
        if(!empty($_FILES['brandpic']['name'])){
            //删除原图片
            $adinfo = $updata->find($_POST['bid']);
            $picname = "./Public/Uploads/".$adinfo['brandpic'];
            $tubname = "./Public/Uploads/".implode('/th_',explode('/',$adinfo['brandpic']));
            unlink($picname);
            unlink($tubname);
            
            //增加新图片
            $upload = new \Think\Upload();
            $upload -> exts = array('jpg','png','gif');
            $upload -> rootPath = './Public/Uploads/';
            $upinfo = $upload->upload($_FILES);
            
            if ($upload->getError()) {
                $this->error('图片上传失败！');
                return;
            }
            
            $picname = $upinfo['brandpic']['savepath'].$upinfo['brandpic']['savename'];
            $tubname = implode('/th_',explode('/',$picname));
            $tubimg = new \Think\Image();
            $tubimg->open("./Public/Uploads/$picname");
            $tubimg->thumb(150,150);
            
            if(!$tubimg->save("./Public/Uploads/$tubname")){
                $this->error('图片生成缩略图失败！');
                return;
            }
            
            $brand['brandpic'] = $picname;
        }

        $brand['bname'] = $_POST['bname'];
        $bid = $_POST['bid'];
        $where['bid'] = array('eq',$_POST['bid']);
        $updata -> where($where) -> save($brand);

        //删除原有
        $btoc = M('brandtoclass');
        $delbid['bid'] = array('eq',$bid);
        $btoc-> where($delbid) ->delete();

        //更新现有
        foreach ($_POST['team'] as $value) {
            $upbtoc['bid'] = $bid;
            $upbtoc['cid'] = $value;
            $btoc -> create($upbtoc);
            $btoc -> add();
        }
        $this->redirect('Admin/Goodsbrand/index');
    }

    //处理删除品牌
    public function deleteBrand(){
        if(!authCheck('Admin/Goodsbrand/deleteBrand',session('uid'))){
            echo 2;
            return;
        }
        
        $delbrand = M('brand');
        //删除图片
        $adinfo = $delbrand->find($_POST['bid']);
        $picname = "./Public/Uploads/".$adinfo['adpic'];
        $tubname = "./Public/Uploads/".implode('/th_',explode('/',$adinfo['adpic']));
        unlink($picname);
        unlink($tubname);

        if ($delbrand -> delete($_POST['bid'])) {
            $btoc = M('brandtoclass');
            $delbid['bid'] = array('eq',$bid);
            $btoc-> where($delbid) ->delete();
            echo 1;
            return;
        }
        echo 0;
    }
}
