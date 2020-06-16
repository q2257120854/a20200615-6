<?php
/**
 * tommie_douyin模块微站定义
 *
 * @author tommie
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Tommie_duanshipingModuleSite extends WeModuleSite {
	public function doWebConfig() {
		global $_W,$_GPC;
		$confs = pdo_get('tommie_douyin_config',array('uniacid'=>$_W['uniacid']));
		if ($_W['ispost']) {
			if (!$confs) {
				$data = array(
					'uniacid'=>$_W['uniacid'],
					'app_name'=>$_GPC['app_name'],
					'api_url'=>$_GPC['api_url'],
					'help_url'=>$_GPC['help_url'],
					'client'=>trim($_GPC['client']),
					'clientKey'=>trim($_GPC['clientKey']),
					'title'=>$_GPC['title'],
					'description'=>$_GPC['description'],
					'qq_group'=>$_GPC['qq_group'],
					'share_title'=>$_GPC['share_title'],
					'qq_num'=>$_GPC['qq_num'],
					'ad_id'=>$_GPC['ad_id'],
					'contact'=>$_GPC['contact'],
					'share_img'=>$_GPC['shareimg'],
					'adtext' => $_GPC['adtext'],
					'copytext' => $_GPC['copytext'],
					'adimg' => $_GPC['adimg'],
					'mix_num' => $_GPC['mix_num'],
					'invite_award' => $_GPC['invite_award'],
					'is_pay' => $_GPC['is_pay'],
					'isaudit' => $_GPC['isaudit'],
					'is_member' => $_GPC['is_member'],
					'onpayenter' => $_GPC['onpayenter'],
					'progress' => $_GPC['progress'],
					'regtime'=>time()				
				);
				$result = pdo_insert('tommie_douyin_config', $data);
	
				if (!empty($result)) {
					message('添加成功',$this->createWebUrl('config'));
				}
			}else{
				$data = array(
					'app_name'=>$_GPC['app_name'],
					'api_url'=>$_GPC['api_url'],
					'help_url'=>$_GPC['help_url'],
					'client'=>$_GPC['client'],
					'clientKey'=>$_GPC['clientKey'],
					'title'=>$_GPC['title'],
					'description'=>$_GPC['description'],
					'qq_group'=>$_GPC['qq_group'],
					'share_title'=>$_GPC['share_title'],
					'qq_num'=>$_GPC['qq_num'],
					'ad_id'=>$_GPC['ad_id'],
					'contact'=>$_GPC['contact'],
					'share_img'=>$_GPC['shareimg'],
					'adtext' => $_GPC['adtext'],
					'copytext' => $_GPC['copytext'],
					'adimg' => $_GPC['adimg'],
					'mix_num' => $_GPC['mix_num'],
					'invite_award' => $_GPC['invite_award'],
					'is_pay' => $_GPC['is_pay'],
					'isaudit' => $_GPC['isaudit'],
					'is_member' => $_GPC['is_member'],
					'onpayenter' => $_GPC['onpayenter'],
					'progress' => $_GPC['progress'],
					'regtime'=>time()				
				);
				$result = pdo_update('tommie_douyin_config',$data,array('uniacid'=>$_W['uniacid']));	
				if (!empty($result)) {
					message('更新成功',$this->createWebUrl('config'));
				}
			}

		}
		include $this->template('config');
		

	}


		public function doWebUser() {
			global $_W,$_GPC;
			if ($_GPC['method'] == 'delete') {
				pdo_delete('tommie_douyin_member', array('id' => $_GPC['id']));
			}
			if ($_W['ispost']) {
				$name = $_GPC['name'];
				$sql = "select * from ims_tommie_douyin_member where uniacid = :uniacid and nickname like '%".$name ."%' limit 0,20";
				$orderdata = pdo_fetchall($sql,array(':uniacid'=>$_W['uniacid']));
				$n = count($orderdata) + 1;
				include $this->template('user');
			}else{
				$sql = "select * from ims_tommie_douyin_member where uniacid = :uniacid";
				$sources = pdo_fetchall($sql,array(":uniacid"=>$_W['uniacid']));
				$total = count($sources);
				$pageindex = max($_GPC['page'],1);
				$pagesize = 12;
				$pager = pagination($total,$pageindex,$pagesize);
				$p = ($pageindex-1)*12;
				$sql.=" order by id desc limit ".$p.",".$pagesize;
				$orderdata = pdo_fetchall($sql,array(':uniacid'=>$_W['uniacid']));
				$n = $total - $p + 1; 
				include $this->template('user');
			}
	

	}

		public function doWebVideo() {
			global $_W,$_GPC;
			if ($_GPC['method'] == 'delete') {
				pdo_delete('tommie_douyin_video', array('id' => $_GPC['id']));
			}

			$sql = "select * from ims_tommie_douyin_video where uniacid = :uniacid";
			$sources = pdo_fetchall($sql,array(":uniacid"=>$_W['uniacid']));
			$total = count($sources);
			$pageindex = max($_GPC['page'],1);
			$pagesize = 12;
			$pager = pagination($total,$pageindex,$pagesize);
			$p = ($pageindex-1)*12;
			$sql.=" order by id desc limit ".$p.",".$pagesize;
			$orderdata = pdo_fetchall($sql,array(':uniacid'=>$_W['uniacid']));
			$n = $total - $p + 1;  
			include $this->template('video');
	}
		public function doWebEdituser(){
			global $_W,$_GPC;
			if ($_W['ispost']) {
				$data = ['maximum'=>$_GPC['maximum']];
				pdo_update('tommie_douyin_member',$data,['id'=>$_GPC['id']]);
				message('更新成功',$this->createWebUrl('user'));
			}
			$config = pdo_get('tommie_douyin_member',['id'=>$_GPC['id']]);
			include $this->template('edituser');
		}

		public function doWebEditvideo(){
			global $_W,$_GPC;
			if ($_W['ispost']) {
				$data = ['title'=>$_GPC['title']];
				pdo_update('tommie_douyin_video',$data,['id'=>$_GPC['id']]);
				message('更新成功',$this->createWebUrl('video'));
			}
			$video = pdo_get('tommie_douyin_video',['id'=>$_GPC['id']]);
			include $this->template('editvideo');
		}
		public function doWebTuijian(){
			global $_W,$_GPC;
			if ($_GPC['method'] == "add") {
				if ($_W['ispost']) {
					$data = array(
						'uniacid'=>$_GPC['__uniacid'],
						'img' => $_GPC['img'],
						'app_id' => $_GPC['appid'],
						'app_name' => $_GPC['appname'],
						'path' => $_GPC['path'],
						'regtime' => time()
					);
					$result= pdo_insert('tommie_douyin_tuijian',$data);
					if (!empty($result)) {
						message('添加成功',$this->createWebUrl('tuijian'));
					}
				}else{
					include $this->template('addtuijian');
				}
			}elseif($_GPC['method'] == "edit"){
				$tuijiandata = pdo_get('tommie_douyin_tuijian',['id'=>$_GPC['id']]);
				if ($_W['ispost']) {
					$data = array(
						'img' => $_GPC['img'],
						'app_id' => $_GPC['appid'],
						'app_name' => $_GPC['appname'],
						'path' => $_GPC['path'],
						'regtime' => time()
					);
					$result= pdo_update('tommie_douyin_tuijian',$data,['id'=>$_GPC['id']]);
					if (!empty($result)) {
						message('更新成功',$this->createWebUrl('tuijian'));
					}
				}
				include $this->template('edittuijian');
			}elseif($_GPC['method'] == "delete"){
				pdo_delete('tommie_douyin_tuijian',['id'=>$_GPC['id']]);
				message('删除成功',$this->createWebUrl('tuijian'));
			}else {
				$tuijiandata = pdo_getall('tommie_douyin_tuijian',['uniacid'=>$_GPC['__uniacid']]);
				$n = count($tuijiandata) + 1;
				include $this->template('tuijian');
				}
			}


			public function doWebPayconfig(){
				global $_W,$_GPC;
				$config = pdo_get('ims_tommie_douyin_payconfig',['uniacid'=>$_GPC['__uniacid']]);
				if($_W['ispost']){
					if(empty($config)){
						$data = array(
							'uniacid'=>$_GPC['__uniacid'],
							'money_a'=>$_GPC['moneya'],
							'num_a'=>$_GPC['numa'],
							'money_b'=>$_GPC['moneyb'],
							'num_b'=>$_GPC['numb'],
							'money_c'=>$_GPC['moneyc'],
							'num_c'=>$_GPC['numc'],
							'regtime'=>time()
						);
						pdo_insert('tommie_douyin_payconfig',$data);
					}else{
						$data = array(
							'money_a'=>$_GPC['moneya'],
							'num_a'=>$_GPC['numa'],
							'money_b'=>$_GPC['moneyb'],
							'num_b'=>$_GPC['numb'],
							'money_c'=>$_GPC['moneyc'],
							'num_c'=>$_GPC['numc'],
							'regtime'=>time()
						);
						pdo_update('tommie_douyin_payconfig',$data,['uniacid'=>$_GPC['__uniacid']]);
						
					}
					message('更新成功',$this->createWebUrl('payconfig'));
				}

				include $this->template('payconfig');
			}


			public function doWebOrder(){
				global $_W,$_GPC;
				$ismember = pdo_get('tommie_douyin_config',['uniacid'=>$_W['uniacid']],['is_member']);
				if($ismember['is_member'] == 1){

					$sql = "select * ,v.regtime AS t from ims_tommie_douyin_viporder v left join ims_tommie_douyin_member m on v.openid=m.openid where v.uniacid = :uniacid";
					$sources = pdo_fetchall($sql,array(":uniacid"=>$_W['uniacid']));

				
					$total = count($sources);
					$pageindex = max($_GPC['page'],1);
					$pagesize = 12;
					$pager = pagination($total,$pageindex,$pagesize);
					$p = ($pageindex-1)*12;
					$sql.=" order by v.id desc limit ".$p.",".$pagesize;
					$orderdata = pdo_fetchall($sql,array(':uniacid'=>$_W['uniacid']));
					$n = $total - $p + 1;  
					include $this->template('keyorder');
				}else{
					$sql = "select * ,o.regtime AS t from ims_tommie_douyin_order o left join ims_tommie_douyin_member m on o.openid=m.openid where o.uniacid = :uniacid";
					$sources = pdo_fetchall($sql,array(":uniacid"=>$_W['uniacid']));
				
					$total = count($sources);
					$pageindex = max($_GPC['page'],1);
					$pagesize = 12;
					$pager = pagination($total,$pageindex,$pagesize);
					$p = ($pageindex-1)*12;
					$sql.=" order by o.id desc limit ".$p.",".$pagesize;
					$orderdata = pdo_fetchall($sql,array(':uniacid'=>$_W['uniacid']));
					$n = $total - $p + 1;  
					include $this->template('order');
				}

				
			}

			public function doWebMember(){
				global $_W, $_GPC;
				if ($_GPC['method'] == 'delete') {
					pdo_delete('tommie_douyin_vipmember', array('openid' => $_GPC['openid']));
				}
				if ($_W['ispost']) {
					$name = $_GPC['name'];
					$sql = "select *,v.regtime AS t from ims_tommie_douyin_vipmember v left join ims_tommie_douyin_member m on v.openid=m.openid where v.uniacid = :uniacid and nickname like '%".$name ."%' limit 0,20";
					$orderdata = pdo_fetchall($sql,array(':uniacid'=>$_W['uniacid']));
					$n = count($orderdata) + 1;
					include $this->template('member');
				}else{
					$sql = "select *,v.regtime AS t from ims_tommie_douyin_vipmember v left join ims_tommie_douyin_member m on v.openid=m.openid where v.uniacid = :uniacid";
					$sources = pdo_fetchall($sql,array(":uniacid"=>$_W['uniacid']));
					$total = count($sources);
					$pageindex = max($_GPC['page'],1);
					$pagesize = 12;
					$pager = pagination($total,$pageindex,$pagesize);
					$p = ($pageindex-1)*12;
					$sql.=" order by v.id desc limit ".$p.",".$pagesize;
					$orderdata = pdo_fetchall($sql,array(':uniacid'=>$_W['uniacid']));
					$n = $total - $p + 1; 
					include $this->template('member');
				}
	
			}

			public function doWebEditmember(){
				global $_W, $_GPC;
				$dates = pdo_get('tommie_douyin_vipmember',['openid'=>$_GPC['openid']]);
				$date = date('Y-m-d H:i:s', $dates['end_time']); 
				if ($_W['ispost']) {
					$lasttime = strtotime(date($_GPC['date'])); 
					pdo_update('tommie_douyin_vipmember',array('end_time'=>$lasttime,'regtime'=>time()),array('openid'=>$_GPC['openid']));
					message('更新成功',$this->createWebUrl('member'));
				}
				include $this->template('editmember');
			}

			public function doWebCard() {
				global $_W, $_GPC;
				$op = $_GPC['op'] ? $_GPC['op'] : 'display';
				$id = $_GPC['id'];          
				$card = pdo_get('tommie_douyin_keyword', array('id'=>$id), array() , '' , 'id DESC');       
				if ($op == 'display') {
					$pageindex = max(intval($_GPC['page']), 1); 
					$pagesize = 20;        
					$where = ' WHERE uniacid = :uniacid ';
					$params = array(
						':uniacid'=>$_W['uniacid'],             
					);          
					$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tommie_douyin_keyword') . $where , $params);          
					$pager = pagination($total, $pageindex, $pagesize);
					$sql = ' SELECT * FROM '.tablename('tommie_douyin_keyword').$where.' ORDER BY id DESC LIMIT '.(($pageindex -1) * $pagesize).','. $pagesize;         
					$list = pdo_fetchall($sql, $params, 'id');              
				} 
				if ($op == 'post') {
					if (checksubmit('submit')) {                
						$data = $_GPC['data'];
						if (empty($data['card_id'])) { 
							message('抱歉，请输入卡密标识！');
						}
						$card_id = pdo_get('tommie_douyin_keyword', array('card_id'=>$data['card_id']), array() , '' , 'id DESC'); 
						if ($card_id) {
							 message('抱歉，请输入卡密标识已存在，请重新换个！');
						}
						$data['uniacid'] = $_W['uniacid'];  
						$card = $this->cards($_GPC['weishu'],$data['num']);                
						pdo_insert('tommie_douyin_keyword', $data);
						$id = pdo_insertid();
						foreach ($card as $value) {                 
							pdo_insert('tommie_douyin_keyword_id', array('card_id'=>$id,'pwd'=>$data['card_id'].$value,'uniacid'=>$_W['uniacid'],'day'=>$data['day']));
						}               
						message('生成成功！', $this->createWebUrl('card'), 'success'); 
					}
				}
				if ($op == 'delete') {
					$id = intval($_GPC['id']);          
					pdo_delete('tommie_douyin_keyword_id', array('card_id' => $id));
					pdo_delete('tommie_douyin_keyword', array('id' => $id));
					message('删除成功！', $this->createWebUrl('card'), 'success');
				}
				if ($op == 'card') {            
					$pageindex = max(intval($_GPC['page']), 1); 
					$pagesize = 20;         
					$where = ' WHERE uniacid = :uniacid AND card_id = :card_id ';
					$params = array(
						':uniacid'=>$_W['uniacid'],             
						':card_id'=>$id,                
					);          
					if ($_GPC['pwd']) {
					   $where .= ' AND pwd = :pwd ';
					   $params[':pwd'] = $_GPC['pwd'];
					}
					$total = pdo_fetchcolumn('SELECT count(distinct pwd) FROM ' . tablename('tommie_douyin_keyword_id') . $where , $params);            
					$ydh = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('tommie_douyin_keyword_id') . $where . ' AND status = 1 ' , $params);            
					$pager = pagination($total, $pageindex, $pagesize);
					$sql = ' SELECT * , count(distinct pwd) FROM '.tablename('tommie_douyin_keyword_id').$where.' GROUP BY pwd ORDER BY id DESC LIMIT '.(($pageindex -1) * $pagesize).','. $pagesize;
					$list = pdo_fetchall($sql, $params, 'id');
					if(checksubmit('export_submit', true)) {                
						$sql = "SELECT * , count(distinct pwd) FROM ".tablename('tommie_douyin_keyword_id'). $where ." GROUP BY pwd ORDER BY id DESC";
						$listexcel = pdo_fetchall($sql,$params);
						$header = array(                    
							'card_id' => '卡密名称',                    
							'pwd' => '卡密密码',                    
							'nickname' => '会员',                     
							'status' => '使用状态',                 
						);              
						$keys = array_keys($header);
						$html = "\xEF\xBB\xBF";
						foreach($header as $li) {
							$html .= $li . "\t ";
						}
						$html .= "\n";
						if(!empty($listexcel)) {
							$size = ceil(count($listexcel) / 500);
							for($i = 0; $i < $size; $i++) {
								$buffer = array_slice($listexcel, $i * 500, 500);
								foreach($buffer as $row) {
									$member =  $this->members($_W['uniacid'],$row['openid']);
									$row['card_id'] = $card['title'];
									$row['nickname'] = $member['nickname'];
									$row['status'] = $row['status'] ? '已兑换' : '未兑换';
									foreach($keys as $key) {
										$data[] = $row[$key];
									}
			
									$user[] = implode("\t ", $data) . "\t ";
									unset($data);
								}
							}
							$html .= implode("\n", $user);
						}
						
						header("Pragma: public");
						header("Expires: 0");
						header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
						header("Content-Type:application/force-download");
						header("Content-Type:application/vnd.ms-execl");
						header("Content-Type:application/octet-stream");
						header("Content-Type:application/download");;
						header('Content-Disposition:attachment;filename="卡密.xls"');
						header("Content-Transfer-Encoding:binary");
						echo $html;
						exit();
					}   
				}
				include $this->template('card'); 
			}
		private function members($uniacid,$openid){
			return pdo_get('tommie_douyin_member',['uniacid'=>$uniacid,'openid'=>$openid]);
		}
		public function cards($weishu,$num){
			$list = [];
			for ($i=0; $i < $num; $i++) { 
				$list[$i] = $this->createNoncestr($weishu);
			}
			return $list;

		}	

		public function createNoncestr($length = 32) {
			$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
			$str = "";
			for ($i = 0; $i < $length; $i++) {
				$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			}
			return $str;
		}


		public function randomkeys($length) {
			$pattern = '1234567890123456789012345678905678901234';
			$key = null;
			for ($i = 0; $i < $length; $i++) {
				$key .= $pattern{mt_rand(0, 30)};  
			}
			return $key;
		}

}