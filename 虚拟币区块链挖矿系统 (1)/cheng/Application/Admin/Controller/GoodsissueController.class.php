<?php
namespace Admin\Controller;
use Think\Controller;
class GoodsIssueController extends Controller{
	public function index(){
		$classifydata = M('classify');
		$goods = M('goods');
		$member = M('member');
		$shop_group = M('shop_group');
		
		$classdata = $classifydata->field('cid,cname')->where('parentid=0')->order('cid desc')->select();
		$jibie = $member->where(array('username'=>$_SESSION['uname']))->getfield('shoplevel');
		$xianzhi = $shop_group->where(array('level'=>$jibie))->getfield('goosnum');
		
		$fabu = $goods->where(array('username'=>$_SESSION['uname']))->count();
		if($fabu >= $xianzhi){
			$this->error('您最多可以发布'. $xianzhi .'件商品',U('admin/Goodsdown/index'));
		}
		
		$this->assign('classdata',$classdata);
		$this->assign('title','商品发布');
		$this->display();
	}
	/**
	*商品发布处理
	*/
	public function insertGd(){
		// 构造属性判断数组
		$attrarraylist = M('attribute');
		$attrarray_data = $attrarraylist->field('attrid')->select();
		foreach ($attrarray_data as $value) {
			$attrarray[] = $value['attrid'];
		}
		// 最终要存入数据库的数据
		$_POST['gattribute'] = '';
		// 将属性遍历拼接成字符串
		foreach ($_POST as $key => $value) {
			if (in_array($key, $attrarray)) {
				$_POST['gattribute'] .= $_POST[$key].',';
				unset($_POST[$key]);
			}
		}
		// 去除多余的右侧逗号
		$_POST['gattribute'] = rtrim($_POST['gattribute'],",");
		// 判断选择了多少张图片上传
		$upgpicnums = 0;
		// 判断有多少张图片超出了大小
		$biggpicnums = 0;
		foreach ($_FILES['gpic']['size'] as $value){
			if ($value > 0) {
				$upgpicnums++;
			}
			if ($value >= 3145728) {
				$biggpicnums++;
			}
		}
		// 当上传的图片大小符合才允许上传
		if (!$biggpicnums) {
			/*使用upload类实现多文件上传，下面设置一些成员属性值。*/
			$upload = new \Think\Upload();
			// 设置上传大小
			$upload->maxSize = 3145728;
			// 设置上传文件类型
			$upload->exts = array('jpg', 'gif', 'png', 'jpeg');
			// 设置上传文件路径
			$upload->rootPath = './Public/Goodsuploads/';
			// 这里使用了自定义函数setsavename，作为命名规则防止同时间内上传多张照片出现重复情况
			$upload->saveName = 'setsavename';
			// 将上传文件的信息已数组的形式保存至$info变量中
			$info = $upload->upload();
			// 实例化image类可以将上传后的图片生成缩略图
			$image = new \Think\Image();
			// 如果变量中存在信息证明上传成功，执行缩略图操作
			if ($info) {
				// 定义newgpic变量，用来将上传的多张图片的文件名，拼接成一个字符串，保存至数据库的
				$newgpic = '';
				// 用来控制拼接的','的数量
				$commanums = 0;
				// 循环便利上传图片的信息，将每一张上传的图片一次缩略图
				foreach ($info as $value) {
					$commanums++;
					$newgpic .= $value['savepath'].$value['savename'];
					if ($commanums < $upgpicnums) {
						$newgpic .= ',';
					}
					// 获取上传图片的路径（包括文件名）
					$gpic = $upload->rootPath.$value['savepath'].$value['savename'];
					// 保存要生成缩略图的路径信息，要生成（30,60,80,120,300,600）6个类别的图片。
					$thgpic_30 = $upload->rootPath.$value['savepath'].'30_'.$value['savename'];
					$thgpic_60 = $upload->rootPath.$value['savepath'].'60_'.$value['savename'];
					$thgpic_80 = $upload->rootPath.$value['savepath'].'80_'.$value['savename'];
					$thgpic_120 = $upload->rootPath.$value['savepath'].'120_'.$value['savename'];
					$thgpic_300 = $upload->rootPath.$value['savepath'].'300_'.$value['savename'];
					/*生成缩略图：
					第一步打开图片*/
					$image -> open($gpic);
					// 第二三步，连贯操作生成并保存缩略图
					$image -> thumb(600,600) -> save($gpic);
					$image -> thumb(300,300) -> save($thgpic_300);
					$image -> thumb(120,120) -> save($thgpic_120);
					$image -> thumb(80,80) -> save($thgpic_80);
					$image -> thumb(60,60) -> save($thgpic_60);
					$image -> thumb(30,30) -> save($thgpic_30);
				}
				/*下面自定义构造一些post成员，用于保存非用户交互的内容*/
				// 自定义一个post的成员，用来保存商品图片
				$_POST['gpic'] = $newgpic;
				// 自定义一个post的成员，用来保存商品编号
				$_POST['gnum'] = time();
				// 自定义一个post的成员，用来保存商品发布日期
				$_POST['gissuetime'] = time();
				$_POST['username'] = $_SESSION['uname'];
				
				// 判断是否选择了上架，如果选择了上架，就构造出来上架时间
				if ($_POST['issale'] == 1) {
					$_POST['guptime'] = time();
				}
				// 数据库操作，添加数据
				$goods = M('goods');

				//将修改的数据保存到数据库
				if($goods->data($_POST)->add()){
					$this->success('商品发布成功','index');
				}else{
					$this -> error('商品发布失败！');
				}
			}else{
				$this->error($upload->getError());
			}
		}else{
			$this->error("上传图片，有".$biggpicnums."张，大小不符合要求！");
		}
	}
	/**
	*商品属性控制
	*ajax根据类别的选择读取相应的属性发到前台
	*/
	public function goodsAttr(){
		$cid = $_POST['cid'];
		// $cid = 45;
		$classify = M('classify');
		$classcpath = $classify->field('cpath')->where(array('cid'=>$cid))->find();
		$cpatharr = explode('-', $classcpath['cpath'].'-'.$cid);
		$attribute = M('attribute');
		$goodstoattr = M('goodstoattr');
		// 存放选择出来的属性数组，变成json格式传递到前台
		$factattr = [];		
		foreach ($cpatharr as $v1){
			$attrdata = $attribute->field('attrid,attrname')->where(array('cid'=>$v1))->select();
			if ($attrdata) {
				foreach ($attrdata as $v2) {
					$goodstoattrdata = $goodstoattr->field('id,attrvalue')->where(array('attrid'=>$v2['attrid']))->select();	
					if ($goodstoattrdata) {
						foreach ($goodstoattrdata as $v3) {
							$factattr[$v2['attrid'].','.$v2['attrname']][] = $v3['id'].','.$v3['attrvalue'];
						}
					}
				}
			}
		}
		if ($factattr) {
			echo json_encode($factattr);
			return;
		}
		echo 0;
	}
	/**
	*商品品牌
	*ajax根据类别的选择读取相应的属性发到前台
	*/
	public function goodsBrand(){
		// 实例化品牌表和品牌分类关联表
		$bclist = M('brandtoclass');
		$blist = M('brand');
		$bcdata = $bclist->field('bid')->where($_POST)->select();
		foreach ($bcdata as $value) {
			$bdata = $blist->field('bid,bname')->where($value)->find();
			if ($bdata) {
				$brand_data[] = $bdata['bid'].','.$bdata['bname'];
			}
		}
		if ($brand_data) {
			echo json_encode($brand_data);
			return;
		}
		echo 0;
	}
}