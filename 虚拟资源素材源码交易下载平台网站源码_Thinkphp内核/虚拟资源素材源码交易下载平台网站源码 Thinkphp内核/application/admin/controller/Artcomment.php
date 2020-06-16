<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Db;
use app\common\model\Artcomment as ArtcommentModel;

class Artcomment extends AdminBase
{
	protected $commentmodel;
    protected function _initialize()
    {
        parent::_initialize();
        $this->commentmodel = new ArtcommentModel();
    }
    public function index()
    {
		$map=[];
		$keyword=isset($_REQUEST['keyword']) ? trim($_REQUEST['keyword']) : '';
		$open=isset($_REQUEST['open']) ? trim($_REQUEST['open']) : 'all';

		if($open!='all'){
			$map['c.status']=$open;
		}
		if($keyword){
			$map['title|c.content'] = ['like', "%{$keyword}%"];
		}

    	$tptc = $this->commentmodel->alias('c')->join('article a', 'a.id=c.fid')->join('user m', 'm.id=c.uid')->where($map)->field('c.*,a.title,m.username')->order('c.id desc')->paginate(10);
		$this->assign(array('keyword' => $keyword,'open' => $open,'tptc'=>$tptc));
		return $this->fetch('index');
    }
   
  public function delete($id)
    {
    	$info=$this->commentmodel->find($id);
    	Db::name('article')->where('id',$info['fid'])->setDec('reply');
    	$score=getpoint($info['uid'],'commentadd',$id);
    	point_note(0-$score,$info['uid'],'commentdelete',$id);

    	
        if ($this->commentmodel->destroy($id)) {
            	return json(array('code' => 200, 'msg' => '删除成功'));
        } else {
           return json(array('code' => 0, 'msg' => '删除失败'));
        }
    }
    public function alldelete()
    {
    	$params = input('post.');
    foreach ($params['ids'] as $k =>$v){
    		$info=$this->commentmodel->find($v);
    		Db::name('article')->where('id',$info['fid'])->setDec('reply');
    		
    		
    	$score=getpoint($info['uid'],'commentadd',$v);
    	point_note(0-$score,$info['uid'],'commentdelete',$v);	
    		
    	}
    	$ids = implode(',', $params['ids']);
    	  $result = $this->commentmodel->destroy($ids);
    	  if ($result) {
    	  	return json(array('code' => 200, 'msg' => '删除成功'));
    	  } else {
    	  	return json(array('code' => 0, 'msg' => '删除失败'));
    	  }
   }
   public function toggle($id, $status, $name)
   {
	   if ($this->request->isGet()) {

		   if ($this->commentmodel->where('id', $id)->update([$name => $status]) !== false) {
			   //  $this->success('更新成功');
			   return json(array('code' => 200, 'msg' => '更新成功'));
		   } else {
			   // $this->error('更新失败');
			   return json(array('code' => 0, 'msg' => '更新失败'));
		   }
	   }

   }
}