<?php  
	/**
	 * 系统设置控制器
	 */
	Class SystemAction extends CommonAction{

		/**
		 * 系统日志视图
		 * @return [type] [description]
		 */
		public function systemLog(){
			$Data = M('log'); // 实例化Data数据对象
	        import('ORG.Util.Page');// 导入分页类
	        $map = array();
	        if (isset($_GET['account']) && $_GET['account']!='') {
	        	$map['logaccount'] = $_GET['account']; 
	        }

	        $count      = $Data->where($map)->count();// 查询满足要求的总记录数
	        $Page       = new Page($count,10);// 实例化分页类 传入总记录数
	        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
	        $nowPage = isset($_GET['p'])?$_GET['p']:1;
	        $list = $Data->where($map)->order('logtime desc')->page($nowPage.','.$Page->listRows)->select();
	        $show       = $Page->show();// 分页显示输出
	        $this->assign('page',$show);// 赋值分页输出
	        $this->assign('list',$list);// 赋值数据集
	        $this->display(); // 输出模板
		}

		//系统配置视图
		public function customSetting(){
			$config = include './App/Conf/system.php';
			$this->assign('config',$config);
			$this->display();
		}

		//奖金配置处理
		public function bonusConf(){
			$path = './App/Conf/system.php';
			$config = include $path;
			$config['z_num']      = I('post.z_num',0,'floatval');
			$config['zs_num']      = I('post.zs_num',0,'floatval');
			$config['min_danjia']      = I('post.min_danjia',0,'floatval');
			$config['max_danjia']      = I('post.max_danjia',0,'floatval');
			$config['jiaoyi_shouxu']      = I('post.jiaoyi_shouxu',0,'floatval');
			$config['bsbei']      = I('post.bsbei',0,'floatval');
			$config['rmb_hl']      = I('post.rmb_hl',0,'floatval');
			$config['btc_hl']      = I('post.btc_hl',0,'floatval');			
			
			$config['tjjnum1']      = I('post.tjjnum1',0,'floatval');	
			$config['gonglv1']      = I('post.gonglv1',0,'floatval');	
			$config['shouxu1']      = I('post.shouxu1',0,'floatval');			

			$config['tjjnum2']      = I('post.tjjnum2',0,'floatval');	
			$config['xnum1']      = I('post.xnum1',0,'floatval');	
			$config['shouxu2']      = I('post.shouxu2',0,'floatval');
			
			$config['tjjnum3']      = I('post.tjjnum3',0,'floatval');	
			$config['xnum2']      = I('post.xnum2',0,'floatval');	
			$config['shouxu3']      = I('post.shouxu3',0,'floatval');
			
			$config['min_zhitui']      = I('post.min_zhitui',0,'floatval');	
			$config['yykjsl']      = I('post.yykjsl',0,'floatval');	
			$config['min_buy']      = I('post.min_buy',0,'floatval');	
			$config['max_sell']      = I('post.max_sell',0,'floatval');	
			$config['min_buyje']      = I('post.min_buyje',0,'floatval');	

			$config['tjj']      = I('post.tjj',0,'floatval');
			
			$config['tjj_1']      = I('post.tjj_1',0,'floatval');
			$config['tjj_2']      = I('post.tjj_2',0,'floatval');
			$config['tjj_3']      = I('post.tjj_3',0,'floatval');
			$config['tjj_4']      = I('post.tjj_4',0,'floatval');
			$config['tjj_5']      = I('post.tjj_5',0,'floatval');
			$config['tjj_6']      = I('post.tjj_6',0,'floatval');
			
			$config['jy_open']      = I('post.jy_open',0,'intval');
			$config['jy_time']      = I('post.jy_time','','trim');
			
			$config['max_qglkb']      = I('post.max_qglkb',0,'floatval');
			$config['max_cslkb']      = I('post.max_cslkb',0,'floatval');
			
			$config['min_cslkb']      = I('post.min_cslkb',0,'floatval');
			
			
			$config['tousu_time']      = I('post.tousu_time',0,'intval');
			
			
			$config['everyday_rose']      = I('post.everyday_rose',0,'floatval');
			$config['everyday_drop']      = I('post.everyday_drop',0,'floatval');
			$config['everyday_last_time']      = I('post.everyday_last_time',0,'intval');
			
			
			$config['adurl']      = I('post.adurl','','trim');
			
			$config['open_web']      = I('post.open_web',0,'intval');
			$config['open_web_notice']      = I('post.open_web_notice','','trim');
			$config['jiesuan_time']      = I('post.jiesuan_time',0,'floatval');
			
			
			
			$config['cb1']        = I('post.cb1',0,'floatval');			
			$config['cbsy1']      = I('post.cbsy1',0,'floatval');		
			$config['cb2']        = I('post.cb2',0,'floatval');			
			$config['cbsy2']      = I('post.cbsy2',0,'floatval');	
            $config['cbday']      = I('post.cbday',0,'floatval');			
 			$data = "<?php\r\nreturn " . var_export($config, true) . ";\r\n?>";
			if (file_put_contents($path, $data)) {
				$this->success('修改成功', U(GROUP_NAME.'/System/customSetting'));
			} else {
				$this->error('修改失败， 请修改' . $path . '的写入权限');
			}
		} 
		
		//电子货币提现设置处理
		public function withdrawConf(){
			$path = './App/Conf/system.php';
			$config = include $path;
			$config['WITHDRAW_STATUS'] = I('post.withdraw_status','off','strval');
			$config['WITHDRAW_BANK'] = I('post.withdraw_bank','off','strval');
			$config['WITHDRAW_PASS2'] = I('post.withdraw_pass2','off','strval');
			$config['WITHDRAW_IN_DAY_NUM'] = I('post.withdraw_in_day_num',0,'intval');
			$config['WITHDRAW_TAX_IN'] = I('post.withdraw_tax_in',0,'intval');
			$config['WITHDRAW_TAX'] = I('post.withdraw_tax',0,'intval');
			$config['WITHDRAW_TAX_MIN'] = I('post.withdraw_tax_min',0,'intval');
			$config['WITHDRAW_TAX_MAX'] = I('post.withdraw_tax_max',0,'intval');
			$config['WITHDRAW_MIN'] = I('post.withdraw_min',0,'intval');
			$config['WITHDRAW_INT'] = I('post.withdraw_int',0,'intval');
			
			$data = "<?php\r\nreturn " . var_export($config, true) . ";\r\n?>";

			if (file_put_contents($path, $data)) {
				$this->success('修改成功', U(GROUP_NAME.'/System/customSetting'));
			} else {
				$this->error('修改失败， 请修改' . $path . '的写入权限');
			}
		}

		//电子货币转账设置处理
		public function transferConf(){
			$path = './App/Conf/system.php';
			$config = include $path;
			$config['TRANSFER_STATUS'] = I('post.transfer_status','off','strval');
			$config['TRANSFER_PASS2'] = I('post.transfer_pass2','off','strval');
			$config['TRANSFER_MIN'] = I('post.transfer_min',0,'intval');
			$config['TRANSFER_MAX'] = I('post.transfer_max',0,'intval');
			$config['TRANSFER_TAX'] = I('post.transfer_tax',0,'intval');
			$config['TRANSFER_TAX_MIN'] = I('post.transfer_tax_min',0,'intval');
			$config['TRANSFER_TAX_MAX'] = I('post.transfer_tax_max',0,'intval');
			$config['TRANSFER_PROPORTION'] = I('post.transfer_proportion',1,'intval');
			$config['TRANSFER_GROUP'] = I('post.transfer_group',0,'intval');
			
			$data = "<?php\r\nreturn " . var_export($config, true) . ";\r\n?>";

			if (file_put_contents($path, $data)) {
				$this->success('修改成功', U(GROUP_NAME.'/System/customSetting'));
			} else {
				$this->error('修改失败， 请修改' . $path . '的写入权限');
			}
		}

		//电子货币充值设置处理
		public function rechargeConf(){
			$path = './App/Conf/system.php';
			$config = include $path;
			$config['RECHARGE_MIN'] = I('post.recharge_min',0,'intval');
			$config['RECHARGE_MAX'] = I('post.recharge_max',0,'intval');
			$config['RECHARGE_PROPORTION'] = I('post.recharge_proportion');
			$config['RECHARGE_GIFT'] = I('post.recharge_gift',0,'intval');
			
			$config['recharge_note'] = I('post.recharge_note');
			$config['recharge_is'] = I('post.recharge_is',0,'intval');
			$config['recharge_type'] = I('post.recharge_type',0,'intval');
			
			$config['recharge_examine_type'] = I('post.recharge_examine_type',0,'intval');
			$config['kuangji_id'] = I('post.kuangji_id',0,'intval');
			$config['kuangji_num'] = I('post.kuangji_num',0,'intval');
			
			
			
			$data = "<?php\r\nreturn " . var_export($config, true) . ";\r\n?>";

			if (file_put_contents($path, $data)) {
				$this->success('修改成功', U(GROUP_NAME.'/System/customSetting'));
			} else {
				$this->error('修改失败， 请修改' . $path . '的写入权限');
			}

		}
		
		/**
		 * 修改会员相关配置
		 */
		public function memberConf(){
			$path = './App/Conf/system.php';
			$config = include $path;
			$config['MEMBER_LOGIN'] = I('post.memberlogin','','strval');
			$config['MEMBER_REG'] = I('post.memberreg','','strval');
			$config['NO_LOGIN_MSG'] = I('post.nologinmsg','','strval');
			$config['NO_REG_MSG'] = I('post.noregmsg','','strval');
			$config['AUTO_ACCOUNT'] = I('post.autoaccount','','strval');
			$config['ATUO_ACCOUNT_RND'] = I('post.autoaccountrnd','','strval');
			$config['ACCOUNT_PREFIX'] = I('post.accountprefix','','strval');
			$config['ACCOUNT_LENGTH'] = I('post.accountlength',0,'intval');
			$config['CODE_APIKEY'] = I('post.code_apikey','','strval');
		/* 	$config['CODE_PASSWORD'] = I('post.code_password','','strval'); */
			$config['CODE_CF'] = I('post.code_cf',0,'intval');
            $config['CODE_GQ'] = I('post.code_gq',0,'intval');	
			
			$config['sid'] = I('post.sid','','trim');
			$config['token'] = I('post.token','','trim');	
			$config['appid'] = I('post.appid','','trim');	
			$config['templateId'] = I('post.templateId','','trim');	
			$config['sms_type'] = I('post.sms_type','','trim');	
			
			
			
			
									
			$data = "<?php\r\nreturn " . var_export($config, true) . ";\r\n?>";
			
			if (file_put_contents($path, $data)) {
				$this->success('修改成功', U(GROUP_NAME.'/System/customSetting'));
			} else {
				$this->error('修改失败， 请修改' . $path . '的写入权限');
			}
		}

    public function klineacl() {
		$date['price'] = I('post.price');
		$date['date'] = time();
		if(I('post.price')<>''){
			
		if(M('date')->add($date)){
			$this->success('添加成功!');
		}else{
			$this->success('添加失败!');
		}	
		}else{
			$this->success('数据不能为空!');
		}
		
	}
		
    public function backUp() {
        $DataDir = RUNTIME_PATH.'databak/';

        if (!empty($_GET['Action'])) {
            import("ORG.Util.MySQLReback");
            $config = array(
                'host' => C('DB_HOST'),
                'port' => C('DB_PORT'),
                'userName' => C('DB_USER'),
                'userPassword' => C('DB_PWD'),
                'dbprefix' => C('DB_PREFIX'),
                'charset' => 'UTF8',
                'path' => $DataDir,
                'isCompress' => 0, //是否开启gzip压缩
                'isDownload' => 0  
            );

            $mr = new MySQLReback($config);
            $mr->setDBName(C('DB_NAME'));
            if ($_GET['Action'] == 'backup') {
                $mr->backup();
                //添加日志操作
                $desc = '备份数据库';
                write_log(session('username'),'admin',$desc);

                redirect(U(GROUP_NAME.'/system/backUp'));                 
            } elseif ($_GET['Action'] == 'RL') {
                $mr->recover($_GET['File']);
                //添加日志操作
                $desc = '还原数据库';
                write_log(session('username'),'admin',$desc);
                redirect(U(GROUP_NAME.'/system/backUp'));
                
            } elseif ($_GET['Action'] == 'Del') {
                if (@unlink($DataDir . $_GET['File'])) {
                    
                    //添加日志操作
                    $desc = '删除备份文件';
                    write_log(session('username'),'admin',$desc);
                    redirect(U(GROUP_NAME.'/system/backUp'));
                } else {                    
                    $this->error('删除失败！');
                }
            }
            if ($_GET['Action'] == 'dow') {
                function DownloadFile($fileName) {
                    ob_end_clean();
                    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Length: ' . filesize($fileName));
                    header('Content-Disposition: attachment; filename=' . basename($fileName));
                    readfile($fileName);
                }
                DownloadFile($DataDir . $_GET['file']);

                //添加日志操作
                $desc = '下载备份文件';
                write_log(session('username'),'admin',$desc);
                exit();
            }
        }

        $filelist = dir_list($DataDir);
        foreach ((array)$filelist as $r){
            $filename = explode('-',basename($r));
            $files[] = array('path'=> $r,'file'=>basename($r),'name' => $filename[0], 'size' => filesize($r), 'time' => filemtime($r));
            }
        $this->assign('files',$files);
        $this->display();
    }

    public function clearData(){
        $model = new Model();
        $model->query('delete from ds_bonus');
        $model->query('delete from ds_business');
        $model->query('delete from ds_guarantee');
        $model->query('delete from ds_jinbidetail');
        $model->query('delete from ds_jinzhongzidetail');
        $model->query('delete from ds_member where id <>1');
        $model->query('delete from ds_message');
        $model->query('delete from ds_receivable');
        $model->query('delete from ds_transfer');
        $model->query('delete from ds_log');
        $model->query('update ds_member set parentcount = 0,jinbi = 0,jinzhongzi = 0,gamecount = 0,validgamecount = 0,tjsum = 0,bdsum = 0,fhsum = 0,ldsum = 0,glsum=0,zysum = 0,manage_left_jd="",manage_right_jd=""');
        $this->success('操作成功');
    }

	}
?>