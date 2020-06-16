<?php
namespace app\comadmin\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;

vendor('Qiniu.autoload');
use Qiniu\Auth as Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;

class remote extends Controller
{
    public function index(){

        if(check_login()){
            $type = input("type");
            $all = Db::table('ims_sudu8_page_pic')->where("type",4)->order('id desc')->paginate(12,false,['query'=> array('type'=>input("type"))]);
            $list = $all->toArray()['data'];
            $count = Db::table('ims_sudu8_page_pic')->where("type",4)->count();
            $this->assign('all',$all);
            $this->assign('list',$list);
            $this->assign('count',$count);
            $this->assign('type',$type);
            return $this->fetch('index');
        }else{
            $this->redirect('Login/index');
        }
        
    }
    
    public function imgupload(){
        $files = request()->file('');  
        foreach($files as $file){        
            // 移动到框架应用根目录/public/upimages/ 目录下        
            $info = $file->validate(['ext'=>'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public' . DS . 'upimages');
            if($info){
                $url =  "/upimages/".date("Ymd",time())."/".$info->getFilename();
                $data = array();
                $data['imgurl'] = $url;
                $data['type'] = 4;
                $pid = Db::table("ims_sudu8_page_pic")->insertGetId($data);
                $arr = array("url"=>$url,"pid"=>$pid);
                return json_encode($arr);
            }else{
                // 上传失败获取错误信息
                return $this->error($file->getError()) ;
            }    
        }
    }


    public function makegroup(){
        $uniacid = input("uniacid");
        $name = input("name");
        $is = Db::table("ims_sudu8_page_picgroup")->where("uniacid",$uniacid)->where("name",$name)->find();
        if($is){
            echo json_encode(array("is"=>0));
        }else{
            $data = array();
            $data['uniacid'] = $uniacid;
            $data['name'] = $name;
            $id = Db::table("ims_sudu8_page_picgroup")->insertGetId($data);
            if($id){
                echo json_encode(array("is"=>1,"id"=>$id));
            }else{
                echo json_encode(array("is"=>2));
            }
        }

    }


    public function save(){
        $data = array();
        //小程序ID
        $data['uniacid'] = input("appletid");

        //排序
        $num = input("num");
        if($num){
            $data['num'] = $num;
        }

        $name = input("name");
        if($name){
            $data['name'] = $name;
        }

        //栏目图片
        $catepic = $this->onepic_uploade("catepic");
        if($catepic){
            $data['catepic'] = $catepic;
        }

        // var_dump($data);exit;
        
        
        $id = input("cateid");

        if($id!=0){
            $res = Db::table('ims_sudu8_page_score_cate')->where("id",$id)->update($data);
        }else{
            $res = Db::table('ims_sudu8_page_score_cate')->insert($data);
        }



        if($res){
          $this->success('栏目信息更新成功！');
        }else{
          $this->error('栏目信息更新失败，没有修改项！');
          exit;
        }



    }

    // 删除操作
    public function del(){
        $data['id'] = input("cateid");
        $res = Db::table('ims_sudu8_page_score_cate')->where($data)->delete();
        if($res){
            $this->success('删除成功');
        }else{
            $this->success('删除失败');
        }
    }




    //单个图片上传操作
    function onepic_uploade($file){
        $thumb = request()->file($file);
        if(isset($thumb)){
            $dir = upload_img();
            $info = $thumb->move($dir); 
            if($info){  
                $imgurl = ROOT_HOST."/upimages/".date("Ymd",time())."/".$info->getFilename();
                return $imgurl;
            }  
        }
    }
}