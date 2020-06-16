<?php  
//账号管理控制器
Class  ShopAction extends CommonAction{

    //商品列表
    public function plist(){
			$type = M("type");
			$product = M("product");

			if($_GET['id']){	
               $where = "tid={$_GET['id']}";
            }else{
				$where = "1=1";
			}		   
		     $where.=" and is_on = 0" ;   
			
			   
			     import('ORG.Util.Page');
				$count = $product -> where($map)->count();
				$Page  = new Page($count,14);
				$show = $Page -> show();
				$typeData = $product -> where($where) ->order("id asc") -> limit($Page ->firstRow.','.$Page -> listRows) -> select();
			
			
			//遍历主栏目
			$type =M('type');
			$data = $type -> where("pid=0") -> select();
	
			$this ->assign("page",$show);
			$this ->assign("types",$data);
			$this->assign("typeData",$typeData);
			
		
        $this->display();
    }
	//购物商城 
    public function shop(){
        $f = M('Goods');
        $goods = $f -> order('gissuetime asc')->select();
        foreach ($goods as $key => $value) {   
			$pics = explode(',', $value['gpic']);
			$goods[$key]['gpic'] = $pics[0];
		}
		$banner_list=M('shopbanner')->order('sort DESC')->select();

        $this -> assign('banner_list',$banner_list);
        $this -> assign('goods',$goods);
        $this -> display();
    }

	//购物商城分类页
    public function search(){
		//S('gouwuche_' . $_SESSION['mid'],null);
		$cid = (int)I('get.cid');
		
		$classifydata = M('classify');
		$classdata = $classifydata->field('cid,cname')->where('parentid=0')->order('cid desc')->select();
		$children = $classifydata->field('cid')->where(['parentid'=>$cid])->select();
		$chil_arr = [];
		foreach($children as $key => $val){
			array_push($chil_arr, $val['cid'] );
		}
		array_push($chil_arr, $cid );

		$gao = C('max_danjia');
		$rmb_hl = C('rmb_hl');
		
		$goods_model = M('goods');
		
		if(isset($cid) && !empty($cid)){
			$where = ['gclassification' => ['in',$chil_arr]];
		}else{
			$where = "1 = 1";
		}

		$goods_list = $goods_model->field('gid,gclassification cid,gname,gpic,goldprice,gsellnums,gattribute attr')->where($where)->order('gid DESC')->select();
		foreach ($goods_list as $key => $value) {
            $pics = explode(',', $value['gpic']);
            $goods_list[$key]['gpic'] = $pics[0];
        }
		foreach($goods_list as $key => &$r){
			$r['spjiage']=sprintf("%.2f", $r['goldprice'] / $rmb_hl / $gao);
		}
        $this->goods_list = $goods_list;
		$this->assign('classdata',$classdata);
		$this->cid = $cid;
        $this -> display();
    }
	//产品详情页
	public function index(){
		$items = M('goods');
		$gao = C('max_danjia');
		$rmb_hl = C('rmb_hl');
		$itemsdata = $items->find($_GET['gid']);
		$spjiage = sprintf("%.2f", $itemsdata['goldprice'] / $rmb_hl / $gao);
		// 商品的缩略图
		$sxw_goodsPic = explode(',', $itemsdata['gpic']);
		// 实例化评价表
		$list2 = M('goodsreview');
		// 计算一共有多少个
		$total = $list2->field('integral')->where($_GET)->select();
		$count = $list2->where($_GET)->count();
		$sum = 0;
		$sum1 = 0;
		// 计算评价的等级
		foreach ($total as $value) {
			$sum +=5;
			$sum1 += $value['integral'];
		}
		// 将等级发送前台
		$nums  = ($sum1/$sum)*100;
		// 遍历用户评论
		$reviewlist = M();
		$reviewdata = $reviewlist->table('sx_member m,sx_goodsreview r')->field('m.uname,r.integral,r.content')->where('r.uid=m.uid and r.gid='.$_GET['gid'])->order('r.rid desc')->limit(20)->select();
		// 遍历同品牌的商品
		$branddata = $items->where('bid='.$itemsdata['bid'].' and gid!='.$_GET['gid'])->field('gid,gpic,gname,goldprice')->order('gsellnums desc')->limit(5)->select();
		// 循环修改图片
		foreach ($branddata as $key => $value) {
			$branddata[$key]['gpic'] = explode(',', $value['gpic'])[0];
		}
		
		//检查该产品是否已经存在购物车中
		$gouwuche = S('gouwuche_' . $_SESSION['mid']);
		$flag = false;
		
		if(!empty($gouwuche)){
			foreach($gouwuche as $key => $val){
				if($_GET['gid'] == $val['gid']) $flag = true;
			}
		}
		
		$this->assign('flag', $flag);
		$this->assign('branddata',$branddata);
		$this->assign('spjiage',$spjiage);
		$this->assign('reviewdata',$reviewdata);
		$this->assign('nums',$nums);
		$this->assign('count',$count);
		$this->assign('line',$line);
		// 商品的基本信息
		// 将商品数据放往前台
		$this->assign('item',$itemsdata);
		$this->assign('title',$itemsdata['gname']);
		// 将图片路径发往前台
		$this->assign('sxw_goodsPic',$sxw_goodsPic);
		$this->display('item');
	}
	//超市
	public function shopmarket(){
		$goods_model = M('goods');
		$goods_list = $goods_model->field('gid,gclassification cid,gname,gpic,goldprice,gsellnums,gattribute attr')->order('gid DESC')->select();
		foreach ($goods_list as $key => $value) {
            $pics = explode(',', $value['gpic']);
            $goods_list[$key]['gpic'] = $pics[0];
        }
        $this->goods_list = $goods_list;
		$this->display();
	}       

	//加入购物车
	public function addgouwuche(){
		$gid = (int)I('post.gid');
		$goods_model = M('goods');
		$mid = $_SESSION['mid'];
		
		if(isset($gid) && !empty($gid)){
			$goods_info = $goods_model->where(['gid'=>$gid])->find();
			
			if(!empty($goods_info)){
				$data = [
					'gid' => $gid, // 商品ID
					'mid' => $mid, // 用户ID
					'nums'=> 1, // 数量
					'price' => $goods_info ['goldprice'] //单价
				];
				
				//购物车是否已经有产品
				$gouwuche = S('gouwuche_' . $mid);
				
				if(!empty($gouwuche)){
					array_push($gouwuche, $data);
					S('gouwuche_' . $mid, $gouwuche);
				}else{
					$gouwuche['0'] = $data;
					S('gouwuche_' . $mid, $gouwuche);
				}
				
				$ajax_data = [
					'status'  => 1,
					'message' => '加入购物车成功！'
				];
			}else{
				$ajax_data = [
					'status'  => -1,
					'message' => '商品不存在！'
				];				
			}
		}else{
			$ajax_data = [
				'status'  => -1,
				'message' => '参数错误！'
			];
		}
		
		$this->ajaxReturn($ajax_data);
	}
	
	//购物车
    public function gouwuche(){
		$gid = (int)I('get.gid');
		
		$gao = C('max_danjia');
		$rmb_hl = C('rmb_hl');
		
		if(isset($gid) && !empty($gid)){
			
			$goods_info = M('goods')->where(['gid'=>$gid])->select();
			foreach($goods_info as $key => &$r){
				$r['spjiage']=sprintf("%.2f", $r['goldprice'] / $rmb_hl / $gao);
			}
			$jiage = M('goods')->where(['gid'=>$gid]) ->field('goldprice,gname,gid') ->find();
				

			$spjiage=sprintf("%.2f", $jiage['goldprice'] / $rmb_hl / $gao);
			$gid1 = $jiage['gid'];
			$jiages = $jiage['goldprice'];
			$gname = $jiage['gname'];
			if(!empty($goods_info)){
				foreach ($goods_info as $key => $value) {
		            $pics = explode(',', $value['gpic']);
		            $goods_info[$key]['gpic'] = $pics[0];
		            $goods_info[$key]['nums'] = 1;
		        }				
				$this->cartdata = $goods_info;

				$this->assign('spjiage',$spjiage);
				$this->assign('gid1',$gid1);
				$this->assign('jiages',$jiages);
				$this->assign('gname',$gname);
				$this->display();
			}else{
				die('商品不存在！');
			}
			
		}else{
			die('缺少参数！');
		}
    }
	/**
	*却结算按钮判断
	*/
	public function checkButton(){
		if (session('mid')) {
			echo 1;
			return;
		}
		echo 0;	
	}    
	//我的订单
    public function dingdan(){
		$orders = M('orders');
		$uid = session('mid');
		$orders_info=$orders->where(array('uid'=>$uid))->order('otime desc')->select();
		$this -> assign('orders_info',$orders_info);
        $this -> display();
    }
	//待发货
    public function daifa(){
		$orders = M('orders');
		$uid = session('mid');
		$orders_info=$orders->where(array('uid'=>$uid,'status'=>0))->order('otime desc')->select();
		$this -> assign('orders_info',$orders_info);
        $this -> display();
    }
	//待收货
    public function daishou(){
		$orders = M('orders');
		$uid = session('mid');
		$orders_info=$orders->where(array('uid'=>$uid,'status'=>1))->order('otime desc')->select();
		$this -> assign('orders_info',$orders_info);
        $this -> display();
    }
	//已完成订单
    public function wancheng(){
		$orders = M('orders');
		$uid = session('mid');
		$orders_info=$orders->where(array('uid'=>$uid,'status'=>2))->order('otime desc')->select();
		$this -> assign('orders_info',$orders_info);
        $this -> display();
    }
	
	//取消订单
	public function deldingdan(){
		$onumber = I('onumber');
		$orders = M("orders");
		$username = session('username');
		$orders_info = $orders->where(array('onumber'=>$onumber))->find();
		
		$inc = M('member') -> where(array('id'=>$orders_info['uid']))->setInc('jinbi',$orders_info['total']);
		account_log($username,$orders_info['total'],'商品买家取消订单返回',1);	
		
		$dec = M('member') -> where(array('id'=>$orders_info['uid']))->setDec('qjinbi',$orders_info['total']);
		account_log4($username,$orders_info['total'],'商品买家取消订单扣除',0);	
			
		$map['onumber'] = array('eq',$onumber);

		if($orders -> where($map) -> delete()){

			alert('取消订单成功',U('Index/Shop/dingdan'));
		}else{
			alert('取消订单失败',U('Index/Shop/dingdan'));
		}
	}
	//确认收货
	public function shouhuo(){
		$onumber = I('onumber');
		$orders = M("orders");
		$username = session('username');
		$orders_info = $orders->where(array('onumber'=>$onumber))->find();
		
		$obs = M('member')->where(array('id'=>$orders_info['uid']))->setDec('qjinbi',$orders_info['total']);
		account_log4($username,$orders_info['total'],'商品交易订单完成扣除',0);
		
		$shangjia = M('member')->where(array('username'=>$orders_info['username']))->find();
		
		$sxf = M("shop_group")->where(array("level"=>$shangjia['shoplevel']))->getField("shouxu");
		$lkb = $orders_info['total'] - $orders_info['total'] *$sxf/100;
		
		$oob = M('member')->where(array('username'=>$orders_info['username']))->setInc('jinbi',$lkb);	
		account_log($orders_info['username'],$lkb,'商品交易订单完成获得',1);	
		
		$map['onumber'] = array('eq',$onumber);
		$shou['status'] =2;
		if($orders -> where($map) -> save($shou)){

			alert('确认收货成功',U('Index/Shop/dingdan'));
		}else{
			alert('确认收货失败',U('Index/Shop/dingdan'));
		}
	}
	//商城加盟
    public function jiameng(){
		$member = M('member')->where(array('username'=>session('username')))->field('username,jinbi,truename,mobile,shopstatus,shopname,shoplevel')->find();
		$shop_group = M('shop_group')->select();
		//$jinbi = $member['jinbi'];
        $this -> assign('member',$member);

        $this -> assign('shop_group',$shop_group);
        $this -> display();
    }

	//提交商城加盟
    public function tijiaojiameng(){
		
		if(IS_POST){
			$data['shopname']     = I('post.shopname','','htmlspecialchars');
			$data['shoplevel']     = I('post.shoplevel','','htmlspecialchars');
			$password2   = I('post.password2','','md5');
			if(empty($data['shopname'])){
				alert('请输入商户名称',U('Index/Shop/jiameng'));
            }	
			if(empty($data['shoplevel'])){
				alert('请输入加盟等级',U('Index/Shop/jiameng'));
            }	
			$members = M('member');
			if (!$members->where(array('username'=>session('username'),'password2'=>$password2))->getField('id')) {
				alert('对不起!二级密码不正确!',U('Index/Shop/jiameng'));				
			}		
			$shop_group = M('shop_group')->where(array('level'=>$data['shoplevel']))->getField('price');
			
			$username = session('username');
			$member = M('member')->where(array('username'=>$username))->field('id,level,jinbi')->find();
			
			if($member['level']==0){
				alert('请先完善个人资料提交系统审核！',U('personal_set/myInfo'));	
			} 
			if($member['jinbi'] < $shop_group){
				alert('您的余额不足，请前往商城购买CTC币',U('Index/Emoney/index'));
			
			}else{
				$data['shopstatus'] = 1;
				$data['uname'] = session('username');
				$data['uid'] = $member['id'];
				$xiu=M('member')->where(array('username'=>$username))->save($data);
				if(empty($xiu)){
					alert('入驻失败，请重新提交',U('Index/Shop/jiameng'));
				}else{
					M('member')->where(array('username'=>$username))->setDec('jinbi',$shop_group);
					shangcheng_log($username,$shop_group,'开通商城',0);		
				}
			}
			alert('加盟成功，钻石链有你更精彩',U('Index/Shop/jiameng'));
		}
    }
	
	//加盟商等级升级
    public function shengji(){
		$member = M('member')->where(array('username'=>session('username')))->field('username,jinbi,truename,mobile,shopstatus,shopname,shoplevel')->find();
		$dengji = $member['shoplevel'];
		$shop_group = M('shop_group')->where("level > {$dengji}")->select();

        $this -> assign('member',$member);

        $this -> assign('shop_group',$shop_group);
		$this->display();
    }
	//提交升级请求
    public function tijiaoshengji(){
		
		if(IS_POST){
			$data['shoplevel']     = I('post.shoplevel','','htmlspecialchars');
			$password2   = I('post.password2','','md5');
			
			if(empty($data['shoplevel'])){
				alert('请输入要升级的等级',U('Index/Shop/shengji'));
            }	
			$members = M('member');
			if (!$members->where(array('username'=>session('username'),'password2'=>$password2))->getField('id')) {
				alert('对不起!二级密码不正确!',U('Index/Shop/shengji'));				
			}		
			$shop_group = M('shop_group')->where(array('level'=>$data['shoplevel']))->getField('price');
			
			$username = session('username');
			$member = M('member')->where(array('username'=>$username))->field('id,level,jinbi,shoplevel')->find();
			$shop_group1 = M('shop_group')->where(array('level'=>$member['shoplevel']))->getField('price');//已加盟的价格
			
			$shop_group2 = $shop_group - $shop_group1;
			
			if($member['level']==0){
				alert('请先完善个人资料提交系统审核！',U('personal_set/myInfo'));	
			} 
			if($member['jinbi'] < $shop_group2){
				alert('您的余额不足，请前往商城购买MHC币',U('Index/Emoney/index'));
			
			}else{
				$data['shopstatus'] = 1;
				$data['uname'] = session('username');
				$data['uid'] = $member['id'];
				$xiu=M('member')->where(array('username'=>$username))->save($data);
				if(empty($xiu)){
					alert('升级失败，请重新提交',U('Index/Shop/shengji'));
				}else{
					M('member')->where(array('username'=>$username))->setDec('jinbi',$shop_group2);
					shangcheng_log2($username,$shop_group2,'升级加盟等级',0);		
				}
			}
			alert('升级成功，养生链有你更精彩',U('Index/Shop/jiameng'));
		}
    }
	//平台签到奖励
	public function qiandao(){

			 
			$s_time=strtotime(date("Y-m-d 00:00:01"));
			$o_time=strtotime(date("Y-m-d 23:59:59"));
			$user_id = session('mid');
			$username = session('username');
			$jiangli = C('qdjiangli');
			$qdzs = C('qdzs');
			$info = '签到奖励';
			
			$todayData = M('members_sign')->where("stime > {$s_time} and stime < {$o_time}")->count();    
			$grtodayData = M('members_sign')->where("stime > {$s_time} and stime < {$o_time} and user_id  = {$user_id} ")->count();    //个人签到与否
			

			if($todayData < $qdzs){   
			
				if($grtodayData == 1){      
					alert('您今日已经签过到了,快去推广吧!',U('Index/Emoney/shouye'));					
				}else{      
				     
					$map['user_id'] = session('mid');
					$map['username'] = session('username');
					$map['jiangli'] = C('qdjiangli');
					$map['stime'] = time();     
					$map['desc'] = $info;     
					$id = M('members_sign')->add($map);    
				
					if($id){    
						M('member') -> where(array('id'=>session('mid')))->setInc('jinbi',$jiangli);
						
						qiandao_log($user_id,$username,$jiangli,$info);
 						alert('签到成功,获得'. $jiangli .'个币的签到奖励,快去推广吧!',U('Index/Emoney/shouye'));	
						}else{      
						alert('签到失败,请刷新重试!',U('Index/Emoney/shouye'));	
						} 		
				}
			}else{
					alert('每天最多签到'. $qdzs .'人次!',U('Index/Emoney/shouye'));	
				}    
 
			

	}
	//商品详情
	
	public function pcontent(){
		
		$id =  I('get.id',0,'intval');
		$type = M('type');
		$product = M("product");
		
	   
		$data = $product -> find($id);
        if(empty($data)){
			
			alert('信息不存在',U('Index/Shop/plist'));
		}
		$this -> assign('product',$data);			
		
		$this->display();
	}
   //订单提交页面
   public function tijiaodingdan(){
	   

		if(IS_POST){
			$data['jiage']     = I('post.jiage','','htmlspecialchars');
			$data['gid']     = I('post.gid','','htmlspecialchars');
			$data['gname']     = I('post.gname','','htmlspecialchars');
			$data['name']     = I('post.name','','htmlspecialchars');
			$data['photo']     = I('post.photo','','htmlspecialchars');
			$data['remarks']     = I('post.remarks','','htmlspecialchars');
			$data['address']     = I('post.address','','htmlspecialchars');
			$password2    = I('post.password2','','md5');

		
			if(empty($data['name'])){
				echo '<script>alert("请输入收货人姓名！");window.history.back(-1);</script>';
				die;
            }	
			if(empty($data['photo'])){
				echo '<script>alert("请输入收货人电话！");window.history.back(-1);</script>';
				die;
            }	
			if(empty($data['address'])){
				echo '<script>alert("请输入收货人地址！");window.history.back(-1);</script>';
				die;
            }	
			if(empty($password2)){
				echo '<script>alert("请输入交易密码！");window.history.back(-1);</script>';
				die;
            }	
			$members = M('member');
			if (!$members->where(array('username'=>session('username'),'password2'=>$password2))->getField('id')) {	
				echo '<script>alert("对不起!二级密码不正确!");window.history.back(-1);</script>';
				die;				
			}	
			
	      $userinfo = M("member")->where(array("username"=>session("username")))->find();
			if($userinfo['level']==0){
				alert('请先完善个人资料提交系统审核！',U('personal_set/myInfo'));
			}
		  
			if($userinfo['checkstatus']==2){
				alert('账户信息审核失败,请先完善个人资料提交系统审核！',U('personal_set/myInfo'));
			}
		  
		  
			if($userinfo['checkstatus']!=3){
				alert('资料信息正在审核！',U('personal_set/myInfo'));
			}
		  
			 $jinbi = getMemberField('jinbi');			 
			 if($jinbi < $data['jiage']){
				echo '<script>alert("账户余额不足！");window.history.back(-1);</script>';
				die;
			 }	

			$username = M('goods')->where(array('gid'=>$data['gid']))->getField('username');

			// 读取当前登陆用户
			$uid = $_SESSION['mid'];
			// 重新构造post用于保存至订单表
			$_POST['onumber'] = date('YmdHis',time()).rand(10,99);//订单号
			$_POST['username'] = $username;//收货人id
			$_POST['uid'] = $uid;//收货人id
			$_POST['name'] = $data['name'];//收货人姓名
			$_POST['photo'] = $data['photo'];//收货人手机号
			$_POST['total'] = $data['jiage'] ;//价格
			$_POST['shangname'] = $data['gname'];//商品名称
			$_POST['remarks'] = $data['remarks'] ;//备注信息
			$_POST['otime'] = date('Y-m-d',time());//订单时间
			$_POST['paymethod'] = 1;//支付状态
			$_POST['deliveryaddress'] = $data['address'];//订单收货人地址
		
			// 实例化订单表
			$orderlist = M('orders');
			// 插入数据，返回插入数据的订单号
			$oid = $orderlist->add($_POST);
			if ($oid) {
				M("member")->where(array('username'=>session('username')))->setDec('jinbi',$data['jiage']);
				account_log(session('username'),$data['jiage'],'购买商品'.$data['gname'],0);
				M("member")->where(array('username'=>session('username')))->setInc('qjinbi',$data['jiage']);
				account_log4(session('username'),$data['jiage'],'冻结购买商品'.$data['gname'],1);		
				alert('购买成功，钻石链有你更精彩',U('Index/Shop/dingdan'));
			}
		}
   }
   //订单提交页面
   public function buy(){
	   
	      $userinfo = M("member")->where(array("username"=>session("username")))->find();
		  if($userinfo['level']==0){
			  alert('请先完善个人资料提交系统审核！',U('personal_set/myInfo'));
		  }
		  
		   if($userinfo['checkstatus']==2){
			  alert('账户信息审核失败,请先完善个人资料提交系统审核！',U('personal_set/myInfo'));
		  }
		  
		  
		   if($userinfo['checkstatus']!=3){
			  alert('资料信息正在审核！',U('personal_set/myInfo'));
		  }
		  
		  
	      $product = M("product");

		  $id =  I('get.id',0,'intval');
		  //查询矿机信息
		  $data = $product -> find($id);
		  if(empty($data)){
			  alert('信息不存在',U('Shop/plist'));
		  }		
		  $suanli = $userinfo['mygonglv'] + $data['gonglv'];
		  $mysuanli = M("member_group")->where(array("level"=>$userinfo['level']))->getField("mysuanli");
		  
		  if($suanli>$mysuanli){
			  alert('超过您的最大可拥有算力'.$mysuanli.',不能购买',U('Shop/plist'));
			  
		  }
		  
		  //判断 是否已经达到限购数量
		  
		  $my_gounum=M("order")->where(array("user"=>session('username'),"sid"=>$id))->count();
		
		  if($my_gounum >=$data['xiangou']){
			    echo '<script>alert("已经达到你购买本矿机上线！");window.history.back(-1);</script>';
				die;
				  
		  }  //统计是否有符合数量的免费合约机
	   	 $zs_count = M("order")->where(array("user"=>session('username'),"sid"=>1))->count();
	   	 $zs_counts = M("order")->where(array("sid"=>1))->count();
		 if($zs_counts >= C("z_num")){
				echo '<script>alert("此类型免费矿机已赠送完毕！");window.history.back(-1);</script>';
				die;					

			}
			
		 if($zs_count >= C('zs_num') && $id==1){
				echo '<script>alert("你已经拥有足够数量的免费矿机！");window.history.back(-1);</script>';
				die;
		 }else{
			 $jinbi = getMemberField('jinbi');		
			 if($jinbi < $data['price']){
				echo '<script>alert("账户余额不足！");window.history.back(-1);</script>';
				die;
			 }	
/*              if($id==1){
				if($zs_count >= C("z_num")){
					echo '<script>alert("此类型合约机已达上限！");window.history.back(-1);</script>';
					die;					

				}
			 } */	
			 
			  M("member")->where(array('username'=>session('username')))->setDec('jinbi',$data['price']);
			  account_log(session('username'),$data['price'],'购买'.$data['title'],0);					 
		 }
		  
	  
          $map = array();
         // $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');		  
          $map['kjbh'] = 'S' . date('d') . substr(time(), -5) . sprintf('%02d', rand(0, 99));
		  $map['user'] = session('username');
		  $map['user_id'] = session('mid');
		  $map['project']= $data['title'];
		  $map['sid'] = $data['id'];
		  $map['yxzq'] = $data['yszq'];		
          $map['sumprice'] = $data['price'];
		  $map['addtime'] = date('Y-m-d H:i:s');	
          $map['imagepath'] = $data['thumb'];
		  $map['lixi']	= $data['gonglv'];
		  $map['kjsl'] =  $data['shouyi'];
          $map['zt'] =  1;	
          $map['UG_getTime'] =  time();		  
		  M('order')->add($map);		
		  $product->where(array("id"=>$id))->setDec("stock");
		  //写入上级团队算力
				$parentpath = M("member")->where(array("username"=>session('username')))->getField("parentpath");
				$path2 = explode('|', $parentpath);
		        array_pop($path2);
			    $parentpath = array_reverse($path2);
	            foreach($parentpath as $k=>$v){
					 M("member")->where(array('id'=>$v))->setInc("teamgonglv",$map['lixi']);
                }	
		   //写入个人算力
		  M("member")->where(array("username"=>session('username')))->setInc("mygonglv",$map['lixi']);
          //updateLevel();				
	      alert('矿机购买成功',U('Shop/orderlist'));
   }
 
   	//订单列表
	public function orderlist(){
		import('ORG.Util.Page');
		$count = M('order') ->where(array('user'=>session('username')))->count();
		$Page  = new Page($count,10);
		$Page->setConfig('theme', '%first% %upPage% %linkPage% %downPage% %end%');
		$show = $Page -> show();		
	 
        $list = M('order')->where(array('user'=>session('username')))->order('id desc') -> limit($Page ->firstRow.','.$Page -> listRows)->select();
		$this ->assign("page",$show);		 
        $this->assign('list',$list);		
		$this->display();
	}  
	public function wakuang(){
		
		$id= I("get.id",0,"intval");
		$result = M('order')->where(array('id'=>$id,"user"=>session('username')))->find();
		if(!$result){
					echo '<script>alert("矿机不存在！");window.history.back(-1);</script>';
					die;					
		}
		

			
		//计算预计总收益

		$time = $result['UG_getTime'];
	    $time1= NOW_TIME;
		$cha = $time1-$time;
		
		//$jrsy= $result['kjsl']/3600;
		$jrsy= 0;
		$jrsy=number_format($jrsy,8);//每秒收益
		
		$yjzsy = $cha * $jrsy;//矿车预计总收益
		$zsy=number_format($yjzsy,8);
		$kcmc = $result['project'];
		$status=$result['zt'];

		$qwsl=$result['qwsl'];
		$qwsljs=M('shop_project')->sum('kjsl');
		//每秒受益
		//$mmsy=$result['kjsl']/86400;
		$mmsy=$result['kjsl']/3600;
		$mmsy=number_format($mmsy,8);
		$this->assign('mmsy',$mmsy);
		//dump($qwsljs);die();
		$ckzqwsl=M('order')->where(array('zt'=>1))->sum('lixi');
		$ckzqwsl=number_format($ckzqwsl,2);
		
		
		$sl=M('slkz')->order('id desc')->find();
		$xssl=$ckzqwsl+$sl['num'];
		$xssl=number_format($xssl,2);
		//dump($xssl);die();
		$down_time=time()-strtotime($result['addtime']);
		
		if($down_time > $result['yxzq']*3600){
			$down_time=$result['yxzq']*3600;
		}
		
		
		$data_b_total=M("jinbidetail")->where("type = 1")->sum('adds');
		
		
		$total_sy=$down_time*$mmsy;
		$this->assign('total_sy',$total_sy);
		$this->assign('data_b_total',$data_b_total);
		$this->assign('kcmc',$kcmc);
		$this->assign('status',$status);
		$this->assign('yjzsy',$zsy);
		$this->assign('gonglv',$result['lixi']);
		$this->assign('qwsl',$ckzqwsl);
		$this->assign('jrsy',$jrsy);
		$this->display();
	}
	
	//支付
	public function ordePay(){
		die;
		$member = M('member');
		$id = I('get.id',0,'intval');
		$jinbi = getMemberField('jinbi');
		if($id==0){
			alert('订单参数出错！',-1);
		}
		$orderinfo = M('order')->where(array('member'=>session('username'),'id'=>$id))->find();
		if($orderinfo['status']>0){
			echo '<script>alert("订单已支付，不可操作！");window.history.back(-1);</script>';
			die;
		}
		$money = $orderinfo['money'];
        if (!$orderinfo) {
			echo '<script>alert("对不起，支付信息不正确！");window.history.back(-1);</script>';
			die;				
        }	

		//扣除并写入明细
		if($jinbi < $money){
				echo '<script>alert("电子币余额不足，请确认！");window.history.back(-1);</script>';
				die;			
		}			

		$member->where(array('username'=>session('username')))->setDec('jinbi',$money);
		account_log(session('username'),$money,'支付商品:('.$orderinfo['stitle'].'),数量 '.$orderinfo['num'].'件。',0);				
	    $parent = $member->where(array('username'=>session('username')))->getField('parent');
		   if(!empty($parent)){
			      //重消奖 
				  $tjj  = cxmoney($money * 0.01 * C("LINGSHOU"));  
				  $member->where(array('username'=>$parent))->setInc('jinbi',$tjj[0]);
				  account_log($parent,$tjj[0],'重消奖,来自会员:'.session('username'),1,5);	
				  $member->where(array('username'=>$parent))->setInc('point',$tjj[1]);
				  account_log3($parent,$tjj[1],'重消奖,来自会员:'.session('username'),1,5);					  
		    }
		//更新订单状态
		M('order')->where(array('member'=>session('username'),'id'=>$id))->save(array('status'=>1,'pay_time'=>NOW_TIME));


        alert('支付成功',U('Index/Shop/orderlist'));		
	}
	
	
		public function payList(){
			$data = M('paydetail')->where(array('member'=>session('username')))->order('id desc')->select();
			$this->assign('data',$data);
			$this->display();
		}
		/**
		 * [会员电子货币充值]
		 * @return [type] [description]
		 */
		public function pay(){
			
			if (IS_POST) {
				$db = M('paydetail');
				$member = M('member');
				$money = I('post.money',0,'intval');
				$password2   = I('post.password2','','md5');
				$data['type'] = I('post.type',0,'strval');
				$data['account'] = I('post.account',0,'strval');
				$data['name'] = I('post.name',0,'strval');
				$data['content'] = I('post.content',0,'strval');
				if(empty($data['type']) || empty($data['account']) || empty($data['name']) || empty($data['content'])){
					
					$this->ajaxReturn(array('info'=>'请完善零售信息！'));
				}
				$money == 0 and  $this->ajaxReturn(array('info'=>'提现金额不能为0！'));
				//验证二级密码是否正确
				if (!$member->where(array('username'=>session('username'),'password2'=>$password2))->getField('id')) {
					$this->ajaxReturn(array('info'=>'对不起!二级密码不正确!'));					
				}		
				$money = intval($money);
				$shoukuan = $member->where(array('member'=>session('username')))->find();
				

				$data['addtime'] = time();
				$data['member'] = session('username');
	            $data['amount'] =  $money;
					if ($db->data($data)->add()) {

						$this->ajaxReturn(array('info'=>'提交成功，等待审核！','url'=>U('Index/shop/pay')));
					}else{
						$this->ajaxReturn(array('info'=>'提交失败！','url'=>U('Index/shop/pay')));
					}				

            }      
			$member = M('member')->field("jinbi")->where(array('id'=>session('mid')))->find();
			
			$status = C("WITHDRAW_STATUS");
			$this->assign('status',$status);
			$this->assign('v',$member);
			$this->display();
		}
}



?>