<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Db;
use app\common\model\Log as LogModel;

class Log extends AdminBase
{
	protected $logmodel;
    protected function _initialize()
    {
        parent::_initialize();
        $this->logmodel = new LogModel();
    }
    public function index($keyword = '', $page = 1)
    {
    
    	$map = [];
    	if ($keyword) {
    		session('logkeyword',$keyword);
    		$map['l.username'] = ['like', "%{$keyword}%"];
    	}else{
    		
    		if(session('logkeyword')!=''&&$page>1){
    			$map['l.username'] = ['like', "%".session('logkeyword')."%"];
    		}else{
    			session('logkeyword',null);
    		}
    		
    		
    	}
    
    	$tptc = $this->logmodel->alias('l')->join('auth_rule ar', 'ar.name=l.controller')->where($map)->field('l.*,ar.title,ar.pid')->order('l.id desc')->paginate(10);
    	foreach ($tptc as $k =>$v){
    		if($v['pid']==0){
    			$tptc[$k]['pcontroller']='顶级';
    		}else{
    			$tptc[$k]['pcontroller']=Db::name('auth_rule')->where('id',$v['pid'])->value('title');
    		}
    		
    		
    	}
    	$this->assign('keyword', $keyword);
    	$this->assign('tptc', $tptc);
    	return view();
    }
   
  public function delete($id)
    {
    	$info=$this->logmodel->find($id);
    	

    	
        if ($this->logmodel->destroy($id)) {
            	return json(array('code' => 200, 'msg' => '删除成功'));
        } else {
           return json(array('code' => 0, 'msg' => '删除失败'));
        }
    }
    public function alldelete()
    {
    	$params = input('post.');

    	$ids = implode(',', $params['ids']);
    	  $result = $this->logmodel->destroy($ids);
    	  if ($result) {
    	  	return json(array('code' => 200, 'msg' => '删除成功'));
    	  } else {
    	  	return json(array('code' => 0, 'msg' => '删除失败'));
    	  }
   }
}