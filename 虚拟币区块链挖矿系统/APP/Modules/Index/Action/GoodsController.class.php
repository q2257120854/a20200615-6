<?php
namespace Home\Controller;
use Think\Controller;
class GoodsController extends Controller{
	public function index(){
		$items = M('goods');
		$itemsdata = $items->find($_GET['gid']);
		// 读取构面包线导航
		$c = D('ClassView');
		$line = $c->allParent($itemsdata['gclassification']);
		// 分配网页标题到前台
		$this->assign('title',$itemName['gname']);
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
		$this->assign('branddata',$branddata);
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
		//网站配置的公共函数
		$web = D("WebConfig");
        	$webdata = $web -> web();
        	$this -> assign("web",$webdata);
		$this->display('item');
	}
	/**
	*添加商品之购物车
	*/
	public function showCart(){
		// 获取session登陆的用户id
		$uid = session('uid');
		if (empty($uid)) {
			$id = $_POST['gid'];
			if (!$_SESSION['cart'][$id]) {
				$_SESSION['cart'][$id] = $_POST;
				echo 1;
				return;
			} else {
				$_SESSION['cart'][$id]['nums']+=$_POST['nums'];
				echo 1;
				return;
			}
		} else {
			// 实例化用户表的对象
			$cart = M('shoppingcart');
			// 查询登陆用户的信息对商品是否保存了
			$cdata = $cart->where(array('uid'=>$uid,'gid'=>$_POST['gid']))->find();
			if ($cdata) {
				if($cart->where(array('uid'=>$uid,'gid'=>$_POST['gid']))->save(array('nums'=>$cdata['nums']+$_POST['nums']))){
					echo 1;
					return;
				}
			} else {
				// 构造一个数据用来保存数据
				$map['uid'] = $uid;
				$map['gid'] = $_POST['gid'];
				$map['price'] = $_POST['price'];
				$map['nums'] = $_POST['nums'];
				// 实例化购物车表
				$showcart = M('shoppingcart');
				if ($showcart->data($map)->add()) {
					echo 1;
					return;
				}
			}	
		}
		echo 0;
	}
	/**
	*商品收藏
	*/
	public function goodsCollection(){
		$uid = session('uid');
		// 实例化要操作的收藏夹表
		$collectlist = M('goodscollection');
		if ($uid) {
			$_GET['uid']=$uid;
			if ($collectlist->where($_GET)->find()) {
				$this->error('该商品已经收藏……');	
			} else {
				if ($collectlist->add($_GET)) {
					$this->error('收藏成功！');	
				} else {
					$this->error('收藏失败！');	
				}
			}
		} else {
			$this->error(' 请先登录！');
		}
	}
}