<?php
namespace app\index\controller;

use app\common\controller\HomeBase;
use think\Cache;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Index extends HomeBase
{
    protected $site_config;

    public function _initialize()
    {
        parent::_initialize();
        if (CBOPEN == 2) {
            $this->redirect(url('bbs/index/index'));
        }

        $this->site_config = Cache::get('site_config');
    }

    public function index()
    {


		//板块展示
		$articlecate = Db::name('articlecate')->alias('c')->field('c.alias,c.name')->limit(20)->select();
		$this->assign('articlecate',$articlecate);

		//头条置顶文章
		$toutiao = Db::name('article')->alias('a')->join('user u', 'u.id=a.uid')->join('articlecate c', 'c.id=a.tid')->where("a.open=1 and a.settop=1 and a.choice=1")->field('u.userhead,u.username,a.*,c.template,c.name,c.alias')->limit(6)->order('a.updatetime desc')->select();
		$this->assign('toutiao', $toutiao);//最近更新文章数目限制
		//文章数量统计
		$article_count = Db::name('article')->where("open = 1")->count();
		$this->assign('article_count', $article_count);
		
		//评论数量统计
		$comment_count = Db::name('comment')->count();
		$this->assign('comment_count', $comment_count);
		
		
        //签到榜 //投稿榜 自由打开？
        $member = Db::name('user_sign')->alias('a')->join('user u', 'u.id=a.uid')->field('u.*,count(*) as article')->group('a.uid')->order('article desc')->limit(1)->select();
        $this->assign('member', $member);

		//最近更新
        $article_new = Db::name('article')->alias('a')->join('user u', 'u.id=a.uid')->join('articlecate c', 'c.id=a.tid')->where('a.open', 1)->field('u.userhead,u.username,a.*,c.template,c.name,c.alias')->order('a.time desc')->limit($this->site_config['c_home_newlist'])->select();
        $this->assign('article_new', $article_new);

		//随机文章
		$article_random = Db::name('article')->alias('a')->join('user u', 'u.id=a.uid')->join('articlecate c', 'c.id=a.tid')->where('a.open', 1)->where('a.tid', 9)->field('u.userhead,u.username,a.content,a.id,a.uid,a.title,a.view,a.reply,a.time,c.template,a.coverpic')->orderRaw('rand()')->limit(10)->select();
		$this->assign('article_random', $article_random);
		
		//1天点击排行榜
		$maptop01['open'] = 1;
		$maptop01['time'] = array('egt', strtotime("-1 day"));
		$art_top01 = Db::name('article')->alias('a')->where('a.open', 1)->where('a.tid', 5)->where($maptop01)->join('articlecate c', 'c.id=a.tid')->field('a.id,a.title,a.view,c.template')->order('a.view desc')->limit(10)->select();
		$this->assign('art_top01',$art_top01);
		
		//最近7天点击排行榜
		$maptop07['open'] = 1;
        $maptop07['time'] = array('egt', strtotime("-1 week"));
        $art_top07        = Db::name('article')->alias('a')->where('a.open', 1)->where('a.tid', 5)->join('articlecate c', 'c.id=a.tid')->where($maptop07)->field('a.id,a.view,a.title,a.time,c.template')->order('view desc')->limit(10)->select();
        $this->assign('art_top07', $art_top07);
		
		//最近30天排行榜
        $maptop30['open'] = 1;
        $maptop30['time'] = array('egt', strtotime("-1 month"));
        $art_top30        = Db::name('article')->alias('a')->where('a.open', 1)->where('a.tid', 5)->join('articlecate c', 'c.id=a.tid')->where($maptop30)->field('a.id,a.view,a.title,a.time,c.template')->order('view desc')->limit(10)->select();
        $this->assign('art_top30', $art_top30);
		
		//今日更新数     
		$time=strtotime(date('Y-m-d'));   
		$today_update=Db::name('article')->where("open=1 and updatetime > {$time}")->count();    
		$this->assign('today_update', $today_update);
   
        //分类展示 文字区
        $artbycatelist = Db::name('articlecate')->where('hometextshow=1')->select();
        foreach ($artbycatelist as $k => $v) {
            $artbycatelist[$k]['artlists'] = get_articles_by_cid($v['id'], $this->site_config['c_home_text']);
        }
        $this->assign('artbycatelist', $artbycatelist);
        //分类展示 图片区
        $article_pic = Db::name('articlecate')->where('homepicshow=1')->select();
        foreach ($article_pic as $k => $v) {

            $article_pic[$k]['artlists'] = get_articles_by_cid($v['id'], $this->site_config['c_home_pic']);
        }
        $this->assign('article_pic', $article_pic);

        if ($this->site_config['open_taoke'] == 0) {
            //站长推荐榜
            $mapchoice['open']   = 1;
            $mapchoice['choice'] = 1;
            //$mapchoice['a.tid']=1;
            $art_choice = Db::name('article')->alias('a')->join('articlecate c', 'c.id=a.tid')->where($mapchoice)->field('a.id,a.coverpic,a.view,a.title,a.time,c.template')->order('a.choice desc,a.time desc')->limit(6)->select();
            $this->assign('art_choice', $art_choice);
        }

        return view();
    }

    public function search()
    {
        $ks  = input('ks');
        $kss = urldecode(input('ks'));
        if (empty($ks) || $kss == ' ') {
            return $this->error('亲！你没有输入关键字');
        } else {
            $article      = Db::name('article');
            $open['open'] = 1;

            $map['f.title|f.keywords|f.description|f.content'] = ['like', "%{$kss}%"];
			//阅读排行
			$artphb = $article->alias('a')->join('articlecate c', 'c.id=a.tid')->field('a.*,c.name,c.template')->order('view desc')->limit($this->site_config['c_list_phb'])->select();
			$this->assign('artphb', $artphb);
			//文章推荐
			$artchoice = $article->alias('a')->join('articlecate c', 'c.id=a.tid')->where("choice=1")->field('a.*,c.name,c.template')->order('id desc')->limit($this->site_config['c_list_choice'])->select();
			$this->assign('artchoice', $artchoice);
			//板块展示
			$articlecate = Db::name('articlecate')->alias('c')->field('c.alias,c.name')->limit(20)->select();
			$this->assign('articlecate',$articlecate);
			//最近更新
			$article_new = Db::name('article')->alias('a')->join('user u', 'u.id=a.uid')->join('articlecate c', 'c.id=a.tid')->where('a.open', 1)->field('u.userhead,u.username,a.*,c.template')->order('a.settop desc,a.time desc')->limit($this->site_config['c_home_newlist'])->select();
			$this->assign('article_new', $article_new);
            $tptc = $article->alias('f')->join('articlecate c', 'c.id=f.tid')->join('user m', 'm.id=f.uid')->field('f.*,c.id as cid,m.id as userid,m.userhead,m.username,c.name,c.template')->order('f.id desc')->where($open)->where($map)->paginate(5, false, $config = ['query' => array('ks' => $ks)]);
            $this->assign('tptc', $tptc);
            return view();
        }
    }

    public function errors()
    {
        return view();
    }

    public function article()
    {
        $id = is_number(input('id')) ? input('id') : '';
				//文章数量统计
		$article_count = Db::name('article')->where("open = 1")->count();
		$this->assign('article_count', $article_count);
		
		//板块展示
		$articlecate = Db::name('articlecate')->alias('c')->field('c.alias,c.name')->limit(20)->select();
		$this->assign('articlecate',$articlecate);
		
		//评论数量统计
		$comment_count = Db::name('comment')->count();
		$this->assign('comment_count', $comment_count);
		
		//随机文章
		$article_random = Db::name('article')->alias('a')->join('user u', 'u.id=a.uid')->join('articlecate c', 'c.id=a.tid')->where('a.open', 1)->field('u.userhead,u.username,a.content,a.id,a.uid,a.title,a.view,a.reply,a.time,c.template,a.coverpic')->orderRaw('rand()')->limit(4)->select();
		$this->assign('article_random', $article_random);
		
        //签到榜 //投稿榜 自由打开？
        $member = Db::name('user_sign')->alias('a')->join('user u', 'u.id=a.uid')->field('u.*,count(*) as article')->group('a.uid')->order('article desc')->limit(1)->select();
        $this->assign('member', $member);

        //最近更新
        $article_new = Db::name('article')->alias('a')->join('user u', 'u.id=a.uid')->join('articlecate c', 'c.id=a.tid')->where('a.open', 1)->field('u.userhead,u.username,a.*,c.template')->order('a.settop desc,a.time desc')->limit($this->site_config['c_home_newlist'])->select();
        $this->assign('article_new', $article_new);

        //分类展示 文字区
        $artbycatelist = Db::name('articlecate')->where('hometextshow=1')->select();
        foreach ($artbycatelist as $k => $v) {
            $artbycatelist[$k]['artlists'] = get_articles_by_cid($v['id'], $this->site_config['c_home_text']);
        }
        $this->assign('artbycatelist', $artbycatelist);
        //分类展示 图片区
        $article_pic = Db::name('articlecate')->where('homepicshow=1')->select();
        foreach ($article_pic as $k => $v) {

            $article_pic[$k]['artlists'] = get_articles_by_cid($v['id'], $this->site_config['c_home_pic']);
        }
        $this->assign('article_pic', $article_pic);

        //最近30天排行榜
        $maptop30['open'] = 1;

        $maptop30['time'] = array('egt', strtotime("-1 month"));
        $art_top30        = Db::name('article')->alias('a')->join('articlecate c', 'c.id=a.tid')->where($maptop30)->field('a.id,a.view,a.title,a.time,c.template')->order('view desc')->limit(10)->select();
        $this->assign('art_top30', $art_top30);

        if (empty($id)) {
            return $this->error('亲！你迷路了', 'index/index/index');
        } else {
            $article = Db::name('article');
            $a       = $article->where('open', 1)->find($id);
            if ($a) {
                if ($a['outlink']) {
					$article->where("id", $id)->setInc('view', 1);
                    $this->success('正在跳转到外部页面', $a['outlink'], null, 1);
                }

                $article->where("id", $id)->setInc('view', 1);
                $t = $article->alias('a')->join('articlecate c', 'c.id=a.tid')->join('user m', 'm.id=a.uid')->field('a.*,c.id as cid,c.name,c.template,c.alias,m.id as userid,m.grades,m.point,m.userhead,m.username,m.status')->where('a.id', $id)->find();
                $this->assign('t', $t);
               //阅读排行
				$artphb = $article->alias('a')->join('articlecate c', 'c.id=a.tid')->field('a.*,c.name,c.template')->order('view desc')->limit($this->site_config['c_list_phb'])->select();
				$this->assign('artphb', $artphb);
				//文章推荐
				$artchoice = $article->alias('a')->join('articlecate c', 'c.id=a.tid')->where("choice=1")->field('a.*,c.name,c.template')->order('id desc')->limit($this->site_config['c_list_choice'])->select();
				$this->assign('artchoice', $artchoice);

                //查询当前用户是否收藏该文章
                $iscollect  = 0;
                $commentzan = array();
                $uid        = session('userid');
                if ($uid) {
                    $collect = Db::name('collect')->where(array('uid' => $uid, 'sid' => $id, 'type' => 3))->find();
                    if ($collect) {
                        $iscollect = 1;
                    }
                    //查询用户点赞过的文章评论
                    $commentzan = Db::name('zan')->where(array('uid' => $uid, 'type' => 3))->column('sid');

                }
                //评论
                $tptc = Db::name('artcomment')->alias('c')->join('user m', 'm.id=c.uid')->where("fid = {$id}")->order('c.id asc')->field('c.*,m.id as userid,m.grades,m.attestation,m.point,m.userhead,m.username')->paginate(10, false, ['query' => Request::instance()->param()]);

                $this->assign('tptc', $tptc);

                $this->assign('iscollect', $iscollect);
                $this->assign('commentzan', $commentzan);

                return view();
            } else {
                return $this->error('亲！你迷路了', 'index/index/index');
            }
        }
    }
    public function soft()
    {
        $id = is_number(input('id')) ? input('id') : '';
        if (empty($id)) {
            return $this->error('亲！你迷路了', 'index/index/index');
        } else {
            $article = Db::name('article');
            $a       = $article->where('open', 1)->where("id = {$id}")->find();
            if ($a) {
                $article->where("id = {$id}")->setInc('view', 1);
                $t = $article->alias('a')->join('articlecate c', 'c.id=a.tid')->join('user m', 'm.id=a.uid')->field('a.*,c.id as cid,c.name,c.template,c.alias,m.id as userid,m.grades,m.point,m.userhead,m.username,m.sex,m.status')->where('a.id', $id)->find();
                //阅读排行
                $artphb = $article->where("tid = {$t['tid']}")->order('view desc')->limit($this->site_config['c_view_phb'])->select();
                $this->assign('artphb', $artphb);
                $this->assign('t', $t);
				
				//最近更新
				$article_new = Db::name('article')->alias('a')->join('user u', 'u.id=a.uid')->join('articlecate c', 'c.id=a.tid')->where('a.open', 1)->field('u.userhead,u.username,a.*,c.template')->order('a.settop desc,a.time desc')->limit($this->site_config['c_home_newlist'])->select();
				$this->assign('article_new', $article_new);

				//板块展示
				$articlecate = Db::name('articlecate')->alias('c')->field('c.alias,c.name')->limit(20)->select();
				$this->assign('articlecate',$articlecate);
		
				//随机推荐
				$article_random = Db::name('article')->alias('a')->join('user u', 'u.id=a.uid')->join('articlecate c', 'c.id=a.tid')->where('a.open', 1)->field('u.userhead,u.username,a.content,a.id,a.uid,a.title,a.view,a.reply,a.time,c.template,a.coverpic')->orderRaw('rand()')->limit(4)->select();
				$this->assign('article_random', $article_random);
				
                //查询当前用户是否收藏该文章
                $iscollect  = 0;
                $commentzan = array();
                $uid        = session('userid');
                if ($uid) {
                    $collect = Db::name('collect')->where(array('uid' => $uid, 'sid' => $id, 'type' => 3))->find();
                    if ($collect) {
                        $iscollect = 1;
                    }
                    //查询用户点赞过的文章评论
                    $commentzan = Db::name('zan')->where(array('uid' => $uid, 'type' => 3))->column('sid');

                }
                //评论
                $tptc = Db::name('artcomment')->alias('c')->join('user m', 'm.id=c.uid')->where("fid = {$id}")->order('c.id asc')->field('c.*,m.id as userid,m.grades,m.attestation,m.point,m.userhead,m.username')->paginate(10, false, ['query' => Request::instance()->param()]);

                $this->assign('tptc', $tptc);
                $this->assign('iscollect', $iscollect);
                $this->assign('commentzan', $commentzan);
                return view();
            } else {
                return $this->error('亲！你迷路了', 'index/index/index');
            }
        }
    }
    public function page()
    {
        $id = is_number(input('id')) ? input('id') : '';
        if (empty($id)) {
            return $this->error('亲！你迷路了', 'index/index/index');
        } else {
            $article = Db::name('article');
            $a       = $article->where('open', 1)->where("id = {$id}")->find();
            if ($a) {
                $article->where("id = {$id}")->setInc('view', 1);
                $t = $article->alias('a')->join('articlecate c', 'c.id=a.tid')->join('user m', 'm.id=a.uid')->field('a.*,c.id as cid,c.name,c.template,c.alias,m.id as userid,m.grades,m.point,m.userhead,m.username,m.sex,m.status')->where('a.id', $id)->find();
               // print_r($t);
                $this->assign('t', $t);
            }
			//板块展示
		$articlecate = Db::name('articlecate')->alias('c')->field('c.alias,c.name')->limit(20)->select();
		$this->assign('articlecate',$articlecate);
            return view();
        }
    }
}
