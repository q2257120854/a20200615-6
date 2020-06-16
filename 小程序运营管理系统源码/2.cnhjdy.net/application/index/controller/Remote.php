<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;

vendor('Qiniu.autoload');
use Qiniu\Auth as Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;

// vendor('aliyun.autoload');


class remote extends Controller
{
    public function index(){
        // if(check_login()){
                $appletid = input("appletid");
                $res = Db::table('applet')->where("id",$appletid)->find();
                if(!$res){
                    $this->error("找不到对应的小程序！");
                }
                $this->assign('applet',$res);

                $gid = input("gid");

                $type = input("type");
                $group = Db::table('ims_sudu8_page_picgroup')->where("uniacid",$appletid)->order('id desc')->select();
                if($group){
                    foreach ($group as $k => &$v) {
                        $v['count'] = Db::table("ims_sudu8_page_pic")->where("gid",$v['id'])->count();
                    }
                }
                if($gid){
                    $all = Db::table('ims_sudu8_page_pic')->where("uniacid",$appletid)->where("gid",$gid)->order('id desc')->paginate(12,false,[ 'query' => array('appletid'=>input("appletid"),'type'=>input("type"))]);
                }else{
                    $all = Db::table('ims_sudu8_page_pic')->where("uniacid",$appletid)->order('id desc')->paginate(12,false,[ 'query' => array('appletid'=>input("appletid"),'type'=>input("type"))]);
                    $gid = 0;
                }
                $list = $all->toArray();
                $remote = Db::table('ims_sudu8_page_remote') ->where("uniacid",$appletid)->where("type",2)->find();
                foreach($list['data'] as &$v){
                    if($v['type'] == 2){
                        if($remote){
                            $v['imgurl'] = $remote['domain'].'/'.$v['imgurl'];
                        }
                    }
                }
                $count = Db::table('ims_sudu8_page_pic')->where("uniacid",$appletid)->count();
                $this->assign('type',$type);
                $this->assign('group',$group);
                $this->assign('gid',$gid);
                $this->assign('all',$all);
                $this->assign('list',$list['data']);
                $this->assign('uniacid',$appletid);
                $this->assign('count',$count);

            return $this->fetch('index');
        // }else{
        //     $this->redirect('Login/index');
        // }
        
    }
    
    public function imgupload(){
        $uniacid = input("uniacid");
        $remote = Db::table("ims_sudu8_page_base")->where("uniacid",$uniacid)->field("remote")->find()['remote'];
        if(!$remote){
            $remote = 1;
        }
        $groupid = input("groupid");
        if($remote == 1){
            $files = request()->file('');  
            foreach($files as $file){        
                // 移动到框架应用根目录/public/upimages/ 目录下        
                $info = $file->validate(['ext'=>'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public' . DS . 'upimages');
                if($info){
                    $url =  "/upimages/".date("Ymd",time())."/".$info->getFilename();
                    $data = array();
                    $data['uniacid'] = $uniacid;
                    $data['gid'] = $groupid;
                    $data['imgurl'] = $url;
                    $data['type'] = 1;
                    $pid = Db::table("ims_sudu8_page_pic")->insertGetId($data);
                    $arr = array("url"=>$url,"pid"=>$pid);
                    return json_encode($arr);
                }else{
                    // 上传失败获取错误信息
                    return $this->error($file->getError()) ;
                }    
            }
        }else if($remote == 2){
            $qiniu_info = Db::table("ims_sudu8_page_remote")->where("type",2)->where("uniacid",$uniacid)->find();
            $file = $_FILES['uploadfile']['tmp_name'];
            $is_img = getimagesize($file);
            if($is_img){

            }
            $oringal_name = $_FILES['uploadfile']['name'];
           
            $pathinfo = pathinfo($oringal_name);

            // var_dump($pathinfo);exit;
            // 要上传图片的本地路径
            $ext = $pathinfo['extension'];
            $key = 'upimages/'.md5(uniqid(microtime(true),true)).'.'.$ext;
            
            // 需要填写你的 Access Key 和 Secret Key
            $accessKey = $qiniu_info['ak'];
            $secretKey = $qiniu_info['sk'];
            // 构建鉴权对象
            $auth = new Auth($accessKey, $secretKey);
            // 要上传的空间
            $bucket = $qiniu_info['bucket'];
            $domain = $qiniu_info['domain'];
            $token = $auth->uploadToken($bucket);
            // 初始化 UploadManager 对象并进行文件的上传
            $uploadMgr = new UploadManager();
            // 调用 UploadManager 的 putFile 方法进行文件的上传
            list($ret, $err) = $uploadMgr->putFile($token, $key, $file);
            if ($err !== null) {
                echo ["err"=>1,"msg"=>$err,"data"=>""];
            } else {
                //返回图片的完整URL
                $data = array();
                $data['uniacid'] = $uniacid;
                $data['gid'] = $groupid;
                $data['imgurl'] = $ret['key'];
                $data['type'] = 2;
                $pid = Db::table("ims_sudu8_page_pic")->insertGetId($data);
                $arr = array("url"=>$qiniu_info['domain'].'/'.$ret['key'],"pid"=>$pid);
                return json_encode($arr);
            }
        }else if($remote == 3) {
            $qiniu_info = Db::table("ims_sudu8_page_remote")->where("type",3)->where("uniacid",$uniacid)->find();
            $accessKeyId = "<您从OSS获得的AccessKeyId>";
            $accessKeySecret = "<您从OSS获得的AccessKeySecret>";
            $endpoint = "<您选定的OSS数据中心访问域名，例如http://oss-cn-hangzhou.aliyuncs.com>";
            $bucket= " <您使用的Bucket名字，注意命名规范>";
            $object = " <您使用的Object名字，注意命名规范>";
            $content = "Hi, OSS.";
            try {
                $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
                $ossClient->putObject($bucket, $object, $content);
            } catch (OssException $e) {
                print $e->getMessage();
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