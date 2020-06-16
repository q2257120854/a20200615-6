<?php
namespace Admin\Controller;
use Think\Controller;
class GoodsDownController extends Controller{
	/**
	*分页显示上架商品
	*/
	public function index(){
		// 数据库操作，查询上架商品，实例化goods对象
		$goodsup = M('goods');
		// 连贯操作查询数据条数，利用find()遍历出来的是一维数组。select遍历的二维数组。
		$datatotal = $goodsup->field('count(*) count')->where(array('issale'=>0,'username'=>$_SESSION['uname']))->find();
		// 计算满足条件的数据总数
		$totalnums = $datatotal['count'];
		// 实例化分页类
		$pages = new \Think\Page($totalnums,10);
		// 获取分页的条件
		$limit = $pages->firstRow.','.$pages->listRows;
		// 连贯操作查询数据
		$goodupdata = $goodsup->field('gid,gpic,gname,goldprice,goodnums,gsellnums,gissuetime')->where(array('issale'=>0,'username'=>$_SESSION['uname']))->order('gissuetime desc')->limit($limit)->select();
		/*遍历出来数据是二维数组，将遍历到的gpic多个地址，截取出来一个
		数据库中存放的gpic（$goodupdata['gpic']）字段是，多个图片地址用逗号链接的结果，这里用expode函数拆分字符串，取第一个展示到列表位置
		重新给$goodupdata['gpic']赋值为第一张图片的地址*/
		foreach ($goodupdata  as $key => $value) {
			$gpicarray = explode(',', $value['gpic']);
			$goodupdata[$key]['gpic'] = $gpicarray[0];
		}
		// 将遍历出来的$goodupdata，重新构造后，赋值给前台模板
		$this->assign('title','仓库商品');
		$this->assign('goodupdata',$goodupdata);
		$this->assign('page',$pages->show());
		$this->display();
	}
	/**
	*删除商品
	*/
	public function delGoods(){
		// 获取要操作的id，即商品的gid
		$gid = $_GET['gid'];
		// 实例化goods对象，要准备进行删除操作
		$del = M('goods');
		// 当get传参中存在gid的值的时候执行下面的查询语句
		if ($_GET['gid']) {
			// 查找满足条件的gpic字段
			$map['gid'] = $_GET['gid'];
			$map['username'] = $_SESSION['uname'];
			$gpic = $del->field('gpic')->where($map)->find();
			// 将查询出来的gpic字段，用explode以逗号分隔成数组
			$gpic = explode(',', $gpic['gpic']);
		}
		// 删除满足条件的数据，即gid=$gid的数值，结果返回return
		$return = $del->where($map)->delete();
		// 该删除操作是ajax请求，通过echo值为1或0控制，这里问号表达式控制输出为1还是0
		echo $return?1:0;
		// 如果条件成立则将相应的商品图片一并清除
		if ($return) {
			$rootpath = './Public/Goodsuploads/';
			// 定义组合图片路径使用的分隔符
			$separativesign = ['/','/300_','/120_','/80_','/60_','/30_'];
			// 遍历每一组图片的指引性路径
			foreach ($gpic as $value) {
				// 删除600，300,1120……等图片，根据规则拼接指引性路径，找到它干掉他
				foreach ($separativesign as $sign) {
					unlink($rootpath.implode($sign, explode('/', $value)));
				}
			}
		}
	}
	/**
	*修改页面
	*/
	public function modGoods(){
		// 获取要修改内容的id
		$gid = $_GET['gid'];
		// 实例化goods对象，要准备进行修改操作
		$mod = M('goods');
		// 查询出要修改数据的字段
		$goodsdata = $mod->field('gid,gclassification,gname,gattribute,goldprice,goodnums,gpic,gintroduce,gspecifications,issale')->where(array('gid'=>$gid,'username'=>$_SESSION['uname']))->find();
		if(empty($goodsdata)){
			$this -> error('非法操作');
		}else{
		$classdata = M('classify');
		$classname = $classdata->field('cname')->where("cid={$goodsdata['gclassification']}")->find();
		$goodsdata['gclassification'] = $classname['cname'];
		// 拆分图片成数组
		$goodsdata['gpic'] = explode(',', $goodsdata['gpic']);
		// 分配数据至前台
		$this->assign('goodsdata',$goodsdata);
		// 显示修改的页面
		$this->assign('title','仓库商品修改');
		$this->display();
		}
	}
	/**
	*修改数据
	*/
	public function updateGoods(){
		// 获取要修改内容的id
		$gid = $_POST['gid'];
		// 实例化goods对象，要准备进行修改操作
		$goods = M('goods');
		// 查出，gpic图片路径字段以便要进行更新操作
		$gpic = $goods->field('gpic')->find($gid);
		// 拆分所有连起来的图片路径为一个数组，单独为一个数值
		$gpic = explode(',', $gpic['gpic']);
		// 判断修改了那几个位置的图片
		$upgpickeys = [];
		// 定义下标初始为0，临时下标也为0
		$key = 0;
		// 判断有多少张图片超出了大小
		$biggpicnums = 0;
		// 通过以下判断可以判断，修改了哪几个位置的图片
		foreach ($_FILES['gpic']['size'] as $value){
			// 值大于0证明该位置上传了图片，则进行记录
			if ($value > 0) {
				// 将上传位置的下标，保存至数组保存
				$upgpickeys[] = $key;
			}
			// 如果上传图片大小超过上传范围则记录，方便下面提示失败
			if ($value >= 3145728) {
				$biggpicnums++;
			}
			// 上传位置下标加1继续判断
			$key++;
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
				// 循环便利上传图片的信息，将每一张上传的图片一次缩略图
				foreach ($info as $value) {
					// 定义newgpic数组，用来将修改上传的多张图片的文件名，保存起来,数据保存，值数组
					$newgpic[] = $value['savepath'].$value['savename'];
					// 获取上传图片的路径（包括文件名）
					$gpic_600 = $upload->rootPath.$value['savepath'].$value['savename'];
					// 保存要生成缩略图的路径信息，要生成（30,60,80,120,300,600）6个类别的图片。
					$thgpic_30 = $upload->rootPath.$value['savepath'].'30_'.$value['savename'];
					$thgpic_60 = $upload->rootPath.$value['savepath'].'60_'.$value['savename'];
					$thgpic_80 = $upload->rootPath.$value['savepath'].'80_'.$value['savename'];
					$thgpic_120 = $upload->rootPath.$value['savepath'].'120_'.$value['savename'];
					$thgpic_300 = $upload->rootPath.$value['savepath'].'300_'.$value['savename'];
					/*生成缩略图：
					第一步打开图片*/
					$image -> open($gpic_600);
					// 第二三步，连贯操作生成并保存缩略图
					$image -> thumb(600,600) -> save($gpic_600);
					$image -> thumb(300,300) -> save($thgpic_300);
					$image -> thumb(120,120) -> save($thgpic_120);
					$image -> thumb(80,80) -> save($thgpic_80);
					$image -> thumb(60,60) -> save($thgpic_60);
					$image -> thumb(30,30) -> save($thgpic_30);
				}

				// 将要删除的替换照片的数组保存至临时的删除的数组$delgpic
				foreach ($upgpickeys as $value) {
					$delgpic[] = $gpic[$value];
				}
				// 如果条件成立则将相应的商品图片一并清除
				$rootpath = './Public/Goodsuploads/';
				// 定义组合图片路径使用的分隔符
				$separativesign = ['/','/300_','/120_','/80_','/60_','/30_'];
				// 遍历每一组图片的指引性路径
				foreach ($delgpic as $value) {
					// 删除600，300,1120……等图片，根据规则拼接指引性路径，找到它干掉他
					foreach ($separativesign as $sign) {
						unlink($rootpath.implode($sign, explode('/', $value)));
					}
				}
				// 重新构造gpic数组，保存的是新的图片路径
				foreach ($upgpickeys as $key => $value) {
					$gpic[$value] = $newgpic[$key];
				}
			}
			/*下面自定义构造一些post成员，用于保存非用户交互的内容*/
			// 自定义一个post的成员，用来保存商品图片
			$_POST['gpic'] = implode(',', $gpic);
			// 判断是否选择了下架，如果选择了下架，就构造出来下架时间
			if ($_POST['issale'] == 0) {
				$_POST['gdowntime'] = time();
			}
			// 数据库操作，更新数据库
			$goods = M('goods');
			//将修改的数据保存到数据库
			if($goods->save($_POST)){
				$this->success('商品修改成功','index');
			}else{
				$this -> error('商品修改失败！');
			}
		}else{
			$this->error("修改图片，有".$biggpicnums."张，大小不符合要求！");
		}
	}
	/**
	*商品上架
	*/
	public function upGoods(){
		// 自定义给get天加issale值，即下架。此时get中有gid，issale两个数据，方法自动用gid作为条件
		$_GET['issale'] = 1;
		// 实例化goods对象，要准备进行下架修改操作
		$up = M('goods');
		// 修改满足条件的数据，即gid=$gid，issale=0的数值，结果返回return，save方法会自动将主键作为条件
		$return = $up->save($_GET);
		// 该删除操作是ajax请求，通过echo值为1或0控制，这里问号表达式控制输出为1还是0
		echo $return?1:0;
	}
	/**
	*商品搜索
	*/
	public function search(){
		$map['issale'] = 0;
		$map['gname'] = array('like','%'.$_GET['uname'].'%');
		// 数据库操作，查询上架商品，实例化goods对象
		$goodssearch = M('goods');
		// 连贯操作查询数据条数，利用find()遍历出来的是一维数组。select遍历的二维数组。
		$datatotal = $goodssearch->field('count(*) count')->where($map)->find();
		// 计算满足条件的数据总数
		$totalnums = $datatotal['count'];
		// 实例化分页类
		$pages = new \Think\Page($totalnums,10);
		// 获取分页的条件
		$limit = $pages->firstRow.','.$pages->listRows;
		// 连贯操作查询数据
		$goodupdata = $goodssearch->field('gid,gpic,gname,goldprice,goodnums,gsellnums,gissuetime')->where($map)->limit($limit)->select();
		/*遍历出来数据是二维数组，将遍历到的gpic多个地址，截取出来一个
		数据库中存放的gpic（$goodupdata['gpic']）字段是，多个图片地址用逗号链接的结果，这里用expode函数拆分字符串，取第一个展示到列表位置
		重新给$goodupdata['gpic']赋值为第一张图片的地址*/
		foreach ($goodupdata  as $key => $value) {
			$gpicarray = explode(',', $value['gpic']);
			$goodupdata[$key]['gpic'] = $gpicarray[0];
		}
		// 将遍历出来的$goodupdata，重新构造后，赋值给前台模板
		$this->assign('searchval',$_GET['uname']);
		$this->assign('goodupdata',$goodupdata);
		$this->assign('page',$pages->show());
		$this->display('index');
	}	
}