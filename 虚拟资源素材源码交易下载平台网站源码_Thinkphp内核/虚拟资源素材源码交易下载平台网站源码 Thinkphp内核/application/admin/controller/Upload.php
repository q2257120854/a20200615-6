<?php
namespace app\admin\controller;
use app\common\model\Upload as UploadModel;

use app\common\controller\AdminBase;
class Upload extends AdminBase
{
    function _initialize()
    {
    	
        parent::_initialize();
        $this->model =new UploadModel();
    }
    public function upimage()
    {
    	
   // return 	$this->model->upfile('images');
    	 return json($this->model->upfile('images'));
    }
    public function upfile()
    {
        return json($this->model->upfile('files'));
    }
    public function layedit_upimage()
    {
        $result = $this->model->upfile('layedit', 'file', true);
        if ($result['code'] == 200) {
            $data = array('code' => 0, 'msg' => '上传成功', 'data' => array('src' => $result['path'], 'title' => $result['info']['name']));
        } else {
            $data = array('code' => 1, 'msg' => $result['msg']);
        }
        return json($data);
    }
    public function umeditor_upimage()
    {
        $result = $this->model->upfile('umeditor', 'upfile', true);
        if ($result['code'] == 200) {
            $data = array("originalName" => $result['info']['name'], "name" => $result['savename'], "url" => $result['path'], "size" => $result['info']['size'], "type" => $result['info']['type'], "state" => "SUCCESS");
        } else {
            $data = array("originalName" => $result['info']['name'], "name" => $result['savename'], "url" => $result['path'], "size" => $result['info']['size'], "type" => $result['info']['type'], "state" => $result['msg']);
        }
        echo json_encode($data);
        exit;
    }
}