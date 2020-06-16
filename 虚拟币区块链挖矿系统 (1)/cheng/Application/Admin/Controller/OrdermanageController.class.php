<?php
namespace Admin\Controller;
use Think\Controller;
class OrdermanageController extends Controller{
	/**
	*
	*显示所有订单
	*/
	public function index(){
		// 实例化所要操纵做的数据表
		// 订单表,用于分页操作
		$orderslist = M("orders");
		// 遍历出来的是一维数组。select遍历的二维数组。
		$datatotal = $orderslist->field('count(*) count')->where(array('username' => $_SESSION['uname']))->find();
		// 计算满足条件的数据总数
		$totalnums = $datatotal['count'];
		// 实例化分页类
		$pages = new \Think\Page($totalnums,5);
		// 获取分页的条件
		$limit = $pages->firstRow.','.$pages->listRows;
		// 空model类
		$list = M();
		// 订单详情表
		$detailslist = M("ordersdetails");
		// 全部订单
		// 查询订单用户信息
		$orders_data = $orderslist ->where(array('username' => $_SESSION['uname']))->limit($limit)->select();
		
		// 分配订单信息知道前台
		$this->assign('page',$pages->show());
		$this->assign('orders_data',$orders_data);
		$this->assign('active',1);
		$this->display();
	}
	/**
	*
	*显示未发货订单
	*/
	public function nonDelivery(){
		// 实例化所要操纵做的数据表
		// 订单表,用于分页操作
		$orderslist = M("orders");
		// 遍历出来的是一维数组。select遍历的二维数组。
		$datatotal = $orderslist->field('count(*) count')->where(array('username' => $_SESSION['uname'],'status' => 0))->find();
		// 计算满足条件的数据总数
		$totalnums = $datatotal['count'];
		// 实例化分页类
		$pages = new \Think\Page($totalnums,5);
		// 获取分页的条件
		$limit = $pages->firstRow.','.$pages->listRows;
		// 空model类
		$list = M();
		// 订单详情表
		$detailslist = M("ordersdetails");
		// 全部订单
		// 查询订单用户信息
		$orders_data = $orderslist ->where(array('username' => $_SESSION['uname'],'status' => 0))->limit($limit)->select();
		
		// 分配订单信息知道前台
		$this->assign('page',$pages->show());
		$this->assign('orders_data',$orders_data);
		$this->assign('active',2);
		$this->display("index");
	}
	// 已发货
	public function deliverGoods(){
		// 实例化所要操纵做的数据表
		// 订单表,用于分页操作
		$orderslist = M("orders");
		// 遍历出来的是一维数组。select遍历的二维数组。
		$datatotal = $orderslist->field('count(*) count')->where(array('username' => $_SESSION['uname'],'status' => 1))->find();
		// 计算满足条件的数据总数
		$totalnums = $datatotal['count'];
		// 实例化分页类
		$pages = new \Think\Page($totalnums,5);
		// 获取分页的条件
		$limit = $pages->firstRow.','.$pages->listRows;
		// 空model类
		$list = M();
		// 订单详情表
		$detailslist = M("ordersdetails");
		// 全部订单
		// 查询订单用户信息
		$orders_data = $orderslist ->where(array('username' => $_SESSION['uname'],'status' => 1))->limit($limit)->select();
		
		// 分配订单信息知道前台
		$this->assign('page',$pages->show());
		$this->assign('orders_data',$orders_data);
		$this->assign('active',3);
		$this->display("index");
	}

	// 交易完成
	public function completeDeal(){
		// 实例化所要操纵做的数据表
		// 订单表,用于分页操作
		$orderslist = M("orders");
		// 遍历出来的是一维数组。select遍历的二维数组。
		$datatotal = $orderslist->field('count(*) count')->where(array('username' => $_SESSION['uname'],'status' => 2))->find();
		// 计算满足条件的数据总数
		$totalnums = $datatotal['count'];
		// 实例化分页类
		$pages = new \Think\Page($totalnums,5);
		// 获取分页的条件
		$limit = $pages->firstRow.','.$pages->listRows;
		// 空model类
		$list = M();
		// 订单详情表
		$detailslist = M("ordersdetails");
		// 全部订单
		// 查询订单用户信息
		$orders_data = $orderslist ->where(array('username' => $_SESSION['uname'],'status' => 2))->limit($limit)->select();
		
		// 分配订单信息知道前台
		$this->assign('page',$pages->show());
		$this->assign('orders_data',$orders_data);
		$this->assign('active',5);
		$this->display("index");
	}

	// 订单修改，发货，重新发货
	public function orderState(){
		$onumber = I('get.onumber');
		$username = $_SESSION['uname'];
		$orderslist = M("orders");
		// 遍历出来的是一维数组。select遍历的二维数组。
		$datatotal = $orderslist->where(array('username' => $_SESSION['uname'],'onumber' => $onumber))->find();
		if(empty($datatotal)){
			$this->error('非法操作');
			die();
		}

		$this->assign('onumber',$onumber);
		$this->assign('datatotal',$datatotal);
		$this->display();
	}
	// 发货操作
	public function postorderState(){

		$onumber = I('post.onumber');
		$data['kuaidiname'] = I('post.kuaidiname');
		$data['expressnum'] = I('post.expressnum');
		if(empty($data['kuaidiname'])){
			$this->error('快递名称不能为空');
			die();
		}
		if(empty($data['expressnum'])){
			$this->error('快递单号不能为空');
			die();
		}
		$username = $_SESSION['uname'];
		$data['status'] = 1;
		$orderslist = M("orders");
		// 遍历出来的是一维数组。select遍历的二维数组。
		$orderslist->where(array('username' => $username,'onumber' => $onumber))->save($data);
        if($orderslist){
            $this -> success("发货成功","index");
        }else{
            $this -> error("发货失败");
        }
		
	}
	public function search(){
		// 实例化所要操纵做的数据表
		// 订单表,用于分页操作
		$orderslist = M("orders");
		$map['onumber'] = array('like','%'.$_GET['uname'].'%');
		// 遍历出来的是一维数组。select遍历的二维数组。
		$datatotal = $orderslist->field('count(*) count')->where($map)->find();
		// 计算满足条件的数据总数
		$totalnums = $datatotal['count'];
		// 实例化分页类
		$pages = new \Think\Page($totalnums,3);
		// 获取分页的条件
		$limit = $pages->firstRow.','.$pages->listRows;
		// 空model类
		$list = M();
		// 订单详情表
		$detailslist = M("ordersdetails");
		// 全部订单
		// 查询订单信息
		$orders_data = $list->table('sx_member m,sx_orders o')->field('o.oid,o.onumber,o.otime,o.total,m.uname,o.deliveryaddress')->where('o.uid=m.uid and and o.username='.$_SESSION['uname'].' (o.onumber like %'.$_GET['uname'].'%)')->limit($limit)->select();
		// 得打发往前台的中间数据，订单详情表
		foreach ($orders_data as $v) {
			$details_data[] = $list->table('sx_ordersdetails d,sx_goods g')->field('g.gpic,g.gname,d.gprice,d.gnums,d.ostate')->where('d.oid='.$v['oid'].' and d.gid=g.gid')->select();
		}
		// 构造gpic
		foreach ($details_data as $k => $vo) {
			foreach ($vo as $k1=> $vo1) {
				$details_data[$k][$k1]['gpic'] = explode(',', $vo1['gpic'])[0];
			}
		}
		// 分配订单信息知道前台
		$this->assign('page',$pages->show());
		$this->assign('orders',$orders_data);
		$this->assign('details',$details_data);
		$this->assign('active',1);
		$this->display('index');
	}
}



















