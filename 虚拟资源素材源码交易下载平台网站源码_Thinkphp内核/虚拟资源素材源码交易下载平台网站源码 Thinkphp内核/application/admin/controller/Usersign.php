<?php
namespace app\admin\controller;

use Think\Loader;
use think\Model;
use think\Db;
use org\Http;

class Usersign extends AdminBase{
public $uid;

     protected function _initialize()
	 {

	$this->uid=session ( 'userid' );
	 }

    public function monthlog(){
    if($this->uid==""){
      echo "没有登录不能查看！";
    }else{
        // 日历列表\
        $totalscore=0;
    $monthSign = $this->getMonthSign();
    $rules=Db::name('user_signrule')->order('days asc')->select();
    $totals = Db::name('point_note')->where(['controller'=>'usersign','uid'=>$this->uid])->field('SUM(score) as scores')->select();
  // print_r($totals);die();
    if($totals[0]['scores']!=null) $totalscore=$totals[0]['scores'];
    // 今天签到
    $data = $this->todayData();
    $todayscore = $this->getTodayScores($data['days']);
    $tomorrowscore = $this->getTodayScores($data['days']+1);
    if($data['is_sign'] == 1){
      $this->assign('signdata',$data);
    }
    $this->assign('rules',$rules);
    $this->assign('todayscore',$todayscore);
    $this->assign('tomorrowscore',$tomorrowscore);
    $this->assign('totalscore',$totalscore);
    $this->assign('monthSign',$monthSign);
    echo $this->fetch('addons//usersign@usersign/monthlog');
    }
  }

 public function setrule(){		
    $rules=Db::name('user_signrule')->select();
		$this->assign('rules',$rules);
		echo $this->fetch('addons//usersign@usersign/setrule');
	}
 public function insertorupdate(){
		$data=$this->request->post();
    $daysarr=$data['days'];
    $scorearr=$data['score'];
    Db::name('user_signrule')->where('id','>',0)->delete();
    $arr=[];
    foreach($daysarr as $i=>$days){
      $score=$scorearr[$i];
      $arr[$i]=['days'=>$days,'score'=>$score];
    }
		Db::name('user_signrule')->insertAll($arr);
	  $this->success('保存成功',url('addons/adminlist',array('name'=>'usersign')));
	}

  /**
  * 执行当天签到
  * @return json 签到成功返回 {status:1,info:'已签到'}
  */
  public function sign(){
    if (! session ( 'userid' ) || ! session ( 'username' )) {
		exit('{"code":-1,"msg":"亲，登陆后才能签到哦"}');
		} else {
      $uid=$this->uid;
    $todayData = $this->todayData();
    if($todayData['is_sign'] == 1){
      exit('{"code":-1,"msg":"你今天已经签过到了"}');
    }else{
      $data = $this->getInsertData($uid);
      $days=$data['days'];
      // 无今天数据
      if($todayData == NULL){
        $data['uid'] = $uid;
        $data['stime'] = time();
        $id=Db::name('user_sign')->insertGetId($data);
      }else{
        $save = Db::name('user_sign')->where("id = {$todayData['id']}")->save($data);
      }
      if($id or $save){
        $score = $this->getTodayScores($days);      
        // 为该用户添加积分
        if($score>0){
        point_note($score,$uid,'usersign',$id);
        }
        exit('{"code":100,"score":"'.$score.'","days":"'.$days.'"}');
      }else{
         exit('{"code":-1,"msg":"签到失败，请刷新后重试！"}');
      }
    }
    }
  }
  /**
  * 返回每次签到要插入的数据
  *
  * @param int $uid 用户id
  * @return array(
  *  'days'   =>  '天数',
  *  'is_sign'  =>  '是否签到,用1表示已经签到',
  *  'stime'   =>  '签到时间',
  * );
  */
  protected function getInsertData($uid){
    // 昨天的连续签到天数
    $start_time = strtotime(date('Y-m-d 0:0:0',time()-86400))-1;
    $end_time  = strtotime(date('Y-m-d 23:59:59',time()-86400))+1;
    $days = Db::name('user_sign')->where("uid = $uid and stime > $start_time and stime < $end_time")->value('days');
    if($days){
      $days++;
      if($days > 30){
        $days = 1;
      }
    }else{
      $days = 1;
    }
    return array(
      'days'    => $days,
      'is_sign'  => 1,
      'stime'   => time()
    );
  }
  /**
  * 用户当天签到的数据
  * @return array 签到信息 is_sign,stime 等
  */
  public function todayData(){
    $time = time();
    $start_stime  = strtotime(date('Y-m-d 0:0:0',$time))-1;
    $end_stime = strtotime(date('Y-m-d 23:59:59',$time))+1;
    return Db::name('user_sign')->where("uid = {$this->uid} and stime > $start_stime and stime < $end_stime")->find();

  }
  /**
  * 积分规则，返回连续签到的天数对应的积分
  *
  * @param int $days 当天应该得的分数
  * @return int 积分
  */
  protected function getTodayScores($days){
    // if($days == 30){
    //   return 50;
    // }else if($days > 19){
    //   return 8;
    // }else if($days > 9){
    //   return 5;
    // }else{
    //   return 3;
    // }
    $score=0;
    $scores=Db::name('user_signrule')->where("days <= $days")->order('days desc')->limit(1)->value('score');
    if($scores)  $score=$scores;

    return $score;

  }
  /**
  * 显示签到列表
  *
  * @param array  $signDays 某月签到的日期 array(1,2,3,4,5,12,13)
  * @param int $year    可选，年份
  * @param int $month   可选，月份
  * @return string 日期列表<li>1</li>....
  */
   function showDays($signDays,$year='',$month=''){
    $time = time();
    $year = $year ? $year : date('Y',$time);
    $month = $month ? $month : date('m',$time);
    $daysTotal = date('t', mktime(0, 0, 0, $month, 1, $year));
    $now = date('Y-m-d',$time);
    $str = '';
   // $i=0;
    for ($j = 1; $j <= $daysTotal; $j++) {
     // $i++;
      $someDay = date('Y-m-d',strtotime("$year-$month-$j"));
      // 小于今天的日期样式
      if ($someDay <= $now){
        // 当天日期样式 tdc = todayColor
        if($someDay == $now){
          // 当天签到过的
          if(in_array($j,$signDays)){
            $str .= '<li class="current fw tdc">'.$j.'</li>';
          }else{
            $str .= '<li class="today fw tdc">'.$j.'</li>';
          }
        }else{
          // 签到过的日期样式 current bfc = beforeColor , fw = font-weight
          if(in_array($j,$signDays)){
            $str .= '<li class="current fw bfc">'.$j.'</li>';
          }else{
            $str .= '<li class="fw bfc">'.$j.'</li>';
          }
        }
      }else{
        $str .= '<li>'.$j.'</li>';
      }
    }
    return $str;
  }
  /**
  * 获取当月签到的天数，与 $this->showDays() 配合使用
  * @return 当月签到日期 array(1,2,3,4,5,12,13)
  */
   function getMonthSign(){
    $time  = time();
    $year  = date('Y',$time);
    $month = date('m',$time);
    $day  = date("t",strtotime("$year-$month"));
    $start_stime  = strtotime("$year-$month-1 0:0:0")-1;
    $end_stime = strtotime("$year-$month-$day 23:59:59")+1;
    $list = Db::name('user_sign')->where("uid = {$this->uid} and stime > $start_stime and stime < $end_stime")->order('stime asc')->column('stime');
   //if(is_array($list)){
    foreach ($list as $key => $value){
      $list[$key] = date('j',$value);
    }
   //}
    //return $list;
    return json_encode($list);
  }

}
