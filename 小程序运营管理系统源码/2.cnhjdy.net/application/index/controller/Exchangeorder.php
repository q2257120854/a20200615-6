<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Exchangeorder extends Base
{
	public function index()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_6002=input('appletid');
				$var_6003=Db::table('applet')->where('id',$var_6002)->find();
				if(!$var_6003)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_6003);
				if($_POST)
				{
					$var_6004=Db::table('ims_sudu8_page_score_order')->alias('a')->join('ims_sudu8_page_user b','a.openid = b.openid')->where('b.uniacid',$var_6002)->where('a.order_id',$_POST['order_id'])->order('a.id desc')->field('a.*,b.realname,b.mobile')->paginate(10,false,['query' =>array('appletid'=>input('appletid'))]);
					$var_6005=input('order_id');
				}
				else
				{
					$var_6004=Db::table('ims_sudu8_page_score_order')->alias('a')->join('ims_sudu8_page_user b','a.openid = b.openid')->where('b.uniacid',$var_6002)->order('a.id desc')->field('a.*,b.realname,b.mobile')->paginate(10,false,['query' =>array('appletid'=>input('appletid'))]);
					$var_6005='';
				}
				$var_6006=count($var_6004);
				$var_6007=$var_6004->all();
				$this->assign('order_id',$var_6005);
				$this->assign('counts',$var_6006);
				$this->assign('listV',$var_6007);
				$this->assign('page',$var_6004->render());
			}
			else
			{
				$var_6008=Session::get('usergroup');
				if($var_6008==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_6008==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_6008==3)
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
	public function hx()
	{
		$var_6009['custime']=time();
		$var_6009['flag']=1;
		$var_6010=input('order_id');
		$var_409=Db::table('ims_sudu8_page_score_order')->where('order_id',$var_6010)->update($var_6009);
		if($var_409)
		{
			$this->success('兑换成功');
		}
		else
		{
			$this->success('兑换失败');
		}
	}
	public function del()
	{
		$var_6012['id']=input('cateid');
		$var_647=Db::table('ims_sudu8_page_score_shop')->where($var_6012)->delete();
		if($var_647)
		{
			$this->success('删除成功');
		}
		else
		{
			$this->success('删除失败');
		}
	}
	public function orderdown()
	{
		$var_6014=input('appletid');
		$var_6015=Db::table('applet')->where('id',$var_6014)->find();
		if(!$var_6015)
		{
			$this->error('找不到对应的小程序！');
		}
		$this->assign('applet',$var_6015);
		$var_6016=Db::table('ims_sudu8_page_score_order')->alias('a')->join('ims_sudu8_page_user b','a.openid = b.openid')->join('ims_sudu8_page_score_shop c','a.pid = c.id')->join('ims_sudu8_page_score_cate d','c.cid = d.id')->where('b.uniacid',$var_6014)->order('a.id desc')->field('a.*,b.realname,b.mobile,d.name')->select();
		require_once ROOT_PATH.'public/plugin/PHPExcel/PHPExcel.php';
		$var_6017=new \PHPExcel();
		$var_6017->getProperties()->setCreator('导出订单列表')->setLastModifiedBy('订单列表')->setTitle('导出订单列表')->setSubject('导出订单列表')->setDescription('导出订单列表')->setKeywords('导出订单列表')->setCategory('导出订单列表');
		$var_6017->getActiveSheet()->setCellValue('A1','订单号');
		$var_6017->getActiveSheet()->setCellValue('B1','产品图片');
		$var_6017->getActiveSheet()->setCellValue('C1','产品名称');
		$var_6017->getActiveSheet()->setCellValue('D1','产品分类');
		$var_6017->getActiveSheet()->setCellValue('E1','单价/数量');
		$var_6017->getActiveSheet()->setCellValue('F1','订单总价');
		$var_6017->getActiveSheet()->setCellValue('G1','姓名');
		$var_6017->getActiveSheet()->setCellValue('H1','联系方式');
		$var_6017->getActiveSheet()->setCellValue('I1','核销时间');
		$var_6017->getActiveSheet()->setCellValue('J1','状态');
		$var_6017->getActiveSheet()->setCellValue('K1','下单时间');
		$var_6017->getActiveSheet()->setCellValue('L1','小程序uniacid');
		foreach($var_6016 as $var_545=>$var_297)
		{
			$var_6018=$var_545+2;
			$var_297['creattime']=date('Y-m-d H:i:s',$var_297['creattime']);
			$var_297['custime']=$var_297['custime']==0?'未核销':date('Y-m-d H:i:s',$var_297['custime']);
			$var_6017->getActiveSheet()->setCellValueExplicit('A'.$var_6018,$var_297['order_id'],'s');
			$var_6017->getActiveSheet()->setCellValue('B'.$var_6018,$var_297['thumb']);
			$var_6017->getActiveSheet()->setCellValue('C'.$var_6018,$var_297['product']);
			$var_6017->getActiveSheet()->setCellValue('D'.$var_6018,$var_297['name']);
			$var_6017->getActiveSheet()->setCellValue('E'.$var_6018,$var_297['price'].'*'.$var_297['num']);
			$var_6017->getActiveSheet()->setCellValue('F'.$var_6018,$var_297['price']*$var_297['num']);
			$var_6017->getActiveSheet()->setCellValue('G'.$var_6018,$var_297['realname']);
			$var_6017->getActiveSheet()->setCellValue('H'.$var_6018,$var_297['mobile']);
			$var_6017->getActiveSheet()->setCellValue('I'.$var_6018,$var_297['custime']);
			if($var_297['flag']==0)
			{
				$var_6019='立即兑换';
			}
			if($var_297['flag']==1|| $var_297['flag']==2)
			{
				$var_6019='已兑换';
			}
			$var_6017->getActiveSheet()->setCellValue('J'.$var_6018,$var_6019);
			$var_6017->getActiveSheet()->setCellValue('K'.$var_6018,$var_297['creattime']);
			$var_6017->getActiveSheet()->setCellValue('L'.$var_6018,$var_297['uniacid']);
		}
		$var_6017->getActiveSheet()->setTitle('导出订单列表');
		$var_6017->setActiveSheetIndex(0);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="积分兑换订单列表.xls"');
		header('Cache-Control: max-age=0');
		$var_6020=\PHPExcel_IOFactory::createWriter($var_6017,'Excel5');
		$var_6020->save('php://output');
	}
}
?>