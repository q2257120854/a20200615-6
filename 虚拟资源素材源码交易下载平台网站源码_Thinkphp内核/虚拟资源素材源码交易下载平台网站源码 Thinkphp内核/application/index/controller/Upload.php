<?php
namespace app\index\controller;
use app\common\model\Upload as UploadModel;

use app\common\controller\HomeBase;
class Upload extends HomeBase
{
    function _initialize()
    {
    	
        parent::_initialize();
        $this->model =new UploadModel();
    }
    public function upimage()
    {

    	 return json($this->model->upfile('images'));
    }
    public function upfile()
    {
        return json($this->model->upfile('files'));
    }
    public function upattach()
    {
       
        return json($this->model->upfile('files','file','attach'));
     
    
    }
    public function wangeditor_upimage()
    {
        if (!session('userid') || !session('username')) {
            $this->error('亲！请登录', url('user/login/index'));
        } else {

            $info = $this->model->upfile("images", "FileName");
            return $info['headpath'];

        }
    }
}