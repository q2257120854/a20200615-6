<?php
namespace App\Controller;
use Think\Controller;
class AppController extends Controller {
	//粉丝
	public function fans(){
		$uid = $_GET['uid'];
		$arr = M("user_rel")->where("pid={$uid}")->order("addtime DESC")->limit(20)->select();
        
        for ($whiletimes=0; $whiletimes<count($arr); $whiletimes++) {
          	$fanlists[$whiletimes]['id'] = $arr[$whiletimes]['id'];
          	$fanlists[$whiletimes]['lv'] = $arr[$whiletimes]['lv'];
          	$fanlists[$whiletimes]['pid'] = $arr[$whiletimes]['pid'];
          	$fanlists[$whiletimes]['uid'] = $arr[$whiletimes]['uid'];
          	$fanlists[$whiletimes]['addtime'] = $arr[$whiletimes]['addtime'];
          	$fanlists[$whiletimes]['shijian'] = date('Y-m-s h:i:s',$arr[$whiletimes]['addtime']);
          	$fanlists[$whiletimes]['uname'] = M("user")->where("id={$arr[$whiletimes]['uid']}")->find()['username'];
	        if($arr[$whiletimes]['lv'] == 1){
            	$fanlists[$whiletimes]['pname'] = M("user")->where("id={$arr[$whiletimes]['pid']}")->find()['username'];
            }else if($arr[$whiletimes]['lv'] == 2){
              	$userrelid = $arr[$whiletimes]['id'] + 1;
                $puserid = M("user_rel")->where("id={$userrelid}")->find()['pid'];
            	$fanlists[$whiletimes]['pname'] = M("user")->where("id={$puserid}")->find()['username'];
            }else if($arr[$whiletimes]['lv'] = 3){
              	$userrelid = $arr[$whiletimes]['id'] + 2;
                $puserid = M("user_rel")->where("id={$userrelid}")->find()['pid'];
            	$fanlists[$whiletimes]['pname'] = M("user")->where("id={$puserid}")->find()['username'];
            }

        }
		if($fanlists){
			echo json_encode(['code' => '1','msg'=>$fanlists], JSON_UNESCAPED_UNICODE);
		}else{
			echo json_encode(['code' => '0','msg'=>'还没有下级,继续努力哦！'], JSON_UNESCAPED_UNICODE);
		}
        //echo "<pre>";print_r($arr);echo "<pre>";
        //echo "<pre>";print_r($fanlists);echo "<pre>";
	}
  
	public function fanss(){
		$uid = $_GET['uid'];
		$pagestart=$_GET['nextrow'];
		$arr = M("user_rel")->where("pid={$uid}")->order("addtime DESC")->limit($pagestart,10)->select();

        for ($whiletimes=0; $whiletimes<count($arr); $whiletimes++) {
          	$fanlists[$whiletimes]['id'] = $arr[$whiletimes]['id'];
          	$fanlists[$whiletimes]['lv'] = $arr[$whiletimes]['lv'];
          	$fanlists[$whiletimes]['pid'] = $arr[$whiletimes]['pid'];
          	$fanlists[$whiletimes]['uid'] = $arr[$whiletimes]['uid'];
          	$fanlists[$whiletimes]['addtime'] = $arr[$whiletimes]['addtime'];
          	$fanlists[$whiletimes]['shijian'] = date('Y-m-s h:i:s',$arr[$whiletimes]['addtime']);
          	$fanlists[$whiletimes]['uname'] = M("user")->where("id={$arr[$whiletimes]['uid']}")->find()['username'];
	        if($arr[$whiletimes]['lv'] == 1){
            	$fanlists[$whiletimes]['pname'] = M("user")->where("id={$arr[$whiletimes]['pid']}")->find()['username'];
            }else if($arr[$whiletimes]['lv'] == 2){
              	$userrelid = $arr[$whiletimes]['id'] + 1;
                $puserid = M("user_rel")->where("id={$userrelid}")->find()['pid'];
            	$fanlists[$whiletimes]['pname'] = M("user")->where("id={$puserid}")->find()['username'];
            }else if($arr[$whiletimes]['lv'] = 3){
              	$userrelid = $arr[$whiletimes]['id'] + 2;
                $puserid = M("user_rel")->where("id={$userrelid}")->find()['pid'];
            	$fanlists[$whiletimes]['pname'] = M("user")->where("id={$puserid}")->find()['username'];
            }

        }
		if($fanlists){
			echo json_encode(['code' => '1','msg'=>$fanlists], JSON_UNESCAPED_UNICODE);
		}else{
			echo json_encode(['code' => '0','msg'=>'还没有下级,继续努力哦！'], JSON_UNESCAPED_UNICODE);
		}
	}
    public function config(){
        $data = M('config')->where("id=1")->find();
        $arr1 = M("jiage")->where("id = 1")->find();
        $arr['jx1'] = $data['jiexi1'];
        $arr['jx2'] = $data['jiexi2'];
        $arr['jx3'] = $data['jiexi3'];
        $arr['jx4'] = $data['jiexi4'];
        $arr['jx5'] = $data['jiexi5'];
        $arr['kefu'] = $data['kefu'];
        $arr['day'] = $arr1['day'];
        $arr['month'] = $arr1['month'];
        $arr['quarter'] = $arr1['quarter'];
        $arr['half'] = $arr1['half'];
        $arr['year'] = $arr1['year'];
        $arr['yongjiu'] = $arr1['yongjiu'];
        $arr['daili'] = $arr1['daili'];
        if ($data) {
            //return json(['code' => '1','msg'=>$arr]);
            echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        }
    }
  
	public function lunbo(){
		$arr['slun'] = M('adver')->where("type=1")->order("sort ASC")->select();
		$arr['zlun'] = M('adver')->where("type=2")->order("sort ASC")->select();
		$arr['vip'] = M('adver')->where("type=3")->order("sort ASC")->select();
		$arr['qidong'] = M('adver')->where("type=4")->order("sort ASC")->select();
		$arr['zhibo'] = M('adver')->where("type=5")->order("sort ASC")->select();
		if ($arr) 
		{
			echo json_encode($arr, JSON_UNESCAPED_UNICODE);
		}
		else 
		{
			echo  json_encode($arr, JSON_UNESCAPED_UNICODE);
		}
		
	}
	public function pindao(){
		$arr =M("type")->order("sort ASC")->limit(8)->select();
		if ($arr) 
		{
			echo json_encode(['code' => '0','msg'=>$arr], JSON_UNESCAPED_UNICODE);
		}
		else 
		{
			echo json_encode(['code' => '1','msg'=>$arr], JSON_UNESCAPED_UNICODE);
		}
	}
	public function rebo(){
		$arr =M("video")->order("addtime DESC")->limit(20)->select();
		if ($arr) 
		{
			echo json_encode($arr, JSON_UNESCAPED_UNICODE);
		}
		else 
		{
			echo  json_encode($arr, JSON_UNESCAPED_UNICODE);
		}
	}
	public function notice(){
		$arr =M("notice")->order("id ASC")->select();
		if ($arr) 
		{
			echo json_encode($arr, JSON_UNESCAPED_UNICODE);
		}
		else 
		{
			echo  json_encode($arr, JSON_UNESCAPED_UNICODE);
		}
		
	}
	public function faxian(){
		$arr =M("video")->order('rand()')->limit(10)->select();
		if ($arr) 
		{
			echo json_encode($arr, JSON_UNESCAPED_UNICODE);
		}
		else 
		{
			echo  json_encode($arr, JSON_UNESCAPED_UNICODE);
		}
	}
	
	public function qiand() {
		
			$id = $_GET['uid'];
			$jifen = $_GET['qdjbx'];
			$qdtime= M('user')->where("id={$id}")->find()['qdtime'];
			$nowtime=time();
			$bltime=$nowtime-$qdtime;
			$bltime=$bltime/3600;
			if ($bltime>=10){
				
				M('user')->where("id={$id}")->save(['qdtime'=>time()]);
				
				}else {
					//return json(['code' => '0']);
					echo  json_encode(['code'=>0], JSON_UNESCAPED_UNICODE);
				exit;
				}	
				
			M('user')->where("id={$id}")->setInc('jifen',$jifen);
			if ($jifen) 
			{
				echo  json_encode(['code'=>1], JSON_UNESCAPED_UNICODE);
			}
			else 
			{
				echo  json_encode(['code'=>0], JSON_UNESCAPED_UNICODE);
			}
		
		
	}

	
	public function denglu(){
		$username=$_GET['username'];
		$passwd=$_GET['passwd'];
      	$imei=$_GET['imei'];
		$pass= md5(sha1($passwd));
		$data = M('user')->where("username='{$username}' and password = '{$pass}'")->find();
		$arr['name'] = $data['username'];    
		$arr['pass'] = $data['password'];  
		$arr['mim'] = $data['mim'];  
		$arr['viptime'] = $data['viptime'];  
		$arr['id'] = $data['id'];  
		$arr['jifen'] = $data['jifen'];  
		$arr['share'] = $data['share'];  
		$arr['money'] = $data['money'];  
		$config = M("config")->where("id=1")->find();
		$arr['kefu'] = $config['kefu']; 
		if($data){
			$a=M('user')->where("uuid='{$uuid}'")->setInc('count',1);
			$b=M('user')->where("uuid='{$uuid}'")->save(['logintime'=>time()]);
            $is_imei = M("user")->where("username={$username}")->find()['uuid'];
            $if_imei = M("user")->where("uuid={$imei}")->find()['uuid'];
			if($is_imei == NULL){
              M('user')->where("username='{$username}'")->save(['uuid'=>$imei]);
            }else if($is_imei != $imei){
              echo json_encode(['code' => '2'], JSON_UNESCAPED_UNICODE);
              exit;
            }
			echo json_encode(['code' => '1','msg'=>$arr], JSON_UNESCAPED_UNICODE);
		}else{
			echo json_encode(['code' => '0'], JSON_UNESCAPED_UNICODE);
		}
	}
	
	
	public function oneRegister(){
		$uuid=$_GET['uuid'];
		$data = M('user')->where("uuid='{$uuid}'")->find();
		$config = M('config')->where("id=1")->find();
		$shi=$config['time'];
		$pass=chr(rand(65, 120)).chr(rand(65, 120)).mt_rand(100,999).chr(rand(65, 120)).chr(rand(65, 120)).chr(rand(65, 120)); 
		$arr['name'] = $data['username'];    
		$arr['pass'] = $data['password']; 
		$arr['mim'] = $data['mim'];  
		$arr['viptime'] = $data['viptime'];  
		$arr['id'] = $data['id']; 
		$arr['num'] = $data['num'];  
		$arr['money'] = $data['money']; 
		$arr['share'] = $data['share'];
		$arr['jifen'] = $data['jifen']; 	
		$arr['kefu'] = $config['kefu']; 		
		if($data){
			$a=M('user')->where("uuid='{$uuid}'")->setInc('count',1);
			$b=M('user')->where("uuid='{$uuid}'")->save(['logintime'=>time()]);
			echo json_encode($arr, JSON_UNESCAPED_UNICODE);
		}else{
			$mod = M('user');
			$insert['username'] = '588'.mt_rand(100,99999);
			$insert['password'] = md5(sha1($pass));
			$insert['mim'] = $pass;
			$insert['uuid'] = $uuid;
			$insert['addtime'] = time();
			$insert['logintime'] = time();
			$insert['viptime'] = time()+$shi*60;
			$insert['share'] = substr(base_convert(md5(uniqid(md5(microtime(true)),true)), 16, 10), 0, 6);
			$mod -> create($insert);
			if($mod -> add()){
				$data = M('user')->where("uuid='{$uuid}'")->find();	
				$arr['name'] = $data['username'];    
				$arr['pass'] = $data['password']; 
				$arr['mim'] = $data['mim'];  
				$arr['viptime'] = $data['viptime'];  
				$arr['id'] = $data['id']; 
				$arr['num'] = $data['num'];  
				$arr['money'] = $data['money'];  
				$arr['share'] = $data['share']; 
				$arr['jifen'] = $data['jifen']; 
				$arr['bg'] = $config['bofang']; 
				$a=M('user')->where("uuid='{$uuid}'")->setInc('count',1);
				$b=M('user')->where("uuid='{$uuid}'")->save(['logintime'=>time()]);
				echo json_encode($arr, JSON_UNESCAPED_UNICODE);
			}
		}
	}

	
	public function news(){
		$arr =M("news")->order("addtime DESC")->select();
		if ($arr) 
		{
			echo json_encode($arr, JSON_UNESCAPED_UNICODE);
		}
		else 
		{
			echo  json_encode($arr, JSON_UNESCAPED_UNICODE);
		}
		
	}
	public function mess(){
		$uid = $_GET['uid'];
		$arr =M("mess")->where("uid = {$uid}")->order("addtime DESC")->limit(10)->select();
		if ($arr) 
		{
			echo json_encode(['code' => '1','msg'=>$arr], JSON_UNESCAPED_UNICODE);
		}
		else 
		{
			echo  json_encode(['code' => '0','msg'=>'还没有消息！'], JSON_UNESCAPED_UNICODE);
		}
	}
	public function messs(){
		$uid = $_GET['uid'];
		$pagestart=$_GET['nextrow'];
		$arr =M("mess")->where("uid = {$uid}")->order("addtime DESC")->limit($pagestart,10)->select();
		if ($arr) 
		{
			echo json_encode(['code' => '1','msg'=>$arr], JSON_UNESCAPED_UNICODE);
		}
		else 
		{
			echo  json_encode(['code' => '0','msg'=>'已经到头了！'], JSON_UNESCAPED_UNICODE);
		}
	}
	public function jilu(){
		$uid = $_GET['uid'];
		$arr =M("jilu")->where("uid = {$uid}")->order("addtime DESC")->limit(10)->select();
		if ($arr) 
		{
			echo json_encode(['code' => '1','msg'=>$arr], JSON_UNESCAPED_UNICODE);
		}
		else 
		{
			echo  json_encode(['code' => '0','msg'=>'还没有记录！'], JSON_UNESCAPED_UNICODE);
		}
	}
	public function jilus(){
		$pagestart=$_GET['nextrow'];
		$uid = $_GET['uid'];
		$arr = M("jilu")->where("uid = {$uid}")->limit($pagestart,10)->order("addtime DESC")->select();
		if ($arr) 
		{
			echo json_encode(['code' => '1','msg'=>$arr], JSON_UNESCAPED_UNICODE);
		}
		else 
		{
			echo  json_encode(['code' => '0','msg'=>'已经没有了！'], JSON_UNESCAPED_UNICODE);
		}
	}
	public function pay(){
		header("Content-type: application/json; charset=utf-8");
		$pay = M('pay');
		$str = $_POST['outtrade'];
		$str1 = substr($str,14);
		$insert['outtrade'] = $_POST['outtrade'];
		$insert['trade'] = $_POST['trade'];
		$insert['type'] = $_POST['type'];
		$insert['money'] = $_POST['money'];
		$insert['trade_status'] = $_POST['trade_status'];
		$insert['name'] = $_POST['name'];
		$insert['time'] = time();
		$insert['cid'] = $str1;
		$pay -> create($insert);
		if($_POST['trade_status']!='TRADE_SUCCESS') 
		{
			echo  json_encode(['code'=>'0','msg'=>'支付未完成'], JSON_UNESCAPED_UNICODE);
			exit;
		}
		$ztai = M('pay')->where("trade={$_POST['trade']}")->find()['trade'];
		if($ztai==$_POST['trade']){
			echo  json_encode(['code'=>'0','msg'=>'请勿重复刷新,支付已成功请返回重新登录即可获得会员！'], JSON_UNESCAPED_UNICODE);
			exit;
		}
		$pay -> add();
		
		//加时间
		$jia = M("jiage")->where("id=1")->find();
		if($_POST['money']==$jia['day'] ||$_POST['money']==$jia['month']||$_POST['money']==$jia['quarter']||$_POST['money']==$jia['half']||$_POST['money']==$jia['year']||$_POST['money']==$jia['yongjiu']) 
		{
		}
		else 
		{
			echo  json_encode(['code'=>'0','msg'=>'订单支付金额有误，请联系客服处理'], JSON_UNESCAPED_UNICODE);
			exit;
		}
		
		if($_POST['money']==$jia['day']) 
		{
			$ctime = 3;
		}
		if($_POST['money']==$jia['month']) 
		{
			$ctime = 8;
		}
		if($_POST['money']==$jia['quarter']) 
		{
			$ctime = 18;
		}
       if($_POST['money']==$jia['half']) 
		{
			$ctime = 38;
		} 
       if($_POST['money']==$jia['year']) 
		{
			$ctime = 68;
		}            
		if($_POST['money']==$jia['yongjiu']) 
		{
			$ctime = 288;
		}
		
		switch ($ctime) 
		{
			case 3;
			$time = 7*60*60*24;
            //$time = date("Y-m-d H:i:s",strtotime("+1months",time()));
            $name = '七天';
			break;
			case 8;
			$time = 30*60*60*24;
            //$time = date("Y-m-d H:i:s",strtotime("+1months",time()));
			$name = '一个月';
			break;
			case 18;
			$time = 90*60*60*24;
            //$time = date("Y-m-d H:i:s",strtotime("+1months",time()));
			$name = '三个月';
			break;
			case 38;
			$time = 180*60*60*24;
            //$time = date("Y-m-d H:i:s",strtotime("+1months",time()));
			$name = '六个月';
			break;            
			case 68;
			$time = 365*60*60*24;
            //$time = date("Y-m-d H:i:s",strtotime("+1months",time()));
			$name = '一年';
			break;
			case 288;
			$time = 9999*60*60*24;
            //$time = date("Y-m-d H:i:s",strtotime("+1months",time()));
            $name = '永久';
			break;
		}
		
		$k = M("user")->where("id={$str1}")->find();

		if($k['viptime']>time()) 
			
		{
				M('user')->where("id={$str1}")->save(['viptime'=>$k['viptime']+$time]);
				$mess = M("mess"); 
				$data0['title'] = '系统消息:VIP开通成功！';
				$data0['shijian'] = date("Y-m-d H:i:s ",time());
				$data0['addtime'] = time();
				$data0['uid'] = $str1;
				$mess->add($data0);
		}else{
				M('user')->where("id={$str1}")->save(['viptime'=>time()+$time]);
				$mess = M("mess"); 
				$data0['title'] = '系统消息:VIP开通成功！';
				$data0['shijian'] = date("Y-m-d H:i:s ",time());
				$data0['addtime'] = time();
				$data0['uid'] = $str1;
				$mess->add($data0);
		}
		
		
		$user = M("user")->where("id={$str1}")->find()['pid'];
		$userd = M("user")->where("id={$user}")->find();//一级
		$userd2 = M("user")->where("id={$userd['pid']}")->find();//二级
		$userd3 = M("user")->where("id={$userd2['pid']}")->find();//三级
		$con = M("config")->where("id=1")->find();
		if(!empty($userd)){	
			$a = $_POST['money'];
			$c = (float)$con['yi']/100; 
			$d = $a*$c;
			M('user')->where("id={$user}")->setInc('money', $d);
			$user2 = M("user")->where("id={$user}")->find()['pid'];
			
			$User1 = M("fanxian"); 
			$data['title'] = $_POST['name'];
			$data['price'] = $d;
			$data['addtime'] = time();
			$data['uid'] = $user;
			$data['shijian'] = date("Y-m-d H:i",time());
			$data['type'] = '一级返现';
			$User1->add($data);
		}
		if(!empty($userd2)){		
			$a = $_POST['money'];
			$c = (float)$con['er']/100; 
			$d = $a*$c;
			M('user')->where("id={$user2}")->setInc('money', $d);
		   $user3 = M("user")->where("id={$user2}")->find()['pid'];
			$User1 = M("fanxian"); 
			$data['title'] = $_POST['name'];
			$data['price'] = $d;
			$data['addtime'] = time();
			$data['uid'] = $user2;
			$data['shijian'] = date("Y-m-d H:i",time());
			$data['type'] = '二级返现';
			$User1->add($data);
		}
		if(!empty($userd3)){			
			$a = $_POST['money'];
			$c = (float)$con['san']/100; 
			$d = $a*$c;
		   M('user')->where("id={$user3}")->setInc('money', $d);
			$User1 = M("fanxian"); 
			$data['title'] = $_POST['name'];
			$data['price'] = $d;
			$data['addtime'] = time();
			$data['uid'] = $user3;
			$data['shijian'] = date("Y-m-d H:i",time());
			$data['type'] = '三级返现';
			$User1->add($data);	
		}
		echo  json_encode(['code'=>'1','msg'=>'充值成功'], JSON_UNESCAPED_UNICODE);
	}
	public function shuaxin(){
		$uid = $_GET['uid'];
		$data = M('user')->where("id='{$uid}'")->find();
		$arr['viptime'] = $data['viptime'];  
		if($data){
			echo json_encode($arr, JSON_UNESCAPED_UNICODE);
		}else{
			echo json_encode($arr, JSON_UNESCAPED_UNICODE);
		}
	}
	public function jiage(){
		$arr = M("jiage")->where("id = 1")->find();
		if($arr){
			echo json_encode($arr, JSON_UNESCAPED_UNICODE);
		}else{
			echo json_encode($arr, JSON_UNESCAPED_UNICODE);
		}
	}
	public function fenxiao(){
		$uid = $_GET['uid'];
		$data = M('config')->where("id=1")->field('id,yi,er,san,tixian')->find();
		$xiao = M("fanxian")->where('uid='.$uid.' and addtime >'. strtotime(date('Y-m-d')))->count();
		$zong = M("fanxian")->where('uid='.$uid.' and addtime >'. strtotime(date('Y-m-d')))->sum("price");
		$startTime = mktime(0,0,0,date('m'),date('d')-1,date('y'));
        $endTime = mktime(0,0,0,date('m'),date('d'),date('y'));
		$zxiao = M("fanxian")->where("uid={$uid} and addtime >={$startTime} and addtime < {$endTime}")->count();
		$zzong = M("fanxian")->where("uid={$uid} and addtime >={$startTime} and addtime < {$endTime}")->sum("price");
		$user = M("user")->where("id={$uid}")->find()['money'];
		if($zong==null){
			$zong=0;
		}
		if($zzong==null){
			$zzong=0;
		}
		$arr['yi'] = $data['yi']; 
		$arr['er'] = $data['er']; 
		$arr['san'] = $data['san']; 
		$arr['tixian'] = $data['tixian']; 
		$arr['bi'] = $xiao;
		$arr['zong'] = $zong; 	
		$arr['zbi'] = $zxiao;
		$arr['zzong'] =$zzong; 	
		$arr['money'] =$user; 		
		if ($data) 
		{
			//return json(['code' => '1','msg'=>$arr]);
			echo json_encode($arr, JSON_UNESCAPED_UNICODE);
		}
		else 
		{
			echo  json_encode($arr, JSON_UNESCAPED_UNICODE);
		}
	}
	//提现
	public function sqtixian(){
		$price = $_GET['price'];
		$uid = $_GET['uid'];
		$name = $_GET['name'];
		$zhifubao = $_GET['zhifubao'];
		$con = M("config")->where("id=1")->find()['tixian'];
		if($con>$price){
			echo  json_encode(['code'=>'0','msg'=>'最低提现'.$con.'元!'], JSON_UNESCAPED_UNICODE);
			exit();
		}
		$mod = M("user")->where("id={$uid}")->find()['money'];
		$ti = M("tixian")->where("uid={$uid} and status=1")->find();
		if($ti){
			echo  json_encode(['code'=>'0','msg'=>'您有提现中的申请，请等待审核完毕在申请'], JSON_UNESCAPED_UNICODE);
			exit();
		}else{
			if($price>$mod){
				echo  json_encode(['code'=>'0','msg'=>'佣金不足，请正确输入'], JSON_UNESCAPED_UNICODE);
				exit();
			}else{
				
					$d=$mod-$price;
					$User1 = M("tixian"); 
					$datas['price'] = $price;
					$datas['addtime'] = time();
					$datas['uid'] = $uid;
					$datas['zhifubao'] = $zhifubao;
					$datas['uname'] = $name;
					$datas['shijian'] = date("Y-m-d H:i",time());
					$User1->add($datas);
					M('user')->where("id={$uid}")->save(['money'=>$d]);
				echo  json_encode(['code'=>'1','msg'=>'佣金提现申请成功，等待审核'], JSON_UNESCAPED_UNICODE);
			}
			
		}
	}
	

	public function txjilu(){
		$uid = $_GET['uid'];
		$arr = M("tixian")->where("uid={$uid}")->order("addtime DESC")->select();
		if ($arr) 
		{
			echo json_encode(['code' => '1','msg'=>$arr], JSON_UNESCAPED_UNICODE);
			
		}
		else 
		{
			echo json_encode(['code' => '0','msg'=>'还没有记录！'], JSON_UNESCAPED_UNICODE);
		}
		
	}
	//明细
	public function mingxi(){
		$uid = $_GET['uid'];
		$arr = M("fanxian")->where("uid={$uid}")->order("addtime DESC")->limit(20)->select();
		if($arr){
			echo json_encode(['code' => '1','msg'=>$arr], JSON_UNESCAPED_UNICODE);
		}else{
			echo json_encode(['code' => '0','msg'=>'还没有记录！'], JSON_UNESCAPED_UNICODE);
		}
	}

	
	public function shipin(){
		$type = $_GET['type'];
		$arr = M("video")->where("type='{$type}'")->order("addtime DESC")->limit(20)->select();
		if ($arr) 
		{
			echo json_encode(['code' => '1','msg'=>$arr], JSON_UNESCAPED_UNICODE);
			
		}
		else 
		{
			echo json_encode(['code' => '0','msg'=>'还没有视频！'], JSON_UNESCAPED_UNICODE);
		}
	}
	public function shipins(){
		$type = $_GET['type'];
		$pagestart=$_GET['nextrow'];
		$arr = M("video")->where("type='{$type}'")->order("addtime DESC")->limit($pagestart,10)->select();
		if ($arr) 
		{
			echo json_encode(['code' => '1','msg'=>$arr], JSON_UNESCAPED_UNICODE);
			
		}
		else 
		{
			echo json_encode(['code' => '0','msg'=>'还没有视频！'], JSON_UNESCAPED_UNICODE);
		}
	}
	public function dianka(){
		
		$uid = $_GET['uid'];
		$dianka = $_GET['dianka'];
		
		if(!empty($uid) && !empty($dianka)){
			
			$num = M('user')->where("id={$uid}")->count();
			if($num=='0') 
			{
				echo  json_encode(['code'=>0,'msg'=>'用户不存在'], JSON_UNESCAPED_UNICODE);
				exit();
			}
			$dianka1 = M('kami')->where("dianka='{$dianka}'")->find();
			if(!$dianka1) 
			{
				echo  json_encode(['code'=>0,'msg'=>'卡号错误'], JSON_UNESCAPED_UNICODE);
				exit();
			}
			
			if($dianka1['y']=='1') 
			{
				
				echo  json_encode(['code'=>0,'msg'=>'点卡已使用'], JSON_UNESCAPED_UNICODE);
				exit();
			}
			
				
			$user = M('user')->where("id={$uid}")->find();
			
			if($user['viptime']>time()) 
			{
					M('user')->where("id={$uid}")->save(['viptime'=>$user['viptime']+$dianka1['time'],'pid'=>$dianka1['uid']]);
					
					
				if($user['pid']==0){
					M('user')->where("id={$uid}")->save(['pid'=>$dianka1['uid']]);
					$er = M("user_rel");
					$data3['uid'] = $uid;
					$data3['pid'] = $dianka1['uid'];
					$data3['uname'] = $dianka1['sbh'];
					$data3['lv'] = '1';
					$data3['addtime'] = time();
					$er->add($data3);
				}
				
				
			}else{
					M('user')->where("id={$uid}")->save(['viptime'=>time()+$dianka1['time']]);
					
				if($user['pid']==0){
					M('user')->where("id={$uid}")->save(['pid'=>$dianka1['uid']]);
					$er = M("user_rel");
					$data3['uid'] = $uid;
					$data3['pid'] = $dianka1['uid'];
					$data3['uname'] = $dianka1['sbh'];
					$data3['lv'] = '1';
					$data3['addtime'] = time();
					$er->add($data3);
				}		
			}
			
			
		
			$a=M('kami')->where("dianka='{$dianka}'")->save(['y'=>'1','yid'=>$uid,'stime'=>time()]);
		
				
				$lasttime = M('user')->where("id={$uid}")->find()['viptime'];
			
			
			
			echo  json_encode(['code'=>1,'msg'=>'充值成功','lasttime'=>$lasttime], JSON_UNESCAPED_UNICODE);	
		}else {
			
			echo  json_encode(['code'=>0,'msg'=>'参数缺失'], JSON_UNESCAPED_UNICODE);
		}
		
	}
	public function tanchuang(){
		
		$mod = M("tan")->where("id=1")->find();
		if ($mod) 
		{
			echo json_encode(['code' => '1','msg'=>$mod], JSON_UNESCAPED_UNICODE);
			
		}
		else 
		{
			echo json_encode(['code' => '0','msg'=>$mod], JSON_UNESCAPED_UNICODE);
		}
	}
	
	
	public function reg(){
		$uuid = $_GET['uuid'];
		$data1 = M('user')->where("username ='{$_GET['name']}'")->find();
		if(!$data1){
		$data = M('user')->where("uuid='{$uuid}'")->find();
		if($data){
			echo json_encode(['code' => '0','msg'=>'当前设备已经注册过了~'], JSON_UNESCAPED_UNICODE);
			exit;
		}else{
			if($_GET['share']==null or $_GET['share']==''){
			$config = M('config')->where("id=1")->find();
			$shi=$config['time'];
			$mod = M('user');
			$insert['username'] = $_GET['name'];
			$insert['password'] = md5(sha1($_GET['password']));
			$insert['mim'] = $_GET['password'];
			$insert['uuid'] = $uuid;
			$insert['addtime'] = time();
			$insert['logintime'] = time();
		
			$insert['viptime'] = time()+$shi*60;
			$insert['share'] = substr(base_convert(md5(uniqid(md5(microtime(true)),true)), 16, 10), 0, 6);	
				$mod -> create($insert);
			$result = $mod -> add();
			}else{
			$data3 = M('user')->where("share ='{$_GET['share']}'")->find();
			if(!$data3){
				echo json_encode(['code' => '0','msg'=>'请输入正确的邀请码~'], JSON_UNESCAPED_UNICODE);
				exit;
			}
			
			$config = M('config')->where("id=1")->find();
			$shi=$config['time'];
			$mod = M('user');
			$insert['username'] = $_GET['name'];
			$insert['password'] = md5(sha1($_GET['password']));
			$insert['mim'] = $_GET['password'];
			$insert['uuid'] = $uuid;
			$insert['addtime'] = time();
			$insert['logintime'] = time();
			$insert['pid'] = $data3['id'];
			$insert['viptime'] = time()+$shi*60;
			$insert['share'] = substr(base_convert(md5(uniqid(md5(microtime(true)),true)), 16, 10), 0, 6);
			
			$mod -> create($insert);
			$result = $mod -> add();
			
					$er = M("user_rel");
					$data5['uid'] = $result;
					$data5['pid'] = $data3['id'];
					$data5['uname'] = $data3['username'];
					$data5['lv'] = '1';
					$data5['addtime'] = time();
					$data0['shijian'] = date("Y-m-d H:i:s ",time());
					$er->add($data5);
			
			}
			
			
			
				if($result){
				$data = M('user')->where("uuid='{$uuid}'")->find();	
				$arr['name'] = $data['username'];    
				$arr['pass'] = $data['password']; 
				$arr['mim'] = $data['mim'];  
				$arr['viptime'] = $data['viptime'];  
				$arr['id'] = $data['id']; 
				$arr['num'] = $data['num'];  
				$arr['money'] = $data['money']; 
				$arr['jifen'] = $data['jifen']; 
				$arr['share'] = $data['share']; 
				$arr['kefu'] = $config['kefu']; 
				$a=M('user')->where("uuid='{$uuid}'")->setInc('count',1);
				$b=M('user')->where("uuid='{$uuid}'")->save(['logintime'=>time()]);
				echo json_encode($arr, JSON_UNESCAPED_UNICODE);
			}
		}
		}else{
			echo json_encode(['code' => '0','msg'=>'用户名重复，请重新输入~'], JSON_UNESCAPED_UNICODE);
			exit;
			
		}
	}
	
	
	
	public function jifen(){
		$uid = $_GET['uid'];
		$arr = M("user")->where("id={$uid}")->find();
		$con = M("config")->where("id=1")->find();
		$arr['jifen']=$arr['jifen'];
		$arr['jiage']=$con['jifen'];
		if ($arr) 
		{
			//return json(['code' => '1','msg'=>$arr]);
			echo json_encode($arr, JSON_UNESCAPED_UNICODE);
		}
		else 
		{
			echo  json_encode($arr, JSON_UNESCAPED_UNICODE);
		}
		
	}
	public function exchange(){
		
		$uid = $_GET['uid'];
		$share = $_GET['share'];
		$con = M("config")->where("id=1")->find()['jifen'];
		if($share % $con!='0' || $share<=0) 
		{
		
			echo json_encode(['code'=>0,'msg'=>'消耗积分参数不正确'], JSON_UNESCAPED_UNICODE);
		}
		
		$data = M('user')->where("id={$uid}")->find();
		if(!$data) 
		{
			echo json_encode(['code'=>0,'msg'=>'用户不存在'], JSON_UNESCAPED_UNICODE);
		}else{
			
			if($share>$data['jifen']){
				echo json_encode(['code'=>0,'msg'=>'您的积分不够']);
			}else{
				$oldshare = $data['jifen'];
				$fen = $share/$con;
				$time = 60*60*24*$fen;
				$data = M('user')->where("id={$uid}")->find()['viptime'];
				if($data<time()) 
				{
					M('user')->where("id={$uid}")->save(['viptime'=>time()+$time]);
				}
				else 
				{
					M('user')->where("id={$uid}")->save(['viptime'=>$data+$time]);
				}
				M('user')->where("id={$uid}")->save(['jifen'=> $oldshare-$share]);
					echo json_encode(['code'=>1,'msg'=>'兑换成功'], JSON_UNESCAPED_UNICODE);
			}
		}
	}
	
	public function veify(){
		
		$data = M('user')->where('username="'.$_POST['name'].'" and password ="'.md5(sha1($_POST['pass'])).'" and status =2')->find();
		if ($data) 
		{
			$_SESSION['user']= $data; 
	
			echo json_encode(['code' => '1'], JSON_UNESCAPED_UNICODE);
		}
		else 
		{
			echo json_encode(['code' => '0'], JSON_UNESCAPED_UNICODE);
		}
	}
	
	public function so(){
		$keyword =$_GET['keyword'];
		$arr = M("video")->where("title like '%$keyword%'")->select();
		if ($arr) 
		{
			echo json_encode(['code' => '1','msg'=>$arr], JSON_UNESCAPED_UNICODE);
			
		}
		else 
		{
			echo json_encode(['code' => '0','msg'=>'没有搜索到视频哦！'], JSON_UNESCAPED_UNICODE);
		}
		
	}
	public function imei(){
		$id = $_GET['uid'];
		$data = M('user')->where("id={$id}")->find();
		$arr['imei'] = $data['uuid'];
		if ($data){
			echo json_encode(['code' => '1','msg'=>$arr], JSON_UNESCAPED_UNICODE);
		}else {
			echo json_encode(['code' => '1','msg'=>$arr], JSON_UNESCAPED_UNICODE);
		}
	}
}