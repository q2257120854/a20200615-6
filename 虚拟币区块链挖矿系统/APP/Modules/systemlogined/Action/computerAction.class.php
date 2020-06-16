<?php
	/**
	 * 系统日志控制器
	 */
	Class computerAction extends Action{

		/**
		 * 奖金结算
		 * @return [type] [description]
		 */
		public function actionComputer(){
			//结算前先备份数据库
	        $DataDir = RUNTIME_PATH.'databak/';
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
	        $mr->backup();
	        //添加日志操作
	        $desc = '备份数据库';
	        write_log('admin','admin',$desc);

	        //备份完成
	    	$member = M('member');
	        $memberlist = $member->where(array('status'=>1,'fhsum'=>array('lt',3600)))->select();
	        foreach ($memberlist as $value) {
	            $d_jb    = C('BONUS_DAY_JB');//每日金币
	            $d_jzz   = C('BONUS_DAY_JZZ');//每日金种子
	            $d_bonus = $d_jb + $d_jzz;//每日分红

	            $d_bonus = gettop($value['username'],$d_bonus);
	            $d_jb = $d_bonus * 0.65;
	            $d_jzz = $d_bonus * 0.35;

	            $ldj     = $d_bonus * C('BONUS_LDJ');
	            $ldj_jb  = $ldj * 0.65;
	            $ldj_jzz = $ldj * 0.35;
	            //写入奖金明细
	            $bonus = M('bonus');
	            $data = array();
	            $data['member'] = $value['username'];
	            $data['addtime'] = time();
	            $data['type'] = '市场分红';
	            $data['jinbi'] = $d_jb;
	            $data['jinzhongzi'] = $d_jzz;
	            $data['cumulative'] = $d_bonus;
	            $data['desc'] = '市场分红';
	            $bonus->add($data);
	            
	            $jinbidetail = M('jinbidetail');
	            $jinzhongzidetail = M('jinzhongzidetail');
	            //写入金币明细
	            $oldjinbi = $member->where(array('username'=>$value['username']))->getField('jinbi');
	            $data = array();
	            $data['member']  = $value['username'];
	            $data['adds']  = $d_jb;
	            $data['balance'] = floatval($oldjinbi) + floatval($d_jb);
	            $data['addtime'] = time();
	            $data['desc']    = '市场分红';
	            $jinbidetail->add($data);
	            //写入金种子明细
	            $oldjzz = $member->where(array('username'=>$value['username']))->getField('jinzhongzi');
	            $data = array();
	            $data['member']  = $value['username'];
	            $data['adds']  = $d_jzz;
	            $data['balance'] = floatval($oldjzz) + floatval($d_jzz);
	            $data['addtime'] = time();
	            $data['desc']    = '市场分红*35%';
	            $jinzhongzidetail->add($data);
	            //更新余额
	            $member->where(array('username'=>$value['username']))->setInc('jinbi',$d_jb);
	            $member->where(array('username'=>$value['username']))->setInc('jinzhongzi',$d_jzz);
	            $mjzz = $member->where(array('username'=>$value['username']))->getField('jinzhongzi');
	            if (floatval($mjzz) > floatval(C('BONUS_TOPJZZ'))) {
	                auto_new_member($value['username']);
	            }
	            //更新分红统计数据
	            $member->where(array('username'=>$value['username']))->setInc('fhsum',$d_bonus);
	            
	            //更新9代内会员总量及9代内有效数量
	            $path = $member->where(array('username'=>$value['username']))->getField('parentpath');
	            $path = explode('|', $path);
	            $path = implode(',', array_filter($path));
	            $sql = "select * from ds_member where id in (". $path .") order by parentlayer desc";
	            $model = new Model();
	            $parent_list = $model->query($sql);
	            $i = 1;
	            foreach ($parent_list as $v) {
	                if ($v['parentcount']>=$i) {
	                    //开始处理领导奖金
	                    $data = array();
	                    $data['member'] = $v['username'];
	                    $data['addtime'] = time();
	                    $data['type'] = '领导奖';
	                    $data['jinbi'] = $ldj_jb;
	                    $data['jinzhongzi'] = $ldj_jzz;
	                    $data['cumulative'] = $ldj;
	                    $data['desc'] = '领导奖';
	                    $bonus->add($data);
	                    //写入金币明细
	                    $oldjinbi = $member->where(array('username'=>$v['username']))->getField('jinbi');
	                    $data = array();
	                    $data['member']  = $v['username'];
	                    $data['adds']  = $ldj_jb;
	                    $data['balance'] = floatval($oldjinbi) + floatval($ldj_jb);
	                    $data['addtime'] = time();
	                    $data['desc']    = '领导奖';
	                    $jinbidetail->add($data);
	                    //写入金种子明细
	                    $oldjzz = $member->where(array('username'=>$v['username']))->getField('jinzhongzi');
	                    $data = array();
	                    $data['member']  = $v['username'];
	                    $data['adds']  = $ldj_jzz;
	                    $data['balance'] = floatval($oldjzz) + floatval($ldj_jzz);
	                    $data['addtime'] = time();
	                    $data['desc']    = '领导奖*35%';
	                    $jinzhongzidetail->add($data);
	                    //更新余额
	                    $member->where(array('username'=>$v['username']))->setInc('jinbi',$ldj_jb);
	                    $member->where(array('username'=>$v['username']))->setInc('jinzhongzi',$ldj_jzz);
	                    $mjzz = $member->where(array('username'=>$v['username']))->getField('jinzhongzi');
	                    if (floatval($mjzz) > floatval(C('BONUS_TOPJZZ'))) {
	                        auto_new_member($v['username']);
	                    }
	                    //更新分红统计数据
	                    $member->where(array('username'=>$v['username']))->setInc('ldsum',$ldj);
	                }             
	                $i++;
	                if ($i>10) {
	                    break;
	                }
	            }
	        }
	        echo 'isok';
		}
	}