<?php  
	/**
	 * 会员前台注册新会员
	 */
	Class ShaiAction extends CommonAction{

		public function index(){
			//执行开奖
			$dailist = M('kailog')->where(array('status' => 1, 'endtime' => array('lt', time() - 4)))->select();
			$kailist = M('kailog')->where(array('status' => 1))->order('id desc')->find();
			$lilist = M('kailog')->where(array('status' => 2))->order('id desc')->find();
			$user = M('member')->where(array('username' =>$_SESSION['username']))->find();
			$id = $user['id'];
			$kailistid = $kailist['id'];
			$time = time();
			if (empty($kailist)) {
				if ($time - $lilist['endtime'] > 3) {
					$data['starttime'] = $time;
					$data['endtime'] = $time + 60;
					$data['status'] = 1;
					M('kailog')->add($data);
					$kailist = M('kailog')->where(array('status' => 1))->order('id desc')->find();
				}

			}
			$mybuy = M('buylog')->where(array('uid' =>$user['id'], 'kid' => $kailist['id']))->order('starttime desc')->find();
			$miao = $kailist['endtime'] - time();
			$miao = $miao > 0 ? $miao : 0;
			if ($miao < 10) {
				$miao = '0' . $miao;
			}
			$yxgg = C('yxgg');
			//var_dump($yxgg); die();
			$this->assign('yxgg', $yxgg);
			$this->assign('miao', $miao);
			$this->assign('id', $id);
			$this->assign('kailistid', $kailistid);
			$this->assign('kailist', $kailist);
			$this->assign('mybuy', $mybuy);
			$this->assign('lilist', $lilist);
			$this->display();


		}


		public function kai()
		{

			//执行开奖
			$dailist = M('kailog')->where(array('status' => 1, 'endtime' => array('lt', time() - 4)))->select();
			//$kailist[1]=M()->GetLastSql();
			$money = $GLOBALS['_CFG']['withdraw']['money'];
			foreach ($dailist as $key => $va) {
				if ($va['kongid'] != 0) {
					$kaiid = $va['kongid'];
				} elseif ($va['allmoney'] < $money) {
					$kaiid = rand(1, 6);
				} else
					if ($va['kid2'] == $va['kid1'] && $va['kid2'] == $va['kid3'] && $va['kid2'] == $va['kid4'] && $va['kid2'] == $va['kid5'] && $va['kid2'] == $va['kid6']) {
						$kaiid = rand(1, 6);
						//echo $kaiid;
					} else {
						$a = $va['kid1'] <= $va['kid2'] ? $va['kid1'] : $va['kid2'];
						$b = $va['kid3'] <= $va['kid4'] ? $va['kid3'] : $va['kid4'];
						$c = $va['kid5'] <= $va['kid6'] ? $va['kid5'] : $va['kid6'];
						$d = $a <= $b ? $a : $b;
						$e = $d <= $c ? $d : $c;
						$kainum = array();
						if ($va['kid1'] == $e) {
							$kainum['1'] = 1;
						}
						if ($va['kid2'] == $e) {
							$kainum['2'] = 2;
						}
						if ($va['kid3'] == $e) {
							$kainum['3'] = 3;
						}
						if ($va['kid4'] == $e) {
							$kainum['4'] = 4;
						}
						if ($va['kid5'] == $e) {
							$kainum['5'] = 5;
						}
						if ($va['kid6'] == $e) {
							$kainum['6'] = 6;
						}
						if (count($kainum) == 1) {
							$kaiid3 = array_values($kainum);
							$kaiid = $kaiid3[0];
						} else {
							//rand(3,5,6);
							$kaiid = getRand($kainum);
						}
					}
				$cainum = (string)rand(600, 1000);
				$zhongnum = (string)rand(500, 590);
				M('kailog')->where(array('id' => $va['id']))->save(array('status' => 2, 'isid' => $kaiid, 'cainum' => $cainum, 'zhongnum' => $zhongnum));
				//微信通知获奖情况
				$list = M('buylog')->where(array('kid' => $va['id'], 'status' => 1))->select();
				foreach ($list as $key => $val) {
					$newinfo = M('buylog')->where(array('id' => $val['id']))->find();
					if ($newinfo['status'] == 1) {
						//猜大小
						if ($val['buyid'] <= 6) {
							if ($val['buyid'] == $kaiid) {
								$yingmoney = $val['money'] * 5;
								M('buylog')->where(array('id' => $val['id']))->save(array('yingmoney' => $yingmoney, 'status' => 2, 'isid' => $kaiid));
								$userinfo = M('member')->where(array('id' => $val['uid']))->find();
								if ($userinfo) {
									M('member')->where(array('id' => $userinfo['id']))->save(array('jinbi' => $userinfo['jinbi'] + $yingmoney));
									$desc = '猜大小中奖';
									caidaxiao_log($userinfo['username'],$yingmoney,$desc,0);
								}
							} else {
								M('buylog')->where(array('id' => $val['id']))->save(array('status' => 2, 'isid' => $kaiid));
							}
						} else {
							if (($val['buyid'] == 7 && $kaiid >= 4) || ($val['buyid'] == 8 && $kaiid <= 3)) {
								$yingmoney = $val['money'] * 1.9;
								M('buylog')->where(array('id' => $val['id']))->save(array('yingmoney' => $yingmoney, 'status' => 2, 'isid' => $kaiid));
								$userinfo = M('member')->where(array('id' => $val['uid']))->find();
								if ($userinfo) {
									M('member')->where(array('id' => $userinfo['id']))->save(array('jinbi' => $userinfo['jinbi'] + $yingmoney));
									$desc = '猜大小中奖';
									caidaxiao_log($userinfo['username'],$yingmoney,$desc,0);
								}
							} else {
								M('buylog')->where(array('id' => $val['id']))->save(array('status' => 2, 'isid' => $kaiid));
							}
						}
					}
				}
			}
			$kailist = M('kailog')->where(array('status' => 2, 'id' => $_GET['id']))->order('id desc')->find();

			$data = array();
			$kai = M('buylog')->where(array('status' => 2, 'kid' => $_GET['id'], 'uid' => $userinfo['id']))->order('yingmoney desc')->find();
			if (empty($kai)) {
				$data['type'] = 1;
			}
			$data['id'] = $kailist['id'];
			$data['isid'] = $kailist['isid'];
			$data['money'] = $kai['yingmoney'];
			$data['cainum'] = $kailist['cainum'];
			$data['zhongnum'] = $kailist['zhongnum'];
			if ($kailist) {
				//var_dump($data); die();
				echo json_encode($data);
			}
		}

		public function cai()
		{
			$buyid = $_POST['yanum'] ? $_POST['yanum'] : 1;
			$kailist = M('kailog')->where(array('status' => 1))->order('id desc')->find();
			$time = time();
			if (empty($kailist)) {
				$data['starttime'] = $time;
				//60秒/30秒/开奖时间控制
				$data['endtime'] = $time + 60;
				$data['status'] = 1;
				M('kailog')->add($data);
				$kailist = M('kailog')->where(array('status' => 1))->order('id desc')->find();
			}
			$info = M('buylog')->where(array('kid' => $kailist['id'], 'uid' => $_POST['uid']))->find();
			if ($info && $info['uid'] == $_POST['uid']) {
				$this->ajaxReturn(array('status' => 0, 'info' => '每轮只能选择一种进行投注！'));
			}
			if ($_POST['money'] < 0) {
				$this->ajaxReturn(array('status' => 0, 'info' => '您在非法提交！'));
			}
			$user = M('member')->where(array('username'=>$_SESSION['username']))->find();
			if (IS_POST) {
				$money = $_POST['money'] ? $_POST['money'] : 10;
					if ($money <= $user['jinbi']) {
						$add['uid'] = $user['id'];
						$add['money'] = $money;
						$add['buyid'] = $buyid;
						if ($buyid <= 6) {
							$add['type'] = 2;
						} else {
							$add['type'] = 1;
						}
						$kailist = M('kailog')->where(array('status' => 1))->order('id desc')->find();
						$time = time();
						if (empty($kailist)) {
							$data['starttime'] = $time;
							$data['endtime'] = $time + 60;
							$data['status'] = 1;
							M('kailog')->add($data);
							$kailist = M('kailog')->where(array('status' => 1))->order('id desc')->find();
						}
						$add['kid'] = $kailist['id'];
						$add['starttime'] = time();
						$add['status'] = 1;
						$add['endtime'] = $kailist['endtime'];
						$info = M('buylog')->add($add);
						if ($info) {
							if ($buyid == 1) {
								$up['kid1'] = $kailist['kid1'] + $money * 5;
								$up['xiao'] = $kailist['xiao'] + $money * 1.9;
							}
							if ($buyid == 2) {
								$up['kid2'] = $kailist['kid2'] + $money * 5;
								$up['xiao'] = $kailist['xiao'] + $money * 1.9;
							}
							if ($buyid == 3) {
								$up['kid3'] = $kailist['kid3'] + $money * 5;
								$up['xiao'] = $kailist['xiao'] + $money * 1.9;
							}
							if ($buyid == 4) {
								$up['kid4'] = $kailist['kid4'] + $money * 5;
								$up['da'] = $kailist['da'] + $money * 1.9;
							}
							if ($buyid == 5) {
								$up['kid5'] = $kailist['kid5'] + $money * 5;
								$up['da'] = $kailist['da'] + $money * 1.9;
							}
							if ($buyid == 6) {
								$up['kid6'] = $kailist['kid6'] + $money * 5;
								$up['da'] = $kailist['da'] + $money * 1.9;
							}
							if ($buyid == 7) {    //押大
								$up['da'] = $kailist['da'] + $money * 1.9;

							}
							if ($buyid == 8) {    //押小
								$up['xiao'] = $kailist['xiao'] + $money * 1.9;

							}

							$up['allmoney'] = $kailist['allmoney'] + $money;
							$up['allnu'] = $kailist['allnum'] + 1;
							M('kailog')->where(array('id' => $kailist['id']))->save($up);
							M('member')->where(array('username'=>$_SESSION['username']))->save(array('jinbi' => $user['jinbi'] - $money));
							$username = $_SESSION['username'];

							shangcheng_log($username,$money,'猜大小',0);
							//var_dump($user);die;
							$this->ajaxReturn(array('status' => 1, 'info' => '购买成功'));
						} else {
							$this->ajaxReturn(array('status' => 0, 'info' => '购买失败'));
						}
					} else {
						$this->ajaxReturn(array('status' => 2, 'info' => '余额不足,请确定充值'));
					}

			}

			$this->assign('name', $name);
			$this->assign('id', $id);
			$this->display();
		}
		//开奖历史
		public function lishi()
		{
			$list = M('kailog')->where(array('status' => 2))->order('id desc')->select();
			$this->assign('list', $list);
			$this->display();
		}
		//投注记录
		public function playlog()
		{
			$user = M('member')->where(array('username'=>$_SESSION['username']))->find();
			if (empty($user)) {
				$this->redirect('/index.php/index/login/index');
			}
			$info = M('buylog')->where(array('uid' => $user['id']))->order('starttime desc')->select();
			$this->assign('info', $info);
			$this->display();
		}

	}
?>