<?php
namespace Admin\Controller;
use Admin\Controller\AdminController;

class GoodsAttrController extends AdminController {
    public function index(){
        $search = $_GET['searchval'];
        if(!empty($search)){
            $map['attrname'] = array("like","%$search%");
        }

        //查询属性列表
        $a = D('Attr');
        $total = $a -> attrCount($map);        
        $pages = new \Think\Page($total,10);
        $limit = $pages ->firstRow.','.$pages->listRows;
        $data = $a -> allAttr($map,$limit);

        $this -> assign(data,$data);
        $this -> assign(title,'商品属性');
        $this -> assign(page,$pages->show());
        $this -> display();
    }
    
    //添加属性页面
    public function addAttr(){
        $page['action']['prev'] = "Goodsattr";
        $page['title']['current'] = "添加属性";
        $page['title']['prev'] = '商品属性'; 

        //查询分类列表
        $c = D('Class');
        $data = $c -> childClass(0);
        
        $this -> assign(title,'添加属性');
        $this -> assign(classdata,$data);
        $this -> assign(page,$page);
        $this -> display();
    }
    
    //添加分类页面
    public function modifyAttr(){
        $page['action']['prev'] = "Goodsattr";
        $page['title']['current'] = "编辑属性";
        $page['title']['prev'] = '商品属性';
        
        //查询分类以及属性值
        $a = D('Attr');
        $map['attrid'] = $_GET['id'];
        $attrs = $a -> selectAttr($map);
        $val = $a -> findAttrValue($_GET['id']);

        $this -> assign(val,$val);
        $this -> assign(data,$attrs[0]);
        $this -> assign(title,'编辑属性');
        $this -> assign(page,$page);
        $this -> display();
    }

    //处理添加分类
    public function insertAttr(){
        ksort($_POST['attrval']);
        $insert = M('attribute');
        $attr['attrname'] = $_POST['attrname'];
        $attr['cid'] = $_POST['cid'];
        $insert->create($attr);
        if ($attrid = $insert -> add()){

            foreach ($_POST['attrval'] as $value) {
                if ($value) {
                    $gtoa = M('goodstoattr');
                    $add['attrid'] = $attrid;
                    $add['attrvalue'] = $value;
                    $gtoa -> create($add);
                    $gtoa -> add();
                }
            }
            $this->redirect('Admin/Goodsattr/index');
        }else{
            $this->error('添加失败');
        }
    }

    //处理修改分类
    public function updataAttr(){
        $updata = M('attribute');
        $attr['attrname'] = $_POST['attrname'];
        $attr['attrsort'] = $_POST['attrsort'];
        $attrid = $_POST['attrid'];
        $where['attrid'] = array('eq',$attrid);
        $updata -> where($where) -> save($attr);

        //删除原有
        $gtoa = M('goodstoattr');
        $gtoa-> where($where) ->delete();

        //更新现有
        foreach ($_POST['attrval'] as $value) {
            $upgtoa['attrid'] = $attrid;
            $upgtoa['attrvalue'] = $value;
            $gtoa -> create($upgtoa);
            $gtoa -> add();
        }
         $this->redirect('Admin/Goodsattr/index');
    }

    //处理删除分类
    public function deleteAttr(){
        if(!authCheck('Admin/Goodsattr/deleteAttr',session('uid'))){
            echo 2;
            return;
        }
        $delattr = M('attribute');
        if ($delattr -> delete($_POST['attrid'])) {
            $gtoa = M('goodstoattr');
            $delattrid['attrid'] = array('eq',$_POST['attrid']);
            $gtoa-> where($delattrid) ->delete();
            echo 1;
            return;
        }
        echo 0;
    }
}
