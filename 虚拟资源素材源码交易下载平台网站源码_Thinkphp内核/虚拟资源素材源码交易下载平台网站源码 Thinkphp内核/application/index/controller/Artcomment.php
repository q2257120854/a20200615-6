<?php
namespace app\index\controller;

use app\common\controller\HomeBase;
use app\index\model\Artcomment as ArtcommentModel;
use think\Db;
use think\Cache;

class Artcomment extends HomeBase
{
	public function _initialize()
	{
		parent::_initialize();
	}
    public function add()
    {
    	
        if (!session('userid') || !session('username')) {
            $this->error('亲！请登录');
        } else {

            $res = hook('watercheck',array('type'=>2,'id'=>input('id')),true,'type'); 
            if($res&&isset($res['code'])){                
               if($res['code']==0) $this->error($res['msg'],$_SERVER["HTTP_REFERER"],'',10);	
            }
        	$site_config = Cache::get('site_config');
            $comment = new ArtcommentModel;
            $id = input('id');
            $uid = session('userid');
            if (request()->isPost()) {
            	if(session('userstatus')!=2&&session('userstatus')!=5&&$site_config['email_sh'] ==0){
            		return json(array('code' => 0, 'msg' => '您的邮箱还未激活'));
            	}       	
            	
                $data = input('post.');
                $data['content']= remove_xss($data['content']);
                if(!trim($data['content'])){
                    return json(array('code' => 0, 'msg' => '内容不能为空'));
                }
                $msg='';
               
                //查看评论是否是
                if (isset($site_config['reply_sh'])&&$site_config['reply_sh'] != 0) {
                    if($site_config['reply_sh']==1){
                        $data['status'] = 0;
                        $msg='，但需要管理员审核才能发布';
                    }else if($site_config['reply_sh']==2&&isset($site_config['reply_keywords'])){

                        $keywords=explode(',',$site_config['reply_keywords']);
                        if(count($keywords)){
                            foreach($keywords as $v){
                                 if(strpos($data['content'], $v)!==false){
                                    $data['status'] = 0;  
                                    $msg='，由于含有不允许发布的关键字，需要管理员审核才能发布';
                                    break;
                                 }   
                            }
                        }
                    }
                } 

                $data['time'] = time();
                $data['fid'] = $id;
                $data['uid'] = session('userid');
				$member = Db::name('user');
				$model = Db::name('article');

                $model->where('id', $id)->setInc('reply', 1);
                //文章作者
                $zuid=$model->where('id', $id)->value('uid');
                if(session('userid')!=$zuid){
                    send_message(session('userid'),$zuid,$id,4); 
                }
            
				
                if ($comment->add($data)) {
                	point_note($site_config['jifen_comment'],session('userid'),'commentadd',$comment->id);
                    return json(array('code' => 200, 'msg' => '评论成功'.$msg));
                } else {
                    return json(array('code' => 0, 'msg' => '评论失败'));
                }
            }
        }
    }
	public function reply()
    {
        if (!session('userid') || !session('username')) {
            $this->error('亲！请登录');
        } else {
            $res = hook('watercheck',array('type'=>3,'id'=>input('id')),true,'type'); 
            if($res&&isset($res['code'])){                
               if($res['code']==0) $this->error($res['msg'],$_SERVER["HTTP_REFERER"],'',10);	
            } 

            $id = input('tid');
            session('artcommentid',$id);     
            $uid = session('userid');
            $comment = new ArtcommentModel;
            $site_config = Cache::get('site_config');
            $a = $comment->find($id);
            if (empty($id) || $a == null ) {
                $this->error('亲！您迷路了');
            } else {
                if (request()->isPost()) {
                    $data = input('post.');
                    $data['tid']=remove_xss($data['tid']);
                    $data['reply']=1;
                    $data['uid']=$uid;
                    $data['time']=time();
                    session('artcommentid', null);
                    $data['content']= remove_xss($data['content']);
                    $msg='';
                    //查看评论是否是
                    if (isset($site_config['reply_sh'])&&$site_config['reply_sh'] != 0) {
                        if($site_config['reply_sh']==1){
                            $data['status'] = 0;
                            $msg='，但需要管理员审核才能发布';
                        }else if($site_config['reply_sh']==2&&isset($site_config['reply_keywords'])){
    
                            $keywords=explode(',',$site_config['reply_keywords']);
                            if(count($keywords)){
                                foreach($keywords as $v){
                                     if(strpos($data['content'], $v)!==false){
                                        $data['status'] = 0;  
                                        $msg='，由于含有不允许发布的关键字，需要管理员审核才能发布';
                                        break;
                                     }   
                                }
                            }
                        }
                    } 
                    if ($comment->insert($data)) {
                        return json(array('code' => 200, 'msg' => '回复成功'.$msg));
                    } else {
                        return json(array('code' => 0, 'msg' => '回复失败'));
                    }
                }
                $tptc = $comment->alias('c')->join('article f', 'f.id=c.fid')->field('c.*,f.title')->find($id);
		        $this->assign('tptc', $tptc);
                return view();
            }
        }
    }

   
}