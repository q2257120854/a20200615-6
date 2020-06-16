<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Cyorder extends Base
{
	public function index()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_5786=input('appletid');
				$var_5787=Db::table('applet')->where('id',$var_5786)->find();
				if(!$var_5787)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_5787);
				if($_POST)
				{
					$var_5788=Db::table('ims_sudu8_page_food_order')->where('uniacid',$var_5786)->where('order_id',$_POST['order_id'])->order('id desc')->paginate(10);
					$var_5789=$_POST['order_id'];
				}
				else
				{
					$var_5788=Db::table('ims_sudu8_page_food_order')->where('uniacid',$var_5786)->order('id desc')->paginate(10);
					$var_5789='';
				}
				$var_1212=count($var_5788);
				$var_5790=$var_5788->all();
				foreach($var_5790 as $var_5791=>$var_5792)
				{
					$var_5790[$var_5791]['val']=unserialize($var_5790[$var_5791]['val']);
					foreach($var_5790[$var_5791]['val'] as $var_5793=>$var_5794)
					{
						$var_5790[$var_5791]['val'][$var_5793]['thumb']=Db::table('ims_sudu8_page_food')->where('id',$var_5794['id'])->find()['thumb'];
						$var_5790[$var_5791]['val'][$var_5793]['thumb']=remote($var_5786,$var_5790[$var_5791]['val'][$var_5793]['thumb'],1);
					}
				}
				$this->assign('order_id',$var_5789);
				$this->assign('counts',$var_1212);
				$this->assign('cates',$var_5790);
				$this->assign('page',$var_5788->render());
			}
			else
			{
				$var_733=Session::get('usergroup');
				if($var_733==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_733==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_733==3)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
			}
			return $this->fetch(index);
		}
		else
		{
			$this->redirect('Login/index');
		}
	}
	public function orderdown()
	{
		$var_5796=input('appletid');
		$var_5797=Db::table('applet')->where('id',$var_5796)->find();
		if(!$var_5797)
		{
			$this->error('找不到对应的小程序！');
		}
		$this->assign('applet',$var_5797);
		$var_14=Db::table('ims_sudu8_page_food_order')->where('uniacid',$var_5796)->order('id desc')->select();
		require_once ROOT_PATH.'public/plugin/PHPExcel/PHPExcel.php';
		$var_5798=new \PHPExcel();
		$var_5798->getProperties()->setCreator('导出订单列表')->setLastModifiedBy('订单列表')->setTitle('导出订单列表')->setSubject('导出订单列表')->setDescription('导出订单列表')->setKeywords('导出订单列表')->setCategory('导出订单列表');
		$var_5798->getActiveSheet()->setCellValue('A1','订单号');
		$var_5798->getActiveSheet()->setCellValue('B1','桌号');
		$var_5798->getActiveSheet()->setCellValue('C1','商品名称');
		$var_5798->getActiveSheet()->setCellValue('D1','商品分类');
		$var_5798->getActiveSheet()->setCellValue('E1','单价/数量');
		$var_5798->getActiveSheet()->setCellValue('F1','订单总价');
		$var_5798->getActiveSheet()->setCellValue('G1','姓名');
		$var_5798->getActiveSheet()->setCellValue('H1','联系方式');
		$var_5798->getActiveSheet()->setCellValue('I1','地址');
		$var_5798->getActiveSheet()->setCellValue('J1','状态');
		$var_5798->getActiveSheet()->setCellValue('K1','下单时间');
		$var_5798->getActiveSheet()->setCellValue('L1','小程序uniacid');
		foreach($var_14 as $var_5799=>$var_5800)
		{
			$var_5801=$var_5799+2;
			$var_5800['val']=unserialize($var_5800['val']);
			$v_2='';
			$var_5802='';
			$var_5803='';
			foreach($var_5800['val'] as $var_5804=>$var_5805)
			{
				$v_2.= $var_5805['title'].',';
				$var_5802.= $var_5805['price'].'*'.$var_5805['num'].',';
				$var_5806=Db::table('ims_sudu8_page_food')->alias('a')->join('ims_sudu8_page_food_cate b','a.cid = b.id')->where('a.id',$var_5805['id'])->field('b.title as name')->find();
				$var_5803.= $var_5806['name'].',';
			}
			$var_5800['creattime']=date('Y-m-d H:i:s',$var_5800['creattime']);
			$var_5798->getActiveSheet()->setCellValueExplicit('A'.$var_5801,$var_5800['order_id'],'s');
			$var_5798->getActiveSheet()->setCellValue('B'.$var_5801,$var_5800['zh']);
			$var_5798->getActiveSheet()->setCellValue('C'.$var_5801,$v_2);
			$var_5798->getActiveSheet()->setCellValue('D'.$var_5801,$var_5803);
			$var_5798->getActiveSheet()->setCellValue('E'.$var_5801,$var_5802);
			$var_5798->getActiveSheet()->setCellValue('F'.$var_5801,$var_5800['price']);
			$var_5798->getActiveSheet()->setCellValue('G'.$var_5801,$var_5800['username']);
			$var_5798->getActiveSheet()->setCellValue('H'.$var_5801,$var_5800['usertel']);
			$var_5798->getActiveSheet()->setCellValue('I'.$var_5801,$var_5800['address']);
			if($var_5800['flag']==0)
			{
				$var_5807='未支付';
			}
			if($var_5800['flag']==1)
			{
				$var_5807='已支付';
			}
			if($var_5800['flag']==2)
			{
				$var_5807='已完成';
			}
			if($var_5800['flag']==-1)
			{
				$var_5807='已关闭';
			}
			if($var_5800['flag']==-2)
			{
				$var_5807='订单无效';
			}
			$var_5798->getActiveSheet()->setCellValue('J'.$var_5801,$var_5807);
			$var_5798->getActiveSheet()->setCellValue('K'.$var_5801,$var_5800['creattime']);
			$var_5798->getActiveSheet()->setCellValue('L'.$var_5801,$var_5800['uniacid']);
		}
		$var_5798->getActiveSheet()->setTitle('导出订单列表');
		$var_5798->setActiveSheetIndex(0);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="餐饮订单列表.xls"');
		header('Cache-Control: max-age=0');
		$var_113=\PHPExcel_IOFactory::createWriter($var_5798,'Excel5');
		$var_113->save('php://output');
	}
}
?>