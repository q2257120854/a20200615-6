<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Making extends Controller
{
	public function making_do($v_1,$v_2)
	{
		$var_6222=Db::table('ims_sudu8_page_base')->where('uniacid',$v_1)->find();
		$var_6223=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->delete();
		$var_6224=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->delete();
		$var_198=Db::table('ims_sudu8_page_navlist')->where('uniacid',$v_1)->delete();
		$var_6225=Db::table('ims_sudu8_page_banner')->where('uniacid',$v_1)->delete();
		$var_6226=Db::table('image_url')->where('appletid',$v_1)->delete();
		if($v_2==0)
		{
			$var_6227=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPic')->where('cid',0)->order('id asc')->field('uniacid,id')->find();
			$var_6228=array('uniacid' =>$v_1,'num' =>9,'type' =>'showPic','statue' =>1,'cid' =>0,'name' =>'客照欣赏','ename' =>'Photo Cases','show_i' =>1,'list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>2,'list_stylet' =>'tcb','pic_page_btn'=>0,);
			if(empty($var_6227['uniacid']))
			{
				Db::table('ims_sudu8_page_cate')->insert($var_6228);
			}
			else
			{
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6227['id'])->update($var_6228);
			}
			$var_6228=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPic')->where('cid',0)->order('id asc')->field('uniacid,id')->find();
			$var_967=$var_6228['id'];
			$var_6229=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPic')->where('cid',$var_967)->order('id asc')->field('uniacid,id')->find();
			$var_6230=count($var_6229);
			if($var_6230==0)
			{
				$var_6231=array('uniacid' =>$v_1,'num' =>9,'type' =>'showPic','statue' =>1,'cid' =>$var_967,'name' =>'婚纱摄影','ename' =>'Wedding photography','show_i' =>1,'catepic'=>'http://2.cnhjdy.net/assetsj/hunsha/nav1.png','list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>2,'list_stylet' =>'tcb','pic_page_btn'=>0,);
				$var_425=array('uniacid' =>$v_1,'num' =>9,'type' =>'showPic','statue' =>1,'cid' =>$var_967,'name' =>'全球旅拍','ename' =>'Global tour','show_i' =>1,'catepic'=>'http://2.cnhjdy.net/assetsj/hunsha/nav2.png','list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>2,'list_stylet' =>'tcb','pic_page_btn'=>0,);
				$var_6232=array('uniacid' =>$v_1,'num' =>9,'type' =>'showPic','statue' =>1,'cid' =>$var_967,'name' =>'个人写真','ename' =>'Personal photo','show_i' =>1,'catepic'=>'http://2.cnhjdy.net/assetsj/hunsha/nav3.png','list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>2,'list_stylet' =>'tcb','pic_page_btn'=>0,);
				$var_103=array('uniacid' =>$v_1,'num' =>9,'type' =>'showPic','statue' =>1,'cid' =>$var_967,'name' =>'情侣闺蜜','ename' =>'Lovers & girlfriends','show_i' =>1,'catepic'=>'http://2.cnhjdy.net/assetsj/hunsha/nav4.png','list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>2,'list_stylet' =>'tcb','pic_page_btn'=>0,);
				Db::table('ims_sudu8_page_cate')->insert($var_6231);
				Db::table('ims_sudu8_page_cate')->insert($var_425);
				Db::table('ims_sudu8_page_cate')->insert($var_6232);
				Db::table('ims_sudu8_page_cate')->insert($var_103);
				$var_739=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPic')->where('cid','neq',0)->order('id asc')->field('uniacid,id')->select();
				$var_6233=$var_739[0]['id'];
				$var_6234=$var_739[1]['id'];
				$var_6235=$var_739[2]['id'];
				$var_6236=$var_739[3]['id'];
			}
			else
			{
				$var_739=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPic')->where('cid','neq',0)->order('id asc')->field('uniacid,id')->select();
				$var_6233=$var_739[0]['id'];
				$var_6234=$var_739[1]['id'];
				$var_6235=$var_739[2]['id'];
				$var_6236=$var_739[3]['id'];
			}
			$var_6237=Db::table('ims_sudu8_page_navlist')->where('uniacid',$v_1)->field('uniacid,id')->select();
			$var_6238=array('uniacid' =>$v_1,'num' =>99,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/hunsha/nav1.png','title' =>'婚纱摄影','url' =>'/sudu8_page/listPic/listPic?cid='.$var_6233,);
			$var_486=array('uniacid' =>$v_1,'num' =>98,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/hunsha/nav2.png','title' =>'全球旅拍','url' =>'/sudu8_page/listPic/listPic?cid='.$var_6234,);
			$var_6239=array('uniacid' =>$v_1,'num' =>97,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/hunsha/nav3.png','title' =>'个人写真','url' =>'/sudu8_page/listPic/listPic?cid='.$var_6235,);
			$var_6240=array('uniacid' =>$v_1,'num' =>96,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/hunsha/nav4.png','title' =>'情侣闺蜜','url' =>'/sudu8_page/listPic/listPic?cid='.$var_6236,);
			if(empty($var_6237))
			{
				Db::table('ims_sudu8_page_navlist')->insert($var_6238);
				Db::table('ims_sudu8_page_navlist')->insert($var_486);
				Db::table('ims_sudu8_page_navlist')->insert($var_6239);
				Db::table('ims_sudu8_page_navlist')->insert($var_6240);
			}
			else
			{
				$var_6237=Db::table('ims_sudu8_page_navlist')->where('uniacid',$v_1)->field('uniacid,id')->select();
				$var_375=$var_6237[0]['id'];
				$var_6241=$var_6237[1]['id'];
				$var_6242=$var_6237[2]['id'];
				$var_321=$var_6237[3]['id'];
				Db::table('ims_sudu8_page_navlist')->where('id',$var_375)->where('uniacid',$v_1)->update($var_6238);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_6241)->where('uniacid',$v_1)->update($var_486);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_6242)->where('uniacid',$v_1)->update($var_6239);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_321)->where('uniacid',$v_1)->update($var_6240);
			}
			$var_59=array('url'=> '','uniacid' =>$v_1,'statue'=>1,'name_s'=>1,'box_p_tb'=>3,'box_p_lr'=>1,'number'=>4,'img_size'=>60,'title_position'=>1,'title_color'=>'#222',);
			$var_6243=Db::table('ims_sudu8_page_nav')->where('uniacid',$v_1)->field('uniacid')->find();
			if(empty($var_6243['uniacid']))
			{
				Db::table('ims_sudu8_page_nav')->insert($var_59);
			}
			else
			{
				Db::table('ims_sudu8_page_nav')->where('uniacid',$v_1)->update($var_59);
			}
			$var_1203=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showArt')->where('cid',0)->order('id asc')->field('uniacid,id')->find();
			$var_6244=array('uniacid' =>$v_1,'num' =>8,'type' =>'showArt','statue' =>1,'cid' =>0,'name' =>'优惠活动','ename' =>'Activities','show_i' =>1,'list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>1,'list_stylet' =>'tlb',);
			if(empty($var_1203['uniacid']))
			{
				Db::table('ims_sudu8_page_cate')->insert($var_6244);
			}
			else
			{
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_1203['id'])->update($var_6244);
			}
			$var_6244=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showArt')->where('cid',0)->order('id asc')->field('uniacid,id')->find();
			$var_2345=$var_6244['id'];
			$var_6245=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->find();
			$var_6246=array('uniacid' =>$v_1,'num' =>5,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'服务展示','ename' =>'Service display','show_i' =>1,'list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'none',);
			if(empty($var_6245['uniacid']))
			{
				Db::table('ims_sudu8_page_cate')->insert($var_6246);
			}
			else
			{
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_1203['id'])->update($var_6246);
			}
			$var_6246=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->find();
			$var_6247=$var_6246['id'];
			$var_6248=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPic')->where('pcid',$var_967)->order('id asc')->field('uniacid,id')->select();
			$var_6249=count($var_6248);
			if($var_6249==0)
			{
				$var_6250=array('uniacid' =>$v_1,'cid'=> $var_6233,'pcid'=> $var_967,'type_x'=> 1,'type'=> 'showPic','type_i'=> 1,'title'=> '婚纱摄影欣赏','thumb'=> 'http://2.cnhjdy.net/assetsj/hunsha/case3.jpg','text'=> 'a:4:{i:0;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con1.jpg";i:1;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con2.jpg";i:2;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con3.jpg";i:3;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con4.jpg";}',);
				$var_6251=array('uniacid' =>$v_1,'cid'=>$var_6233,'pcid'=> $var_967,'type_x'=>1,'type'=> 'showPic','type_i'=>1,'title'=>'海南岛之旅','thumb'=>'http://2.cnhjdy.net/assetsj/hunsha/case4.jpg','text'=>'a:4:{i:0;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con1.jpg";i:1;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con2.jpg";i:2;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con3.jpg";i:3;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con4.jpg";}',);
				$var_6252=array('uniacid' =>$v_1,'cid'=>$var_6233,'pcid'=> $var_967,'type_x'=>1,'type'=> 'showPic','type_i'=>1,'title'=>'梦幻仙境','thumb'=>'http://2.cnhjdy.net/assetsj/hunsha/case8.jpg','text'=>'a:4:{i:0;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con1.jpg";i:1;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con2.jpg";i:2;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con3.jpg";i:3;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con4.jpg";}',);
				$var_6253=array('uniacid' =>$v_1,'cid'=>$var_6233,'pcid'=> $var_967,'type_x'=>1,'type'=> 'showPic','type_i'=>1,'title'=>'夕阳的艳丽','thumb'=>'http://2.cnhjdy.net/assetsj/hunsha/case7.jpg','text'=>'a:4:{i:0;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con1.jpg";i:1;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con2.jpg";i:2;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con3.jpg";i:3;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con4.jpg";}',);
				Db::table('ims_sudu8_page_products')->insert($var_6250);
				Db::table('ims_sudu8_page_products')->insert($var_6251);
				Db::table('ims_sudu8_page_products')->insert($var_6252);
				Db::table('ims_sudu8_page_products')->insert($var_6253);
			}
			$var_6254=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showArt')->where('pcid',$var_6227['id'])->order('id asc')->field('uniacid,id')->select();
			$var_6255=count($var_6254);
			if($var_6255==0)
			{
				$var_6256=array('uniacid' =>$v_1,'cid'=> $var_2345,'pcid'=> $var_2345,'type'=> 'showArt','type_i'=> 1,'title'=> '为爱再造一座城','thumb'=> 'http://2.cnhjdy.net/assetsj/hunsha/a1.jpg','text'=> '这里是文章内容',);
				$var_6257=array('uniacid' =>$v_1,'cid'=> $var_2345,'pcid'=> $var_2345,'type'=> 'showArt','type_i'=> 1,'title'=> '恰好遇见你','thumb'=> 'http://2.cnhjdy.net/assetsj/hunsha/a2.jpg','text'=> '这里是文章内容',);
				$var_6258=array('uniacid' =>$v_1,'cid'=> $var_2345,'pcid'=> $var_2345,'type'=> 'showArt','type_i'=> 0,'title'=> '月夜香奈儿活动','thumb'=> 'http://2.cnhjdy.net/assetsj/hunsha/a3.jpg','text'=> '这里是文章内容',);
				Db::table('ims_sudu8_page_products')->insert($var_6256);
				Db::table('ims_sudu8_page_products')->insert($var_6257);
				Db::table('ims_sudu8_page_products')->insert($var_6258);
			}
			$var_6259=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPro')->where('pcid',$var_6247)->order('id asc')->field('uniacid,id')->select();
			$var_6260=count($var_6259);
			if($var_6260==0)
			{
				$var_6261=array('uniacid' =>$v_1,'cid'=> $var_6247,'pcid'=> $var_6247,'type'=> 'showPro','type_i'=> 1,'labels'=>'','title'=> '情侣写真','price'=>199,'market_price'=>999,'sale_num'=>18,'thumb'=> 'http://2.cnhjdy.net/assetsj/hunsha/c6.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/hunsha/c6.jpg";}','product_txt'=>'这里是商品的详细介绍，可放图文',);
				$var_815=array('uniacid' =>$v_1,'cid'=> $var_6247,'pcid'=> $var_6247,'type'=> 'showPro','type_i'=> 1,'labels'=>'','title'=> '婚纱套系','price'=>2999,'market_price'=>5999,'sale_num'=>22,'thumb'=> 'http://2.cnhjdy.net/assetsj/hunsha/c1.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/hunsha/c1.jpg";}','product_txt'=>'这里是商品的详细介绍，可放图文',);
				Db::table('ims_sudu8_page_products')->insert($var_6261);
				Db::table('ims_sudu8_page_products')->insert($var_815);
			}
			$v_2=array('uniacid' =>$v_1,header=>1,'tel_box'=>1,'serv_box'=>1,'content'=>'<p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p>',);
			$var_6262=Db::table('ims_sudu8_page_about')->where('uniacid',$v_1)->field('uniacid')->find();
			if(empty($var_6262['uniacid']))
			{
				Db::table('ims_sudu8_page_about')->insert($v_2);
			}
			else
			{
				Db::table('ims_sudu8_page_about')->where('uniacid',$v_1)->update($v_2);
			}
			$var_6263=array('uniacid' =>$v_1,'forms_style'=> 2,'forms_inps'=> 0,'forms_head'=> 'none','forms_name'=> '自助预约','forms_ename'=> 'Self Booking','forms_title_s'=> 'title1','subtime'=> 0,'forms_btn'=> '立即预约','success'=> '您已预约成功！','name'=> '姓名','name_must'=> 1,'tel'=> '电话','tel_use'=> 1,'tel_must'=> 1,date=> '预约时间','date_use'=> 1,'checkbox_n'=> '拍摄类型','checkbox_num'=> 2,'checkbox_use'=> 1,'checkbox_v'=> '婚纱摄影,亲子儿童,个人写真,情侣闺蜜','content_n'=> '备注','content_use'=> 1,'wechat_use'=> 0,'address_use'=> 0,'date_must'=> 0,'single_use'=> 0,'checkbox_must'=> 0,'content_must'=> 0,);
			$var_6264=Db::table('ims_sudu8_page_forms_config')->where('uniacid',$v_1)->field('uniacid')->find();
			if(empty($var_6264['uniacid']))
			{
				Db::table('ims_sudu8_page_forms_config')->insert($var_6263);
			}
			else
			{
				Db::table('ims_sudu8_page_forms_config')->where('uniacid',$v_1)->update($var_6263);
			}
			$var_6265=array('uniacid' =>$v_1,'index_style' =>'slide','slide' =>'a:3:{i:0;s:50:"http://2.cnhjdy.net/assetsj/hunsha/slide1.jpg";i:1;s:50:"http://2.cnhjdy.net/assetsj/hunsha/slide2.jpg";i:2;s:50:"http://2.cnhjdy.net/assetsj/hunsha/slide3.jpg";}','name' =>'通用门店模版','desc'=>'捷安特GCW、禧玛诺高级维修中心','about' =>'捷安特，全称台湾巨大机械工业股份有限公司，是全球自行车生产及行销最具规模的公司之一，其网络横跨五大洲，五十余个国家，公司遍布中国大陆、美国、英国、德国、法国、日本、加拿大、荷兰等地，掌握着超过1万个销售通路。','address' =>'北京市东城区三环路888号',time =>'9:00 - 18:00','tel' =>18669868123,'longitude' =>116.321697,'latitude' =>39.894197,'aboutCN' =>'公司介绍','aboutCNen' =>'About Company','index_about_title' =>'title1','banner'=>'http://2.cnhjdy.net/assetsj/hunsha/bg.jpg','logo'=>'http://2.cnhjdy.net/assetsj/hunsha/logo.jpg','base_color'=> '#389bde','base_tcolor'=> '#ffffff','base_color2'=> '#ffcf3d','base_color_t'=> '#ffcf3d','index_style'=> header,'tel_box'=> 1,'index_about_title'=> 'title2','catename_x'=> '最新客照','catenameen_x'=> 'New Photos','i_b_x_ts'=>9,'i_b_x_iw'=> 560,'i_b_y_ts'=> 9,'c_b_bg'=> 'http://2.cnhjdy.net/assetsj/hunsha/bg_s.jpg','c_b_btn'=> 0,'form_index'=> 0,'c_title'=> 1,'video' =>'','v_img' =>'','tabbar_t'=>1,'tabbar_bg'=>'#ffffff','color_bar'=>'ffffff','tabbar_tc'=>'#000000','tabbar_tca'=>'#035fa0','tabbar'=>'a:4:{i:0;s:211:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:51:"http://2.cnhjdy.net/assetsj/hunsha/tabbar1.png";s:9:"tabbar_p2";s:51:"http://2.cnhjdy.net/assetsj/hunsha/tabbar1.png";}";i:1;s:218:"a:4:{s:8:"tabbar_l";s:5:"about";s:8:"tabbar_t";s:12:"关于我们";s:9:"tabbar_p1";s:51:"http://2.cnhjdy.net/assetsj/hunsha/tabbar2.png";s:9:"tabbar_p2";s:51:"http://2.cnhjdy.net/assetsj/hunsha/tabbar2.png";}";i:2;s:216:"a:4:{s:8:"tabbar_l";s:3:"tel";s:8:"tabbar_t";s:12:"联系商家";s:9:"tabbar_p1";s:51:"http://2.cnhjdy.net/assetsj/hunsha/tabbar3.png";s:9:"tabbar_p2";s:51:"http://2.cnhjdy.net/assetsj/hunsha/tabbar3.png";}";i:3;s:224:"a:4:{s:8:"tabbar_l";s:10:"usercenter";s:8:"tabbar_t";s:12:"一键导航";s:9:"tabbar_p1";s:51:"http://2.cnhjdy.net/assetsj/hunsha/tabbar4.png";s:9:"tabbar_p2";s:51:"http://2.cnhjdy.net/assetsj/hunsha/tabbar4.png";}";}',);
			$var_6266=unserialize($var_6265['slide']);
			foreach($var_6266 as $var_6267=>$var_6268)
			{
				$var_6269['appletid']=$v_1;
				$var_6269['url']=$var_6268;
				$var_6269['dateline']=time();
				Db::table('image_url')->insert($var_6269);
			}
			if(empty($var_6222['uniacid']))
			{
				Db::table('ims_sudu8_page_base')->insert($var_6265);
			}
			else
			{
				Db::table('ims_sudu8_page_base')->where('uniacid',$v_1)->update($var_6265);
			}
			$var_1212=array('uniacid' =>$v_1,'statue'=>0,);
			Db::table('ims_sudu8_page_nav')->where('uniacid',$v_1)->update($var_1212);
		}
		elseif($v_2==1)
		{
			$var_6227=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPic')->where('cid',0)->order('id asc')->field('uniacid,id')->find();
			$var_6228=array('uniacid' =>$v_1,'num' =>9,'type' =>'showPic','statue' =>1,'cid' =>0,'name' =>'客照欣赏','ename' =>'Photo Cases','show_i' =>1,'list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>2,'list_stylet' =>'tcb','pic_page_btn'=>0,);
			if(empty($var_6227['uniacid']))
			{
				Db::table('ims_sudu8_page_cate')->insert($var_6228);
			}
			else
			{
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6227['id'])->update($var_6228);
			}
			$var_6228=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPic')->where('cid',0)->order('id asc')->field('uniacid,id')->find();
			$var_967=$var_6228['id'];
			$var_6229=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPic')->where('cid',$var_967)->order('id asc')->field('uniacid,id')->find();
			$var_6230=count($var_6229);
			if($var_6230==0)
			{
				$var_6231=array('uniacid' =>$v_1,'num' =>9,'type' =>'showPic','statue' =>1,'cid' =>$var_967,'name' =>'婚纱摄影','ename' =>'Wedding photography','show_i' =>1,'catepic'=>'http://2.cnhjdy.net/assetsj/hunsha/nav1.png','list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>2,'list_stylet' =>'tcb','pic_page_btn'=>0,);
				$var_425=array('uniacid' =>$v_1,'num' =>9,'type' =>'showPic','statue' =>1,'cid' =>$var_967,'name' =>'全球旅拍','ename' =>'Global tour','show_i' =>1,'catepic'=>'http://2.cnhjdy.net/assetsj/hunsha/nav2.png','list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>2,'list_stylet' =>'tcb','pic_page_btn'=>0,);
				$var_6232=array('uniacid' =>$v_1,'num' =>9,'type' =>'showPic','statue' =>1,'cid' =>$var_967,'name' =>'个人写真','ename' =>'Personal photo','show_i' =>1,'catepic'=>'http://2.cnhjdy.net/assetsj/hunsha/nav3.png','list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>2,'list_stylet' =>'tcb','pic_page_btn'=>0,);
				$var_103=array('uniacid' =>$v_1,'num' =>9,'type' =>'showPic','statue' =>1,'cid' =>$var_967,'name' =>'情侣闺蜜','ename' =>'Lovers & girlfriends','show_i' =>1,'catepic'=>'http://2.cnhjdy.net/assetsj/hunsha/nav4.png','list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>2,'list_stylet' =>'tcb','pic_page_btn'=>0,);
				Db::table('ims_sudu8_page_cate')->insert($var_6231);
				Db::table('ims_sudu8_page_cate')->insert($var_425);
				Db::table('ims_sudu8_page_cate')->insert($var_6232);
				Db::table('ims_sudu8_page_cate')->insert($var_103);
				$var_739=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPic')->where('cid','neq',0)->order('id asc')->field('uniacid,id')->select();
				$var_6233=$var_739[0]['id'];
				$var_6234=$var_739[1]['id'];
				$var_6235=$var_739[2]['id'];
				$var_6236=$var_739[3]['id'];
			}
			else
			{
				$var_739=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPic')->where('cid','neq',0)->order('id asc')->field('uniacid,id')->select();
				$var_6233=$var_739[0]['id'];
				$var_6234=$var_739[1]['id'];
				$var_6235=$var_739[2]['id'];
				$var_6236=$var_739[3]['id'];
			}
			$var_6237=Db::table('ims_sudu8_page_navlist')->where('uniacid',$v_1)->field('uniacid,id')->select();
			$var_6238=array('uniacid' =>$v_1,'num' =>99,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/hunsha/nav1.png','title' =>'婚纱摄影','url' =>'/sudu8_page/listPic/listPic?cid='.$var_6233,);
			$var_486=array('uniacid' =>$v_1,'num' =>98,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/hunsha/nav2.png','title' =>'全球旅拍','url' =>'/sudu8_page/listPic/listPic?cid='.$var_6234,);
			$var_6239=array('uniacid' =>$v_1,'num' =>97,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/hunsha/nav3.png','title' =>'个人写真','url' =>'/sudu8_page/listPic/listPic?cid='.$var_6235,);
			$var_6240=array('uniacid' =>$v_1,'num' =>96,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/hunsha/nav4.png','title' =>'情侣闺蜜','url' =>'/sudu8_page/listPic/listPic?cid='.$var_6236,);
			if(empty($var_6237))
			{
				Db::table('ims_sudu8_page_navlist')->insert($var_6238);
				Db::table('ims_sudu8_page_navlist')->insert($var_486);
				Db::table('ims_sudu8_page_navlist')->insert($var_6239);
				Db::table('ims_sudu8_page_navlist')->insert($var_6240);
			}
			else
			{
				$var_6237=Db::table('ims_sudu8_page_navlist')->where('uniacid',$v_1)->field('uniacid,id')->select();
				$var_375=$var_6237[0]['id'];
				$var_6241=$var_6237[1]['id'];
				$var_6242=$var_6237[2]['id'];
				$var_321=$var_6237[3]['id'];
				Db::table('ims_sudu8_page_navlist')->where('id',$var_375)->where('uniacid',$v_1)->update($var_6238);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_6241)->where('uniacid',$v_1)->update($var_486);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_6242)->where('uniacid',$v_1)->update($var_6239);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_321)->where('uniacid',$v_1)->update($var_6240);
			}
			$var_59=array('url'=> '','uniacid' =>$v_1,'statue'=>1,'name_s'=>1,'box_p_tb'=>3,'box_p_lr'=>1,'number'=>4,'img_size'=>60,'title_position'=>1,'title_color'=>'#222',);
			$var_6243=Db::table('ims_sudu8_page_nav')->where('uniacid',$v_1)->field('uniacid')->find();
			if(empty($var_6243['uniacid']))
			{
				Db::table('ims_sudu8_page_nav')->insert($var_59);
			}
			else
			{
				Db::table('ims_sudu8_page_nav')->where('uniacid',$v_1)->update($var_59);
			}
			$var_1203=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showArt')->where('cid',0)->order('id asc')->field('uniacid,id')->find();
			$var_6244=array('uniacid' =>$v_1,'num' =>8,'type' =>'showArt','statue' =>1,'cid' =>0,'name' =>'优惠活动','ename' =>'Activities','show_i' =>1,'list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>1,'list_stylet' =>'tlb',);
			if(empty($var_1203['uniacid']))
			{
				Db::table('ims_sudu8_page_cate')->insert($var_6244);
			}
			else
			{
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_1203['id'])->update($var_6244);
			}
			$var_6244=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showArt')->where('cid',0)->order('id asc')->field('uniacid,id')->find();
			$var_2345=$var_6244['id'];
			$var_6245=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->find();
			$var_6246=array('uniacid' =>$v_1,'num' =>5,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'服务展示','ename' =>'Service display','show_i' =>1,'list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'none',);
			if(empty($var_6245['uniacid']))
			{
				Db::table('ims_sudu8_page_cate')->insert($var_6246);
			}
			else
			{
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_1203['id'])->update($var_6246);
			}
			$var_6246=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->find();
			$var_6247=$var_6246['id'];
			$var_6248=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPic')->where('pcid',$var_967)->order('id asc')->field('uniacid,id')->select();
			$var_6249=count($var_6248);
			if($var_6249==0)
			{
				$var_6250=array('uniacid' =>$v_1,'cid'=> $var_6233,'pcid'=> $var_967,'type_x'=> 1,'type'=> 'showPic','type_i'=> 1,'title'=> '婚纱摄影欣赏','thumb'=> 'http://2.cnhjdy.net/assetsj/hunsha/case3.jpg','text'=> 'a:4:{i:0;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con1.jpg";i:1;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con2.jpg";i:2;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con3.jpg";i:3;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con4.jpg";}',);
				$var_6251=array('uniacid' =>$v_1,'cid'=>$var_6233,'pcid'=> $var_967,'type_x'=>1,'type'=> 'showPic','type_i'=>1,'title'=>'海南岛之旅','thumb'=>'http://2.cnhjdy.net/assetsj/hunsha/case4.jpg','text'=>'a:4:{i:0;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con1.jpg";i:1;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con2.jpg";i:2;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con3.jpg";i:3;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con4.jpg";}',);
				$var_6252=array('uniacid' =>$v_1,'cid'=>$var_6233,'pcid'=> $var_967,'type_x'=>1,'type'=> 'showPic','type_i'=>1,'title'=>'梦幻仙境','thumb'=>'http://2.cnhjdy.net/assetsj/hunsha/case8.jpg','text'=>'a:4:{i:0;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con1.jpg";i:1;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con2.jpg";i:2;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con3.jpg";i:3;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con4.jpg";}',);
				$var_6253=array('uniacid' =>$v_1,'cid'=>$var_6233,'pcid'=> $var_967,'type_x'=>1,'type'=> 'showPic','type_i'=>1,'title'=>'夕阳的艳丽','thumb'=>'http://2.cnhjdy.net/assetsj/hunsha/case7.jpg','text'=>'a:4:{i:0;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con1.jpg";i:1;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con2.jpg";i:2;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con3.jpg";i:3;s:53:"http://2.cnhjdy.net/assetsj/hunsha/case_con4.jpg";}',);
				Db::table('ims_sudu8_page_products')->insert($var_6250);
				Db::table('ims_sudu8_page_products')->insert($var_6251);
				Db::table('ims_sudu8_page_products')->insert($var_6252);
				Db::table('ims_sudu8_page_products')->insert($var_6253);
			}
			$var_6254=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showArt')->where('pcid',$var_6227['id'])->order('id asc')->field('uniacid,id')->select();
			$var_6255=count($var_6254);
			if($var_6255==0)
			{
				$var_6256=array('uniacid' =>$v_1,'cid'=> $var_2345,'pcid'=> $var_2345,'type'=> 'showArt','type_i'=> 1,'title'=> '为爱再造一座城','thumb'=> 'http://2.cnhjdy.net/assetsj/hunsha/a1.jpg','text'=> '这里是文章内容',);
				$var_6257=array('uniacid' =>$v_1,'cid'=> $var_2345,'pcid'=> $var_2345,'type'=> 'showArt','type_i'=> 1,'title'=> '恰好遇见你','thumb'=> 'http://2.cnhjdy.net/assetsj/hunsha/a2.jpg','text'=> '这里是文章内容',);
				$var_6258=array('uniacid' =>$v_1,'cid'=> $var_2345,'pcid'=> $var_2345,'type'=> 'showArt','type_i'=> 0,'title'=> '月夜香奈儿活动','thumb'=> 'http://2.cnhjdy.net/assetsj/hunsha/a3.jpg','text'=> '这里是文章内容',);
				Db::table('ims_sudu8_page_products')->insert($var_6256);
				Db::table('ims_sudu8_page_products')->insert($var_6257);
				Db::table('ims_sudu8_page_products')->insert($var_6258);
			}
			$var_6259=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPro')->where('pcid',$var_6247)->order('id asc')->field('uniacid,id')->select();
			$var_6260=count($var_6259);
			if($var_6260==0)
			{
				$var_6261=array('uniacid' =>$v_1,'cid'=> $var_6247,'pcid'=> $var_6247,'type'=> 'showPro','type_i'=> 1,'labels'=>'','title'=> '情侣写真','price'=>199,'market_price'=>999,'sale_num'=>18,'thumb'=> 'http://2.cnhjdy.net/assetsj/hunsha/c6.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/hunsha/c6.jpg";}','product_txt'=>'这里是商品的详细介绍，可放图文',);
				$var_815=array('uniacid' =>$v_1,'cid'=> $var_6247,'pcid'=> $var_6247,'type'=> 'showPro','type_i'=> 1,'labels'=>'','title'=> '婚纱套系','price'=>2999,'market_price'=>5999,'sale_num'=>22,'thumb'=> 'http://2.cnhjdy.net/assetsj/hunsha/c1.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/hunsha/c1.jpg";}','product_txt'=>'这里是商品的详细介绍，可放图文',);
				Db::table('ims_sudu8_page_products')->insert($var_6261);
				Db::table('ims_sudu8_page_products')->insert($var_815);
			}
			$v_2=array('uniacid' =>$v_1,header=>1,'tel_box'=>1,'serv_box'=>1,'content'=>'<p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p>',);
			$var_6262=Db::table('ims_sudu8_page_about')->where('uniacid',$v_1)->field('uniacid')->find();
			if(empty($var_6262['uniacid']))
			{
				Db::table('ims_sudu8_page_about')->insert($v_2);
			}
			else
			{
				Db::table('ims_sudu8_page_about')->where('uniacid',$v_1)->update($v_2);
			}
			$var_6263=array('uniacid' =>$v_1,'forms_style'=> 2,'forms_inps'=> 0,'forms_head'=> 'none','forms_name'=> '自助预约','forms_ename'=> 'Self Booking','forms_title_s'=> 'title1','subtime'=> 0,'forms_btn'=> '立即预约','success'=> '您已预约成功！','name'=> '姓名','name_must'=> 1,'tel'=> '电话','tel_use'=> 1,'tel_must'=> 1,date=> '预约时间','date_use'=> 1,'checkbox_n'=> '拍摄类型','checkbox_num'=> 2,'checkbox_use'=> 1,'checkbox_v'=> '婚纱摄影,亲子儿童,个人写真,情侣闺蜜','content_n'=> '备注','content_use'=> 1,'wechat_use'=> 0,'address_use'=> 0,'date_must'=> 0,'single_use'=> 0,'checkbox_must'=> 0,'content_must'=> 0,);
			$var_6264=Db::table('ims_sudu8_page_forms_config')->where('uniacid',$v_1)->field('uniacid')->find();
			if(empty($var_6264['uniacid']))
			{
				Db::table('ims_sudu8_page_forms_config')->insert($var_6263);
			}
			else
			{
				Db::table('ims_sudu8_page_forms_config')->where('uniacid',$v_1)->update($var_6263);
			}
			$var_6265=array('uniacid' =>$v_1,'index_style' =>'slide','slide' =>'a:3:{i:0;s:50:"http://2.cnhjdy.net/assetsj/hunsha/slide1.jpg";i:1;s:50:"http://2.cnhjdy.net/assetsj/hunsha/slide2.jpg";i:2;s:50:"http://2.cnhjdy.net/assetsj/hunsha/slide3.jpg";}','name' =>'婚纱摄影演示版','desc'=>'中国新派婚纱摄影典范','about' =>'婚纱摄影是为客户量身打造，服务，品质，销售于一体的婚纱摄影。摄影为讲究品牌、注重品质的顾客，精心打造世界一流的婚纱照，使顾客充分享受时尚、专业、舒适的拍摄过程。','address' =>'北京市东城区三环路888号',time =>'9:00 - 18:00','tel' =>18669868123,'longitude' =>116.321697,'latitude' =>39.894197,'aboutCN' =>'公司介绍','aboutCNen' =>'About Company','index_about_title' =>9,'banner'=>'http://2.cnhjdy.net/assetsj/hunsha/bg.jpg','logo'=>'http://2.cnhjdy.net/assetsj/hunsha/logo.jpg','base_color'=> '#eb75cc','base_tcolor'=> '#ffffff','base_color2'=> '#ff007b','base_color_t'=> '#ffcf3d','index_style'=> 'slide','tel_box'=> 0,'index_about_title'=> 'title2','catename_x'=> '最新客照','catenameen_x'=> 'New Photos','i_b_x_ts'=>2,'i_b_x_iw'=> 560,'i_b_y_ts'=> 9,'c_b_bg'=> 'http://2.cnhjdy.net/assetsj/hunsha/bg_s.jpg','c_b_btn'=> 1,'form_index'=> 0,'c_title'=> 1,'video' =>'','v_img' =>'','tabbar_t'=>1,'tabbar_bg'=>'#ffffff','color_bar'=>'ffffff','tabbar_tc'=>'#000000','tabbar_tca'=>'#ff007b','tabbar'=>'a:5:{i:0;s:211:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:51:"http://2.cnhjdy.net/assetsj/hunsha/tabbar1.png";s:9:"tabbar_p2";s:51:"http://2.cnhjdy.net/assetsj/hunsha/tabbar1.png";}";i:1;s:218:"a:4:{s:8:"tabbar_l";s:5:"about";s:8:"tabbar_t";s:12:"公司介绍";s:9:"tabbar_p1";s:51:"http://2.cnhjdy.net/assetsj/hunsha/tabbar2.png";s:9:"tabbar_p2";s:51:"http://2.cnhjdy.net/assetsj/hunsha/tabbar2.png";}";i:2;s:233:"a:5:{s:8:"tabbar_l";s:1:"7";s:8:"tabbar_t";s:12:"产品中心";s:9:"tabbar_p1";s:51:"http://2.cnhjdy.net/assetsj/hunsha/tabbar3.png";s:9:"tabbar_p2";s:51:"http://2.cnhjdy.net/assetsj/hunsha/tabbar3.png";s:4:"type";s:1:"7";}";i:3;s:233:"a:5:{s:8:"tabbar_l";s:1:"7";s:8:"tabbar_t";s:12:"最新活动";s:9:"tabbar_p1";s:51:"http://2.cnhjdy.net/assetsj/hunsha/tabbar4.png";s:9:"tabbar_p2";s:51:"http://2.cnhjdy.net/assetsj/hunsha/tabbar4.png";s:4:"type";s:1:"7";}";i:4;s:224:"a:4:{s:8:"tabbar_l";s:10:"usercenter";s:8:"tabbar_t";s:12:"个人中心";s:9:"tabbar_p1";s:51:"http://2.cnhjdy.net/assetsj/hunsha/tabbar5.png";s:9:"tabbar_p2";s:51:"http://2.cnhjdy.net/assetsj/hunsha/tabbar5.png";}";}',);
			$var_6266=unserialize($var_6265['slide']);
			foreach($var_6266 as $var_6267=>$var_6268)
			{
				$var_6269['appletid']=$v_1;
				$var_6269['url']=$var_6268;
				$var_6269['dateline']=time();
				Db::table('image_url')->insert($var_6269);
			}
			if(empty($var_6222['uniacid']))
			{
				Db::table('ims_sudu8_page_base')->insert($var_6265);
			}
			else
			{
				Db::table('ims_sudu8_page_base')->where('uniacid',$v_1)->update($var_6265);
			}
			$var_1212=array('uniacid' =>$v_1,'statue'=>0,);
			Db::table('ims_sudu8_page_nav')->where('uniacid',$v_1)->update($var_1212);
		}
		elseif($v_2==2)
		{
			$var_1203=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showArt')->where('cid',0)->order('id asc')->field('uniacid,id')->find();
			$var_900=array('uniacid' =>$v_1,'num' =>98,'type' =>'showArt','statue' =>1,'cid' =>0,'name' =>'服务项目','catepic' =>'http://2.cnhjdy.net/assetsj/pigefanxin/nav2.png','ename' =>'Service','show_i' =>1,'list_tstyle' =>1,'list_tstylel' =>0,'list_type' =>1,'list_style' =>1,'list_stylet' =>'tc' );
			$var_6270=array('uniacid' =>$v_1,'num' =>8,'type' =>'showArt','statue' =>1,'cid' =>0,'name' =>'客户案例','ename' =>'case','show_i' =>1,'list_tstyle' =>1,'list_tstylel' =>0,'list_type' =>1,'list_style' =>3,'list_stylet' =>'tc' );
			$var_6271=array('uniacid' =>$v_1,'num' =>99,'type' =>'showArt','statue' =>1,'cid' =>0,'name' =>'加盟优势','ename' =>'Advantage','show_i' =>1,'list_tstyle' =>1,'list_tstylel' =>0,'list_type' =>1,'list_style' =>2,'list_stylet' =>'tc' );
			if(empty($var_1203['uniacid']))
			{
				Db::table('ims_sudu8_page_cate')->insert($var_900);
				Db::table('ims_sudu8_page_cate')->insert($var_6270);
				Db::table('ims_sudu8_page_cate')->insert($var_6271);
				$var_6272=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showArt')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
				$var_6273=$var_6272[0]['id'];
				$var_6274=$var_6272[1]['id'];
				$var_6275=$var_6272[2]['id'];
			}
			else
			{
				$var_6272=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showArt')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
				$var_6273=$var_6272[0]['id'];
				$var_6274=$var_6272[1]['id'];
				$var_6275=$var_6272[2]['id'];
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6273)->update($var_900);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6274)->update($var_6270);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6275)->update($var_6271);
			}
			$var_6245=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->find();
			$var_6246=array('uniacid' =>$v_1,'num' =>98,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'材料销售','ename' =>'store','catepic' =>'http://2.cnhjdy.net/assetsj/pigefanxin/nav3.png','cdesc' =>'','show_i' =>1,'list_tstyle' =>1,'list_tstylel' =>0,'list_type' =>0,'list_style' =>12,'list_stylet' =>'tc',);
			if(empty($var_6245['uniacid']))
			{
				Db::table('ims_sudu8_page_cate')->insert($var_6246);
			}
			else
			{
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6245['id'])->update($var_6246);
			}
			$var_6276=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->find();
			$var_6247=$var_6276['id'];
			$var_6277=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',$var_6247)->order('id asc')->field('uniacid')->select();
			$var_6278=count($var_6277);
			$var_6279=array('uniacid' =>$v_1,'num' =>99,'type' =>'showPro','statue' =>1,'cid' =>$var_6247,'name' =>'维修套装','ename' =>'','catepic' =>'http://2.cnhjdy.net/assetsj/pigefanxin/column1.jpg','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'tl',);
			$var_6280=array('uniacid' =>$v_1,'num' =>98,'type' =>'showPro','statue' =>1,'cid' =>$var_6247,'name' =>'维修工具','ename' =>'','catepic' =>'http://2.cnhjdy.net/assetsj/pigefanxin/column2.jpg','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'tl',);
			$var_6281=array('uniacid' =>$v_1,'num' =>97,'type' =>'showPro','statue' =>1,'cid' =>$var_6247,'name' =>'家具维修材料','ename' =>'','catepic' =>'http://2.cnhjdy.net/assetsj/pigefanxin/column3.jpg','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'tl',);
			$var_6282=array('uniacid' =>$v_1,'num' =>96,'type' =>'showPro','statue' =>1,'cid' =>$var_6247,'name' =>'沙发维修材料','ename' =>'','catepic' =>'http://2.cnhjdy.net/assetsj/pigefanxin/column4.jpg','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'tl',);
			if($var_6278==0)
			{
				Db::table('ims_sudu8_page_cate')->insert($var_6279);
				Db::table('ims_sudu8_page_cate')->insert($var_6280);
				Db::table('ims_sudu8_page_cate')->insert($var_6281);
				Db::table('ims_sudu8_page_cate')->insert($var_6282);
				$var_6283=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid','NEQ',0)->order('id asc')->field('uniacid,id')->select();
				$var_222=$var_6283[0]['id'];
				$var_6284=$var_6283[1]['id'];
				$var_6285=$var_6283[2]['id'];
				$var_6286=$var_6283[3]['id'];
			}
			else
			{
				$var_6283=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid','NEQ',0)->order('id asc')->field('uniacid,id')->select();
				$var_222=$var_6283[0]['id'];
				$var_6284=$var_6283[1]['id'];
				$var_6285=$var_6283[2]['id'];
				$var_6286=$var_6283[3]['id'];
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_222)->update($var_6279);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6284)->update($var_6280);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6285)->update($var_6281);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6286)->update($var_6282);
			}
			$var_6287=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','page')->where('cid',0)->order('id asc')->field('uniacid,id')->find();
			$var_956=array('uniacid' =>$v_1,'num' =>99,'type' =>'page','statue' =>1,'cid' =>0,'name' =>'关于我们','ename' =>'About','catepic' =>'http://2.cnhjdy.net/assetsj/pigefanxin/nav1.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>2,'list_type' =>1,'content' =>'此处是栏目内容',);
			$var_243=array('uniacid' =>$v_1,'num' =>97,'type' =>'page','statue' =>1,'cid' =>0,'name' =>'加盟培训','ename' =>Join,'catepic' =>'http://2.cnhjdy.net/assetsj/pigefanxin/nav4.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>2,'list_type' =>1,'content' =>'此处是栏目内容',);
			if(empty($var_6287['uniacid']))
			{
				Db::table('ims_sudu8_page_cate')->insert($var_956);
				Db::table('ims_sudu8_page_cate')->insert($var_243);
				$var_6288=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','page')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
				$var_6289=$var_6288[0]['id'];
				$var_6290=$var_6288[1]['id'];
			}
			else
			{
				$var_6288=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','page')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
				$var_6289=$var_6288[0]['id'];
				$var_6290=$var_6288[1]['id'];
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6289)->update($var_956);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6290)->update($var_243);
			}
			$var_6237=Db::table('ims_sudu8_page_navlist')->where('uniacid',$v_1)->field('uniacid,id')->select();
			$var_6238=array('uniacid' =>$v_1,'num' =>99,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/pigefanxin/nav1.png','title' =>'关于我们','url' =>'/sudu8_page/page/page?cid='.$var_6289,);
			$var_486=array('uniacid' =>$v_1,'num' =>98,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/pigefanxin/nav2.png','title' =>'服务项目','url' =>'/sudu8_page/listPic/listPic?cid='.$var_6273,);
			$var_6239=array('uniacid' =>$v_1,'num' =>97,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/pigefanxin/nav3.png','title' =>'服务展示','url' =>'',);
			$var_6240=array('uniacid' =>$v_1,'num' =>96,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/pigefanxin/nav4.png','title' =>'加盟培训','url' =>'/sudu8_page/page/page?cid='.$var_6290,);
			if(empty($var_6237))
			{
				Db::table('ims_sudu8_page_navlist')->insert($var_6238);
				Db::table('ims_sudu8_page_navlist')->insert($var_486);
				Db::table('ims_sudu8_page_navlist')->insert($var_6239);
				Db::table('ims_sudu8_page_navlist')->insert($var_6240);
			}
			else
			{
				$var_6237=Db::table('ims_sudu8_page_navlist')->where('uniacid',$v_1)->field('uniacid,id')->select();
				$var_375=$var_6237[0]['id'];
				$var_6241=$var_6237[1]['id'];
				$var_6242=$var_6237[2]['id'];
				$var_321=$var_6237[3]['id'];
				Db::table('ims_sudu8_page_navlist')->where('id',$var_375)->where('uniacid',$v_1)->update($var_6238);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_6241)->where('uniacid',$v_1)->update($var_486);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_6242)->where('uniacid',$v_1)->update($var_6239);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_321)->where('uniacid',$v_1)->update($var_6240);
			}
			$var_1212=array('url'=>'','uniacid' =>$v_1,'statue'=>2,'name_s'=>1,'box_p_tb'=>4,'box_p_lr'=>1,'number'=>4,'img_size'=>60,'title_position'=>1,'title_color' =>'#222222',);
			$var_6243=Db::table('ims_sudu8_page_nav')->where('uniacid',$v_1)->field('uniacid')->find();
			if(empty($var_6243['uniacid']))
			{
				Db::table('ims_sudu8_page_nav')->insert($var_1212);
			}
			else
			{
				Db::table('ims_sudu8_page_nav')->where('uniacid',$v_1)->update($var_1212);
			}
			$var_6291=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showArt')->where('pcid',$var_6273)->order('id asc')->field('uniacid')->select();
			$var_6292=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showArt')->where('pcid',$var_6274)->order('id asc')->field('uniacid')->select();
			$var_648=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showArt')->where('pcid',$var_6275)->order('id asc')->field('uniacid')->select();
			$var_6293=count($var_6291);
			$var_490=count($var_6292);
			$var_6294=count($var_648);
			$var_6256=array('num' =>99,'uniacid' =>$v_1,'cid'=> $var_6273,'pcid'=> $var_6273,'type_x'=>0,'type_y'=>0,'type_i'=> 1,'type'=> 'showArt','title'=> '沙发维修','thumb'=> 'http://2.cnhjdy.net/assetsj/pigefanxin/art1.jpg','text'=> '这里是文章内容',);
			$var_6257=array('num' =>93,'uniacid' =>$v_1,'cid'=> $var_6273,'pcid'=> $var_6273,'type_x'=>0,'type_y'=>0,'type_i'=> 1,'type'=> 'showArt','title'=> '汽车内饰维修','thumb'=> 'http://2.cnhjdy.net/assetsj/pigefanxin/art2.jpg','text'=> '这里是文章内容',);
			$var_6258=array('num' =>98,'uniacid' =>$v_1,'cid'=> $var_6273,'pcid'=> $var_6273,'type_x'=>0,'type_y'=>0,'type_i'=> 1,'type'=> 'showArt','title'=> '沙发翻新','thumb'=> 'http://2.cnhjdy.net/assetsj/pigefanxin/art3.jpg','text'=> '这里是文章内容',);
			$var_729=array('num' =>98,'uniacid' =>$v_1,'cid'=> $var_6273,'pcid'=> $var_6273,'type_x'=>0,'type_y'=>0,'type_i'=> 1,'type'=> 'showArt','title'=> '办公家具维修','thumb'=> 'http://2.cnhjdy.net/assetsj/pigefanxin/art4.jpg','text'=> '这里是文章内容',);
			if($var_6293==0)
			{
				Db::table('ims_sudu8_page_products')->insert($var_6256);
				Db::table('ims_sudu8_page_products')->insert($var_6257);
				Db::table('ims_sudu8_page_products')->insert($var_6258);
				Db::table('ims_sudu8_page_products')->insert($var_729);
			}
			else
			{
				$var_1967=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showArt')->where('pcid',$var_6273)->order('id asc')->field('uniacid,id')->select();
				$var_6295=$var_1967[0]['id'];
				$var_6296=$var_1967[1]['id'];
				$var_6297=$var_1967[2]['id'];
				$var_6298=$var_1967[3]['id'];
				Db::table('ims_sudu8_page_products')->where('id',$var_6295)->where('uniacid',$v_1)->update($var_6256);
				Db::table('ims_sudu8_page_products')->where('id',$var_6296)->where('uniacid',$v_1)->update($var_6257);
				Db::table('ims_sudu8_page_products')->where('id',$var_6297)->where('uniacid',$v_1)->update($var_6258);
				Db::table('ims_sudu8_page_products')->where('id',$var_6298)->where('uniacid',$v_1)->update($var_729);
			}
			$var_6299=array('num' =>99,'uniacid' =>$v_1,'cid'=> $var_6274,'pcid'=> $var_6274,'type_x'=>0,'type_y'=>0,'type_i'=> 1,'type'=> 'showArt','title'=> '亢龙太子酒店-----沙发维修','desc'=> '亢龙太子酒店-----沙发维修','thumb'=> 'http://2.cnhjdy.net/assetsj/pigefanxin/art10.jpg','text'=> '这里是文章内容',);
			$var_6300=array('num' =>93,'uniacid' =>$v_1,'cid'=> $var_6274,'pcid'=> $var_6274,'type_x'=>0,'type_y'=>0,'type_i'=> 1,'type'=> 'showArt','title'=> '豪宅------家具贴膜','desc'=> '豪宅------家具贴膜','thumb'=> 'http://2.cnhjdy.net/assetsj/pigefanxin/art11.jpg','text'=> '这里是文章内容',);
			if($var_490==0)
			{
				Db::table('ims_sudu8_page_products')->insert($var_6299);
				Db::table('ims_sudu8_page_products')->insert($var_6300);
			}
			else
			{
				$var_6301=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showArt')->where('pcid',$var_6274)->order('id asc')->field('uniacid,id')->select();
				$var_6302=$var_6301[0]['id'];
				$var_6303=$var_6301[1]['id'];
				Db::table('ims_sudu8_page_products')->where('id',$var_6302)->where('uniacid',$v_1)->update($var_6299);
				Db::table('ims_sudu8_page_products')->where('id',$var_6303)->where('uniacid',$v_1)->update($var_6300);
			}
			$var_6304=array('num' =>99,'uniacid' =>$v_1,'cid'=> $var_6275,'pcid'=> $var_6275,'type_x'=>0,'type_y'=>0,'type_i'=> 1,'type'=> 'showArt','title'=> '产品特点','thumb'=> 'http://2.cnhjdy.net/assetsj/pigefanxin/art12.jpg','text'=> '这里是文章内容',);
			$var_6305=array('num' =>98,'uniacid' =>$v_1,'cid'=> $var_6275,'pcid'=> $var_6275,'type_x'=>0,'type_y'=>0,'type_i'=> 1,'type'=> 'showArt','title'=> '多种营养','thumb'=> 'http://2.cnhjdy.net/assetsj/pigefanxin/art13.jpg','text'=> '这里是文章内容',);
			$var_6306=array('num' =>98,'uniacid' =>$v_1,'cid'=> $var_6275,'pcid'=> $var_6275,'type_x'=>0,'type_y'=>0,'type_i'=> 1,'type'=> 'showArt','title'=> '六大优势','thumb'=> 'http://2.cnhjdy.net/assetsj/pigefanxin/art14.jpg','text'=> '这里是文章内容',);
			$var_175=array('num' =>97,'uniacid' =>$v_1,'cid'=> $var_6275,'pcid'=> $var_6275,'type_x'=>0,'type_y'=>0,'type_i'=> 1,'type'=> 'showArt','title'=> '品牌支持','thumb'=> 'http://2.cnhjdy.net/assetsj/pigefanxin/art15.jpg','text'=> '这里是文章内容',);
			$var_1134=array('num' =>96,'uniacid' =>$v_1,'cid'=> $var_6275,'pcid'=> $var_6275,'type_x'=>0,'type_y'=>0,'type_i'=> 1,'type'=> 'showArt','title'=> '市场分析','thumb'=> 'http://2.cnhjdy.net/assetsj/pigefanxin/art16.jpg','text'=> '这里是文章内容',);
			$var_868=array('num' =>95,'uniacid' =>$v_1,'cid'=> $var_6275,'pcid'=> $var_6275,'type_x'=>0,'type_y'=>0,'type_i'=> 1,'type'=> 'showArt','title'=> '利润分析','thumb'=> 'http://2.cnhjdy.net/assetsj/pigefanxin/art17.jpg','text'=> '这里是文章内容',);
			$var_6307=array('num' =>94,'uniacid' =>$v_1,'cid'=> $var_6275,'pcid'=> $var_6275,'type_x'=>0,'type_y'=>0,'type_i'=> 1,'type'=> 'showArt','title'=> '如何开店','thumb'=> 'http://2.cnhjdy.net/assetsj/pigefanxin/art18.jpg','text'=> '这里是文章内容',);
			$var_2267=array('num' =>93,'uniacid' =>$v_1,'cid'=> $var_6275,'pcid'=> $var_6275,'type_x'=>0,'type_y'=>0,'type_i'=> 1,'type'=> 'showArt','title'=> '代理加盟','thumb'=> 'http://2.cnhjdy.net/assetsj/pigefanxin/art19.jpg','text'=> '这里是文章内容',);
			if($var_490==0)
			{
				Db::table('ims_sudu8_page_products')->insert($var_6304);
				Db::table('ims_sudu8_page_products')->insert($var_6305);
				Db::table('ims_sudu8_page_products')->insert($var_6306);
				Db::table('ims_sudu8_page_products')->insert($var_175);
				Db::table('ims_sudu8_page_products')->insert($var_1134);
				Db::table('ims_sudu8_page_products')->insert($var_868);
				Db::table('ims_sudu8_page_products')->insert($var_6307);
				Db::table('ims_sudu8_page_products')->insert($var_2267);
			}
			else
			{
				$var_352=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showArt')->where('pcid',$var_6275)->order('id asc')->field('uniacid,id')->select();
				$var_6308=$var_352[0]['id'];
				$var_276=$var_352[1]['id'];
				$var_99=$var_352[2]['id'];
				$var_6309=$var_352[3]['id'];
				$var_6310=$var_352[4]['id'];
				$var_6311=$var_352[5]['id'];
				$var_6312=$var_352[6]['id'];
				$var_6313=$var_352[7]['id'];
				Db::table('ims_sudu8_page_products')->where('id',$var_6308)->where('uniacid',$v_1)->update($var_6304);
				Db::table('ims_sudu8_page_products')->where('id',$var_276)->where('uniacid',$v_1)->update($var_6305);
				Db::table('ims_sudu8_page_products')->where('id',$var_99)->where('uniacid',$v_1)->update($var_6306);
				Db::table('ims_sudu8_page_products')->where('id',$var_6309)->where('uniacid',$v_1)->update($var_175);
				Db::table('ims_sudu8_page_products')->where('id',$var_6310)->where('uniacid',$v_1)->update($var_1134);
				Db::table('ims_sudu8_page_products')->where('id',$var_6311)->where('uniacid',$v_1)->update($var_868);
				Db::table('ims_sudu8_page_products')->where('id',$var_6312)->where('uniacid',$v_1)->update($var_6307);
				Db::table('ims_sudu8_page_products')->where('id',$var_6313)->where('uniacid',$v_1)->update($var_2267);
			}
			$var_6259=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPro')->where('pcid',$var_6247)->order('id asc')->field('uniacid')->select();
			$var_6260=count($var_6259);
			$var_6261=array('uniacid' =>$v_1,'num' =>99,'cid'=> $var_222,'pcid'=> $var_6247,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=> 1,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'购买','price'=>350,'market_price'=>400,'pro_kc'=>100,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/pigefanxin/pro1.jpg','text'=> 'a:1:{i:0;s:57:"http://2.cnhjdy.net/assetsj/pigefanxin/pro_a1_z1.jpg";}','labels'=> '','title'=> '修皮小套装','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
			if($var_6260==0)
			{
				Db::table('ims_sudu8_page_products')->insert($var_6261);
			}
			else
			{
				$v_33=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPro')->where('pcid',$var_6247)->order('id asc')->field('uniacid,id')->select();
				$var_6314=$v_33[0]['id'];
				Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('id',$var_6314)->update($var_6261);
			}
			$v_2=array('uniacid' =>$v_1,header=>1,'tel_box'=>1,'serv_box'=>1,'content'=>'<p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p>',);
			$var_6262=Db::table('ims_sudu8_page_about')->where('uniacid',$v_1)->field('uniacid')->find();
			if(empty($var_6262['uniacid']))
			{
				Db::table('ims_sudu8_page_about')->insert($v_2);
			}
			else
			{
				Db::table('ims_sudu8_page_about')->where('uniacid',$v_1)->update($v_2);
			}
			$var_6263=array('uniacid' =>$v_1,'forms_style'=> 1,'forms_title_s'=> 'title1','forms_head'=> header,'forms_name'=> '服务预约','forms_ename'=> 'Order & Date','forms_inps'=> 0,'subtime'=> 2,'forms_btn'=> '预约','success'=> '您已预约成功！','name'=> '姓名','name_must'=> 1,'tel'=> '电话','tel_use'=> 1,'tel_must'=> 1,'wechat'=>'地址','wechat_use'=> 1,'wechat_must'=>1,'content_n'=> '需求描述','content_use'=> 1,'content_must'=> 1,);
			$var_6264=Db::table('ims_sudu8_page_forms_config')->where('uniacid',$v_1)->field('uniacid')->find();
			if(empty($var_6264['uniacid']))
			{
				Db::table('ims_sudu8_page_forms_config')->insert($var_6263);
			}
			else
			{
				Db::table('ims_sudu8_page_forms_config')->where('uniacid',$v_1)->update($var_6263);
			}
			$var_6265=array('uniacid' =>$v_1,'index_style' =>'slide','slide' =>'a:1:{i:0;s:53:"http://2.cnhjdy.net/assetsj/pigefanxin/slide.jpg";}','banner'=>'http://2.cnhjdy.net/assetsj/pigefanxin/logo_bg.jpg','logo'=>'http://2.cnhjdy.net/assetsj/pigefanxin/logo.jpg','video'=>'','v_img'=>'','name' =>'招商代理','desc'=>'招商代理','address' =>'南通世纪大道8888号',time =>'8:30 - 18:00','tel' =>15111111111,'latitude' =>31.983310,'longitude' =>120.946330,'about' =>'皮新彩，从事沙发家具维修翻新上门服务，维修材料的研发和销售，沙发家具维修技术培训！经过多年的发展，目前在上海、北京、长沙、成都、合肥等等国内80%的大城市有分部。是国内国际品牌家具售后维修的首选提供商.本公司一贯坚持专业、专心、细致、真诚的经营理念，全心全意为客户提供优质的家具维修美容服务让家具座椅日久长新完美无缺。','base_color'=> '#d40f33','base_tcolor'=> '#ffffff','base_color2'=> '#d40f33','base_color_t'=> '#ffcf3d','config'=>'a:12:{s:7:"newhead";s:1:"0";s:6:"search";s:1:"0";s:6:"bigadT";s:1:"0";s:6:"bigadC";s:1:"1";s:8:"bigadCTC";s:1:"8";s:8:"bigadCNN";s:18:"点击进入首页";s:7:"miniadT";s:1:"0";s:7:"miniadC";s:1:"0";s:7:"miniadN";s:12:"优惠活动";s:7:"miniadB";s:12:"查看详情";s:4:"copT";s:1:"9";s:8:"userFood";s:1:"0";}','index_style'=> 'slide','tel_box'=> 1,'aboutCN' =>'公司介绍','aboutCNen' =>'About Company','index_about_title' =>9,'catename_x'=> '最新客照','catenameen_x'=> 'New Photos','i_b_x_ts'=>9,'i_b_x_iw'=> 560,'catename'=>'服务项目','catenameen'=>'Services','i_b_y_ts'=> 9,'index_pro_lstyle'=> 1,'index_pro_ts_al'=>'t1','c_b_bg'=> '','c_b_btn'=> 0,'form_index'=> 0,'c_title'=> 1,'tabbar_t'=>1,'tabbar_bg'=>'#d40f33','color_bar'=>'','tabbar_tc'=>'#ffffff','tabbar_tca'=>'','tabbar'=>'a:5:{i:0;s:219:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:55:"http://2.cnhjdy.net/assetsj/pigefanxin/tabbar1.png";s:9:"tabbar_p2";s:55:"http://2.cnhjdy.net/assetsj/pigefanxin/tabbar1.png";}";i:1;s:234:"a:5:{s:8:"tabbar_l";s:1:"7";s:8:"tabbar_t";s:6:"项目";s:9:"tabbar_p1";s:55:"http://2.cnhjdy.net/assetsj/pigefanxin/tabbar2.png";s:9:"tabbar_p2";s:55:"http://2.cnhjdy.net/assetsj/pigefanxin/tabbar2.png";s:4:"type";s:1:"7";}";i:2;s:234:"a:5:{s:8:"tabbar_l";s:1:"7";s:8:"tabbar_t";s:6:"材料";s:9:"tabbar_p1";s:55:"http://2.cnhjdy.net/assetsj/pigefanxin/tabbar3.png";s:9:"tabbar_p2";s:55:"http://2.cnhjdy.net/assetsj/pigefanxin/tabbar3.png";s:4:"type";s:1:"7";}";i:3;s:218:"a:4:{s:8:"tabbar_l";s:4:"book";s:8:"tabbar_t";s:6:"预约";s:9:"tabbar_p1";s:55:"http://2.cnhjdy.net/assetsj/pigefanxin/tabbar4.png";s:9:"tabbar_p2";s:55:"http://2.cnhjdy.net/assetsj/pigefanxin/tabbar4.png";}";i:4;s:225:"a:4:{s:8:"tabbar_l";s:10:"usercenter";s:8:"tabbar_t";s:6:"我的";s:9:"tabbar_p1";s:55:"http://2.cnhjdy.net/assetsj/pigefanxin/tabbar5.png";s:9:"tabbar_p2";s:55:"http://2.cnhjdy.net/assetsj/pigefanxin/tabbar5.png";}";}',);
			$var_6266=unserialize($var_6265['slide']);
			foreach($var_6266 as $var_6267=>$var_6268)
			{
				$var_6269['appletid']=$v_1;
				$var_6269['url']=$var_6268;
				$var_6269['dateline']=time();
				Db::table('image_url')->insert($var_6269);
			}
			if(empty($var_6222['uniacid']))
			{
				Db::table('ims_sudu8_page_base')->insert($var_6265);
			}
			else
			{
				Db::table('ims_sudu8_page_base')->where('uniacid',$v_1)->update($var_6265);
			}
		}
		elseif($v_2==3)
		{
			$var_6245=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
			$var_6315=count($var_6245);
			$var_6316=array('uniacid' =>$v_1,'num' =>999,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'所有产品','ename' =>'','catepic' =>'http://2.cnhjdy.net/assetsj/jiaju/nav1.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'tc',);
			$var_6317=array('uniacid' =>$v_1,'num' =>98,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'卧室系列','ename' =>'','catepic' =>'http://2.cnhjdy.net/assetsj/jiaju/nav2.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'tc',);
			$var_905=array('uniacid' =>$v_1,'num' =>97,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'书房系列','ename' =>'','catepic' =>'http://2.cnhjdy.net/assetsj/jiaju/nav3.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'tc',);
			$var_6318=array('uniacid' =>$v_1,'num' =>96,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'阳台系列','ename' =>'','catepic' =>'http://2.cnhjdy.net/assetsj/jiaju/nav4.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'tc',);
			$var_6319=array('uniacid' =>$v_1,'num' =>95,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'客厅系列','ename' =>'','catepic' =>'http://2.cnhjdy.net/assetsj/jiaju/nav5.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'tc',);
			$var_255=array('uniacid' =>$v_1,'num' =>94,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'商务办公','ename' =>'','catepic' =>'http://2.cnhjdy.net/assetsj/jiaju/nav6.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'tc',);
			$var_6320=array('uniacid' =>$v_1,'num' =>93,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'儿童系列','ename' =>'','catepic' =>'http://2.cnhjdy.net/assetsj/jiaju/nav7.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'tc',);
			$var_6321=array('uniacid' =>$v_1,'num' =>92,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'储物系列','ename' =>'','catepic' =>'http://2.cnhjdy.net/assetsj/jiaju/nav8.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'tc',);
			if($var_6315==0)
			{
				Db::table('ims_sudu8_page_cate')->insert($var_6316);
				Db::table('ims_sudu8_page_cate')->insert($var_6317);
				Db::table('ims_sudu8_page_cate')->insert($var_905);
				Db::table('ims_sudu8_page_cate')->insert($var_6318);
				Db::table('ims_sudu8_page_cate')->insert($var_6319);
				Db::table('ims_sudu8_page_cate')->insert($var_255);
				Db::table('ims_sudu8_page_cate')->insert($var_6320);
				Db::table('ims_sudu8_page_cate')->insert($var_6321);
				$var_6322=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
				$var_6323=$var_6322[0]['id'];
				$var_6324=$var_6322[1]['id'];
				$var_6325=$var_6322[2]['id'];
				$var_6326=$var_6322[3]['id'];
				$var_849=$var_6322[4]['id'];
				$var_137=$var_6322[5]['id'];
				$var_6327=$var_6322[6]['id'];
				$var_6328=$var_6322[7]['id'];
			}
			else
			{
				$var_6322=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
				$var_6323=$var_6322[0]['id'];
				$var_6324=$var_6322[1]['id'];
				$var_6325=$var_6322[2]['id'];
				$var_6326=$var_6322[3]['id'];
				$var_849=$var_6322[4]['id'];
				$var_137=$var_6322[5]['id'];
				$var_6327=$var_6322[6]['id'];
				$var_6328=$var_6322[7]['id'];
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6323)->update($var_6316);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6324)->update($var_6317);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6325)->update($var_905);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6326)->update($var_6318);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_849)->update($var_6319);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_137)->update($var_255);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6327)->update($var_6320);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6328)->update($var_6321);
			}
			$var_6237=Db::table('ims_sudu8_page_navlist')->where('uniacid',$v_1)->field('uniacid,id')->select();
			$var_6238=array('uniacid' =>$v_1,'num' =>99,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/jiaju/nav1.png','title' =>'所有产品','url' =>'/sudu8_page/listPro/listPro?cid='.$var_6323,);
			$var_486=array('uniacid' =>$v_1,'num' =>98,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/jiaju/nav2.png','title' =>'卧室系列','url' =>'/sudu8_page/listPro/listPro?cid='.$var_6324,);
			$var_6239=array('uniacid' =>$v_1,'num' =>97,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/jiaju/nav3.png','title' =>'书房系列','url' =>'/sudu8_page/listPro/listPro?cid='.$var_6325,);
			$var_6240=array('uniacid' =>$v_1,'num' =>96,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/jiaju/nav4.png','title' =>'阳台系列','url' =>'/sudu8_page/listPro/listPro?cid='.$var_6326,);
			$var_6329=array('uniacid' =>$v_1,'num' =>95,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/jiaju/nav5.png','title' =>'客厅系列','url' =>'/sudu8_page/listPro/listPro?cid='.$var_849,);
			$var_6330=array('uniacid' =>$v_1,'num' =>94,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/jiaju/nav6.png','title' =>'商务办公','url' =>'/sudu8_page/listPro/listPro?cid='.$var_137,);
			$var_6331=array('uniacid' =>$v_1,'num' =>93,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/jiaju/nav7.png','title' =>'儿童系列','url' =>'/sudu8_page/listPro/listPro?cid='.$var_6327,);
			$var_6332=array('uniacid' =>$v_1,'num' =>92,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/jiaju/nav8.png','title' =>'储物系列','url' =>'/sudu8_page/listPro/listPro?cid='.$var_6328,);
			if(empty($var_6237))
			{
				Db::table('ims_sudu8_page_navlist')->insert($var_6238);
				Db::table('ims_sudu8_page_navlist')->insert($var_486);
				Db::table('ims_sudu8_page_navlist')->insert($var_6239);
				Db::table('ims_sudu8_page_navlist')->insert($var_6240);
				Db::table('ims_sudu8_page_navlist')->insert($var_6329);
				Db::table('ims_sudu8_page_navlist')->insert($var_6330);
				Db::table('ims_sudu8_page_navlist')->insert($var_6331);
				Db::table('ims_sudu8_page_navlist')->insert($var_6332);
			}
			else
			{
				$var_6237=Db::table('ims_sudu8_page_navlist')->where('uniacid',$v_1)->field('uniacid,id')->select();
				$var_375=$var_6237[0]['id'];
				$var_6241=$var_6237[1]['id'];
				$var_6242=$var_6237[2]['id'];
				$var_321=$var_6237[3]['id'];
				$var_6333=$var_6237[4]['id'];
				$var_6334=$var_6237[5]['id'];
				$var_6335=$var_6237[6]['id'];
				$var_6336=$var_6237[7]['id'];
				Db::table('ims_sudu8_page_navlist')->where('id',$var_375)->where('uniacid',$v_1)->update($var_6238);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_6241)->where('uniacid',$v_1)->update($var_486);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_6242)->where('uniacid',$v_1)->update($var_6239);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_321)->where('uniacid',$v_1)->update($var_6240);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_6333)->where('uniacid',$v_1)->update($var_6329);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_6334)->where('uniacid',$v_1)->update($var_6330);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_6335)->where('uniacid',$v_1)->update($var_6331);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_6336)->where('uniacid',$v_1)->update($var_6332);
			}
			$var_1212=array('url'=> '','uniacid' =>$v_1,'statue'=>2,'name_s'=>1,'box_p_tb'=>2,'box_p_lr'=>1,'number'=>4,'img_size'=>80,'title_position'=>0,);
			$var_6243=Db::table('ims_sudu8_page_nav')->where('uniacid',$v_1)->field('uniacid')->find();
			if(empty($var_6243['uniacid']))
			{
				Db::table('ims_sudu8_page_nav')->insert($var_1212);
			}
			else
			{
				Db::table('ims_sudu8_page_nav')->where('uniacid',$v_1)->update($var_1212);
			}
			$var_240=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPro')->where('pcid',$var_6323)->order('id asc')->field('uniacid,id')->select();
			$var_6337=count($var_240);
			if($var_6337==0)
			{
				$var_6261=array('uniacid' =>$v_1,'num' =>99,'cid'=> $var_6323,'pcid'=> $var_6323,'type'=> 'showPro','type_x'=>1,'type_y'=>0,'type_i'=> 0,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'购买','price'=>568,'market_price'=>589,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/jiaju/pro1.jpg','text'=> 'a:1:{i:0;s:47:"http://2.cnhjdy.net/assetsj/jiaju/pro1.jpg";}','labels'=> '','title'=> '床垫','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				$var_815=array('uniacid' =>$v_1,'num' =>98,'cid'=> $var_6323,'pcid'=> $var_6323,'type'=> 'showPro','type_x'=>0,'type_y'=>1,'type_i'=> 0,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'购买','price'=>158,'market_price'=>189,'pro_kc'=>500,'pro_xz'=>1,'thumb'=> 'http://2.cnhjdy.net/assetsj/jiaju/pro5.jpg','text'=> 'a:1:{i:0;s:47:"http://2.cnhjdy.net/assetsj/jiaju/pro5.jpg";}','labels'=> '床垫全棉床垫床褥1.8m双人垫被褥子1.2单人防滑0.9','title'=> '床垫全棉床垫床褥1.8m双人垫被褥子1.2单人防滑0.9','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				$var_6338=array('uniacid' =>$v_1,'num' =>97,'cid'=> $var_6323,'pcid'=> $var_6323,'type'=> 'showPro','type_x'=>0,'type_y'=>1,'type_i'=> 0,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'购买','price'=>568,'market_price'=>589,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/jiaju/pro1.jpg','text'=> 'a:1:{i:0;s:47:"http://2.cnhjdy.net/assetsj/jiaju/pro1.jpg";}','labels'=> '床垫1.5m加厚1.8m记忆棉海绵席梦思单人1.2m床褥子','title'=> '床垫1.5m加厚1.8m记忆棉海绵席梦思单人1.2m床褥子','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				Db::table('ims_sudu8_page_products')->insert($var_6261);
				Db::table('ims_sudu8_page_products')->insert($var_815);
				Db::table('ims_sudu8_page_products')->insert($var_6338);
			}
			$var_6339=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPro')->where('pcid',$var_6324)->order('id asc')->field('uniacid,id')->select();
			$var_459=count($var_6339);
			if($var_459==0)
			{
				$var_6261=array('uniacid' =>$v_1,'num' =>97,'cid'=> $var_6324,'pcid'=> $var_6324,'type'=> 'showPro','type_x'=>1,'type_y'=>0,'type_i'=> 0,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'购买','price'=>568,'market_price'=>589,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/jiaju/pro2.jpg','text'=> 'a:1:{i:0;s:47:"http://2.cnhjdy.net/assetsj/jiaju/pro2.jpg";}','labels'=> '','title'=> '床垫','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				Db::table('ims_sudu8_page_products')->insert($var_6261);
			}
			$var_6340=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPro')->where('pcid',$var_6326)->order('id asc')->field('uniacid,id')->select();
			$var_6341=count($var_6340);
			if($var_6341==0)
			{
				$var_6261=array('uniacid' =>$v_1,'num' =>96,'cid'=> $var_6326,'pcid'=> $var_6326,'type'=> 'showPro','type_x'=>1,'type_y'=>0,'type_i'=> 0,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'购买','price'=>568,'market_price'=>589,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/jiaju/pro3.jpg','text'=> 'a:1:{i:0;s:47:"http://2.cnhjdy.net/assetsj/jiaju/pro3.jpg";}','labels'=> '','title'=> '床垫','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				Db::table('ims_sudu8_page_products')->insert($var_6261);
			}
			$var_6342=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPro')->where('pcid',$var_849)->order('id asc')->field('uniacid,id')->select();
			$var_1849=count($var_6342);
			if($var_1849==0)
			{
				$var_6261=array('uniacid' =>$v_1,'num' =>96,'cid'=> $var_849,'pcid'=> $var_849,'type'=> 'showPro','type_x'=>0,'type_y'=>1,'type_i'=>0,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'购买','price'=>568,'market_price'=>589,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/jiaju/pro3.jpg','text'=> 'a:1:{i:0;s:47:"http://2.cnhjdy.net/assetsj/jiaju/pro3.jpg";}','labels'=> '床垫1.5m加厚1.8m记忆棉海绵席梦思单人1.2m床褥子','title'=> '床垫1.5m加厚1.8m记忆棉海绵席梦思单人1.2m床褥子','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				Db::table('ims_sudu8_page_products')->insert($var_6261);
			}
			$var_6343=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPro')->where('pcid',$var_6328)->order('id asc')->field('uniacid,id')->select();
			$var_6344=count($var_6343);
			if($var_6344==0)
			{
				$var_6261=array('uniacid' =>$v_1,'num' =>96,'cid'=> $var_6328,'pcid'=> $var_6328,'type'=> 'showPro','type_x'=>0,'type_y'=>1,'type_i'=>0,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'购买','price'=>568,'market_price'=>589,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/jiaju/pro4.jpg','text'=> 'a:1:{i:0;s:47:"http://2.cnhjdy.net/assetsj/jiaju/pro4.jpg";}','labels'=> '床垫1.5m加厚1.8m记忆棉海绵席梦思单人1.2m床褥子','title'=> '床垫1.5m加厚1.8m记忆棉海绵席梦思单人1.2m床褥子','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				Db::table('ims_sudu8_page_products')->insert($var_6261);
			}
			$var_6265=array('uniacid' =>$v_1,'index_style' =>'slide','slide' =>'a:2:{i:0;s:49:"http://2.cnhjdy.net/assetsj/jiaju/slide1.jpg";i:1;s:49:"http://2.cnhjdy.net/assetsj/jiaju/slide2.jpg";}','video'=>'','v_img'=>'','name' =>'家居馆','desc'=>'家居销售','address' =>'南通世纪大道8888号',time =>'8:30 - 18:00','tel' =>15111111111,'latitude' =>31.983310,'longitude' =>120.946330,'about' =>'家居销售','base_color'=> '#ad9f98','base_tcolor'=> '#ffffff','base_color2'=> '#ad9f98','base_color_t'=> '#ffcf3d','config'=>'a:12:{s:7:"newhead";s:1:"0";s:6:"search";s:1:"0";s:6:"bigadT";s:1:"1";s:6:"bigadC";s:1:"1";s:8:"bigadCTC";s:1:"3";s:8:"bigadCNN";s:18:"点击进入首页";s:7:"miniadT";s:1:"1";s:7:"miniadC";s:1:"0";s:7:"miniadN";s:12:"点击进入";s:7:"miniadB";s:12:"点击进入";s:4:"copT";s:1:"9";s:8:"userFood";s:1:"0";}','index_style'=> 'slide','tel_box'=> 0,'aboutCN' =>'公司介绍','aboutCNen' =>'About Company','index_about_title' =>9,'catename_x'=> '推荐专区','catenameen_x'=> '','i_b_x_ts'=>2,'i_b_x_iw'=> 600,'catename'=>'热销产品','catenameen'=>'','i_b_y_ts'=> 2,'index_pro_lstyle'=> 2,'index_pro_ts_al'=>'t1','c_b_bg'=> '','c_b_btn'=> 0,'form_index'=> 0,'c_title'=> 0,'tabbar_t'=>1,'tabbar_bg'=>'#ffffff','color_bar'=>'#2222222','tabbar_tc'=>'#2222222','tabbar_tca'=>222222,'tabbar'=>'a:4:{i:0;s:209:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:50:"http://2.cnhjdy.net/assetsj/jiaju/tabbar1.png";s:9:"tabbar_p2";s:50:"http://2.cnhjdy.net/assetsj/jiaju/tabbar1.png";}";i:1;s:207:"a:4:{s:8:"tabbar_l";s:3:"tel";s:8:"tabbar_t";s:6:"电话";s:9:"tabbar_p1";s:50:"http://2.cnhjdy.net/assetsj/jiaju/tabbar2.png";s:9:"tabbar_p2";s:50:"http://2.cnhjdy.net/assetsj/jiaju/tabbar2.png";}";i:2;s:207:"a:4:{s:8:"tabbar_l";s:3:"map";s:8:"tabbar_t";s:6:"导航";s:9:"tabbar_p1";s:50:"http://2.cnhjdy.net/assetsj/jiaju/tabbar3.png";s:9:"tabbar_p2";s:50:"http://2.cnhjdy.net/assetsj/jiaju/tabbar3.png";}";i:3;s:222:"a:4:{s:8:"tabbar_l";s:10:"usercenter";s:8:"tabbar_t";s:12:"个人中心";s:9:"tabbar_p1";s:50:"http://2.cnhjdy.net/assetsj/jiaju/tabbar4.png";s:9:"tabbar_p2";s:50:"http://2.cnhjdy.net/assetsj/jiaju/tabbar4.png";}";}',);
			$var_6266=unserialize($var_6265['slide']);
			foreach($var_6266 as $var_6267=>$var_6268)
			{
				$var_6269['appletid']=$v_1;
				$var_6269['url']=$var_6268;
				$var_6269['dateline']=time();
				Db::table('image_url')->insert($var_6269);
			}
			if(empty($var_6222['uniacid']))
			{
				Db::table('ims_sudu8_page_base')->insert($var_6265);
			}
			else
			{
				Db::table('ims_sudu8_page_base')->where('uniacid',$v_1)->update($var_6265);
			}
			$var_6345=Db::table('ims_sudu8_page_banner')->where('uniacid',$v_1)->where('type','bigad')->field('uniacid,id')->find();
			$var_6346=array('uniacid' =>$v_1,'num'=>99,'type'=> 'bigad','pic'=>'http://2.cnhjdy.net/assetsj/jiaju/kaipin.png','url'=>'','flag'=>1,'descp'=>'',);
			if(empty($var_6345))
			{
				Db::table('ims_sudu8_page_banner')->insert($var_6346);
			}
			else
			{
				Db::table('ims_sudu8_page_banner')->where('uniacid',$v_1)->where('type','bigad')->update($var_6346);
			}
			$var_628=Db::table('ims_sudu8_page_banner')->where('uniacid',$v_1)->where('type','miniad')->field('uniacid,id')->find();
			$var_6347=array('uniacid' =>$v_1,'num'=>99,'type'=> 'miniad','flag'=>1,'pic'=>'http://2.cnhjdy.net/assetsj/jiaju/tanchuang.jpg','url'=>'/sudu8_page/listPro/listPro?cid='.$var_6323,'descp'=>'全部产品',);
			if(empty($var_628))
			{
				Db::table('ims_sudu8_page_banner')->insert($var_6347);
			}
			else
			{
				Db::table('ims_sudu8_page_banner')->where('uniacid',$v_1)->where('type','miniad')->update($var_6347);
			}
		}
		elseif($v_2==4)
		{
			$var_6245=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
			$var_6315=count($var_6245);
			$var_6316=array('uniacid' =>$v_1,'num' =>999,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'东方风神系列','ename' =>'FengShen','catepic' =>'','cdesc' =>'','show_i' =>1,'list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'tc',);
			$var_6317=array('uniacid' =>$v_1,'num' =>98,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'奇瑞汽车','ename' =>'CHERY','catepic' =>'','cdesc' =>'','show_i' =>1,'list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'tc',);
			if($var_6315==0)
			{
				Db::table('ims_sudu8_page_cate')->insert($var_6316);
				Db::table('ims_sudu8_page_cate')->insert($var_6317);
				$var_6322=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
				$var_6323=$var_6322[0]['id'];
				$var_6324=$var_6322[1]['id'];
			}
			else
			{
				$var_6322=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
				$var_6323=$var_6322[0]['id'];
				$var_6324=$var_6322[1]['id'];
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6323)->update($var_6316);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6324)->update($var_6317);
			}
			$var_240=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPro')->where('pcid',$var_6323)->order('id asc')->field('uniacid,id')->select();
			$var_6337=count($var_240);
			if($var_6337==0)
			{
				$var_6261=array('uniacid' =>$v_1,'num' =>99,'cid'=> $var_6323,'pcid'=> $var_6323,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=> 1,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>99700,'market_price'=>99700,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/qiche/pro1.jpg','text'=> 'a:1:{i:0;s:47:"http://2.cnhjdy.net/assetsj/qiche/pro1.jpg";}','labels'=> '风神AX7','title'=> '东风风神AX7','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				$var_815=array('uniacid' =>$v_1,'num' =>98,'cid'=> $var_6323,'pcid'=> $var_6323,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=> 1,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>99700,'market_price'=>99700,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/qiche/pro2.jpg','text'=> 'a:1:{i:0;s:47:"http://2.cnhjdy.net/assetsj/qiche/pro2.jpg";}','labels'=> '风神AX5','title'=> '东风风神AX5 新车','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				Db::table('ims_sudu8_page_products')->insert($var_6261);
				Db::table('ims_sudu8_page_products')->insert($var_815);
			}
			$var_6339=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPro')->where('pcid',$var_6324)->order('id asc')->field('uniacid,id')->select();
			$var_459=count($var_6339);
			if($var_459==0)
			{
				$var_6261=array('uniacid' =>$v_1,'num' =>99,'cid'=> $var_6324,'pcid'=> $var_6324,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=> 1,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>99700,'market_price'=>99700,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/qiche/pro3.jpg','text'=> 'a:1:{i:0;s:47:"http://2.cnhjdy.net/assetsj/qiche/pro3.jpg";}','labels'=> '瑞虎5x','title'=> '奇瑞汽车瑞虎5x ','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				$var_815=array('uniacid' =>$v_1,'num' =>98,'cid'=> $var_6324,'pcid'=> $var_6324,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=> 1,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>99700,'market_price'=>99700,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/qiche/pro4.jpg','text'=> 'a:1:{i:0;s:47:"http://2.cnhjdy.net/assetsj/qiche/pro4.jpg";}','labels'=> '瑞虎7,2018款','title'=> '奇瑞汽车 瑞虎7 2018款','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				Db::table('ims_sudu8_page_products')->insert($var_6261);
				Db::table('ims_sudu8_page_products')->insert($var_815);
			}
			$var_6287=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','page')->where('cid',0)->order('id asc')->field('uniacid,id')->find();
			$var_956=array('uniacid' =>$v_1,'num' =>96,'type' =>'page','statue' =>1,'cid' =>0,'name' =>'汽车维修','ename' =>'Car Maintenance','catepic' =>'http://2.cnhjdy.net/assetsj/qiche/page1.jpg','cdesc' =>'维修项目：故障检测 机修 电器 钣金油漆。各类车型配件齐全，原厂正品，高效便捷，精益求精！','show_i' =>1,'list_style' =>3,'list_tstyle' =>0,'list_tstylel' =>2,'list_type' =>1,'content' =>'此处是栏目内容',);
			$var_243=array('uniacid' =>$v_1,'num' =>95,'type' =>'page','statue' =>1,'cid' =>0,'name' =>'汽车美容','ename' =>'Car Cosmetology','catepic' =>'http://2.cnhjdy.net/assetsj/qiche/page2.jpg','cdesc' =>'美容项目：封釉 打蜡 抛光 贴膜 清洗 ','show_i' =>1,'list_style' =>3,'list_tstyle' =>0,'list_tstylel' =>2,'list_type' =>1,'content' =>'此处是栏目内容',);
			if(empty($var_6287['uniacid']))
			{
				Db::table('ims_sudu8_page_cate')->insert($var_956);
				Db::table('ims_sudu8_page_cate')->insert($var_243);
				$var_6288=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','page')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
				$var_6289=$var_6288[0]['id'];
				$var_6290=$var_6288[1]['id'];
			}
			else
			{
				$var_6288=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','page')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
				$var_6289=$var_6288[0]['id'];
				$var_6290=$var_6288[1]['id'];
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6289)->update($var_956);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6290)->update($var_243);
			}
			$v_2=array('uniacid' =>$v_1,header=>1,'tel_box'=>1,'serv_box'=>1,'content'=>'<p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p>',);
			$var_6262=Db::table('ims_sudu8_page_about')->where('uniacid',$v_1)->field('uniacid')->find();
			if(empty($var_6262['uniacid']))
			{
				Db::table('ims_sudu8_page_about')->insert($v_2);
			}
			else
			{
				Db::table('ims_sudu8_page_about')->where('uniacid',$v_1)->update($v_2);
			}
			$var_6263=array('uniacid' =>$v_1,'forms_style'=> 1,'forms_title_s'=> 'title1','forms_head'=> header,'forms_name'=> '看车预约','forms_ename'=> '','forms_inps'=> 0,'subtime'=> 2,'forms_btn'=> '预约','success'=> '您已预约成功！','name'=> '姓名','name_must'=> 1,'tel'=> '电话','tel_use'=> 1,'tel_must'=> 1,'wechat'=>'预算','wechat_use'=> 1,'wechat_must'=>1,'single_n'=>'意向品牌','single_num'=>3,'single_use'=>1,'single_must'=>1,'single_v'=>'东方汽车,奇瑞汽车','content_n'=> '需求描述','content_use'=> 1,'content_must'=> 1,);
			$var_6264=Db::table('ims_sudu8_page_forms_config')->where('uniacid',$v_1)->field('uniacid')->find();
			if(empty($var_6264['uniacid']))
			{
				Db::table('ims_sudu8_page_forms_config')->insert($var_6263);
			}
			else
			{
				Db::table('ims_sudu8_page_forms_config')->where('uniacid',$v_1)->update($var_6263);
			}
			$var_6265=array('uniacid' =>$v_1,'index_style' =>'slide','slide' =>'a:2:{i:0;s:49:"http://2.cnhjdy.net/assetsj/qiche/slide1.jpg";i:1;s:49:"http://2.cnhjdy.net/assetsj/qiche/slide3.jpg";}','banner'=>'http://2.cnhjdy.net/assetsj/qiche/logo_bg.jpg','logo'=>'http://2.cnhjdy.net/assetsj/qiche/logo.jpg','video'=>'1.mp4','v_img'=>'http://2.cnhjdy.net/assetsj/qiche/video.jpg','name' =>'某某汽车','desc'=>'东风风神汽车 奇瑞汽车 汽车维修美容','address' =>'南通世纪大道8888号',time =>'8:30 - 18:00','tel' =>15111111111,'latitude' =>31.983310,'longitude' =>120.946330,'about' =>'某某汽车销售服务有限公司，是汽车维护服务专业机构，创办于2014年4月， 经营场所：南通世纪大道8888号。主要经营东风风神汽车销售及各类车辆维修服务。各类车型配件齐全，原厂正品，高效便捷，精益求精！ ','base_color'=> '#4e73f6','base_tcolor'=> '#ffffff','base_color2'=> '#4e73f6','base_color_t'=> '#ffcf3d','config'=>'a:12:{s:7:"newhead";s:1:"0";s:6:"search";s:1:"0";s:6:"bigadT";s:1:"0";s:6:"bigadC";s:1:"0";s:8:"bigadCTC";s:1:"3";s:8:"bigadCNN";s:18:"点击进入首页";s:7:"miniadT";s:1:"0";s:7:"miniadC";s:1:"0";s:7:"miniadN";s:12:"点击进入";s:7:"miniadB";s:12:"点击进入";s:4:"copT";s:1:"9";s:8:"userFood";s:1:"0";}','index_style'=> 'slide','tel_box'=> 1,'aboutCN' =>'门店介绍','aboutCNen' =>'About Us','index_about_title' =>'title1','catename_x'=> '推荐专区','catenameen_x'=> '','i_b_x_ts'=>9,'i_b_x_iw'=> 600,'catename'=>'热销产品','catenameen'=>'','i_b_y_ts'=> 9,'index_pro_lstyle'=> 2,'index_pro_ts_al'=>'t1','c_b_bg'=> 'http://2.cnhjdy.net/assetsj/qiche/server.jpg','c_b_btn'=> 1,'form_index'=> 0,'c_title'=> 0,'tabbar_t'=>1,'tabbar_bg'=>'#4e73f6','color_bar'=>'#4e73f6','tabbar_tc'=>'#ffffff','tabbar_tca'=>'#ffffff','tabbar'=>'a:4:{i:0;s:209:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:50:"http://2.cnhjdy.net/assetsj/qiche/tabbar1.png";s:9:"tabbar_p2";s:50:"http://2.cnhjdy.net/assetsj/qiche/tabbar1.png";}";i:1;s:215:"a:4:{s:8:"tabbar_l";s:4:"book";s:8:"tabbar_t";s:12:"看车预约";s:9:"tabbar_p1";s:50:"http://2.cnhjdy.net/assetsj/qiche/tabbar2.png";s:9:"tabbar_p2";s:50:"http://2.cnhjdy.net/assetsj/qiche/tabbar2.png";}";i:2;s:214:"a:4:{s:8:"tabbar_l";s:3:"tel";s:8:"tabbar_t";s:12:"联系电话";s:9:"tabbar_p1";s:50:"http://2.cnhjdy.net/assetsj/qiche/tabbar3.png";s:9:"tabbar_p2";s:50:"http://2.cnhjdy.net/assetsj/qiche/tabbar3.png";}";i:3;s:214:"a:4:{s:8:"tabbar_l";s:3:"map";s:8:"tabbar_t";s:12:"一键导航";s:9:"tabbar_p1";s:50:"http://2.cnhjdy.net/assetsj/qiche/tabbar4.png";s:9:"tabbar_p2";s:50:"http://2.cnhjdy.net/assetsj/qiche/tabbar4.png";}";}',);
			$var_6266=unserialize($var_6265['slide']);
			foreach($var_6266 as $var_6267=>$var_6268)
			{
				$var_6269['appletid']=$v_1;
				$var_6269['url']=$var_6268;
				$var_6269['dateline']=time();
				Db::table('image_url')->insert($var_6269);
			}
			if(empty($var_6222['uniacid']))
			{
				Db::table('ims_sudu8_page_base')->insert($var_6265);
			}
			else
			{
				Db::table('ims_sudu8_page_base')->where('uniacid',$v_1)->update($var_6265);
			}
		}
		elseif($v_2==5)
		{
			$var_1203=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showArt')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
			$var_6244=array('uniacid' =>$v_1,'num' =>999,'type' =>'showArt','statue' =>1,'cid' =>0,'name' =>'导航','ename' =>'','catepic' =>'','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>0,'list_type' =>1,'list_style' =>6,'list_stylet' =>'tc','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"0";s:4:"ptit";s:1:"3";}',);
			if(empty($var_6348['uniacid']))
			{
				Db::table('ims_sudu8_page_cate')->insert($var_6244);
			}
			else
			{
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6348[0]['id'])->update($var_6244);
			}
			$var_6244=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showArt')->where('cid',0)->order('id asc')->field('uniacid,id')->find();
			$var_2345=$var_6244['id'];
			$var_460=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showArt')->where('cid',$var_2345)->order('id asc')->field('uniacid,id')->select();
			$var_6349=count($var_460);
			if($var_6349==0)
			{
				$var_6350=array('uniacid' =>$v_1,'num' =>98,'type' =>'showArt','statue' =>1,'cid' =>$var_2345,'name' =>'楼盘点评','ename' =>'','catepic'=>'http://2.cnhjdy.net/assetsj/fangchan/nav1.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>0,'list_type' =>1,'list_style' =>3,'list_stylet' =>'none','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"0";s:4:"ptit";s:1:"3";}',);
				$var_6351=array('uniacid' =>$v_1,'num' =>97,'type' =>'showArt','statue' =>1,'cid' =>$var_2345,'name' =>'买房攻略','ename' =>'','catepic'=>'http://2.cnhjdy.net/assetsj/fangchan/nav2.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>0,'list_type' =>1,'list_style' =>3,'list_stylet' =>'none','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"0";s:4:"ptit";s:1:"3";}',);
				$var_2451=array('uniacid' =>$v_1,'num' =>96,'type' =>'showArt','statue' =>1,'cid' =>$var_2345,'name' =>'玩转威海','ename' =>'','catepic'=>'http://2.cnhjdy.net/assetsj/fangchan/nav3.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>0,'list_type' =>1,'list_style' =>3,'list_stylet' =>'none','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"0";s:4:"ptit";s:1:"3";}',);
				$var_6352=array('uniacid' =>$v_1,'num' =>96,'type' =>'showArt','statue' =>1,'cid' =>$var_2345,'name' =>'装修推荐','ename' =>'','catepic'=>'http://2.cnhjdy.net/assetsj/fangchan/nav4.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>0,'list_type' =>1,'list_style' =>3,'list_stylet' =>'none','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"0";s:4:"ptit";s:1:"3";}',);
				$var_6353=array('uniacid' =>$v_1,'num' =>96,'type' =>'showArt','statue' =>1,'cid' =>$var_2345,'name' =>'新盘介绍','ename' =>'','catepic'=>'http://2.cnhjdy.net/assetsj/fangchan/nav5.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>0,'list_type' =>1,'list_style' =>3,'list_stylet' =>'none','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"0";s:4:"ptit";s:1:"3";}',);
				$var_6354=array('uniacid' =>$v_1,'num' =>96,'type' =>'showArt','statue' =>1,'cid' =>$var_2345,'name' =>'租房房源','ename' =>'','catepic'=>'http://2.cnhjdy.net/assetsj/fangchan/nav6.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>0,'list_type' =>1,'list_style' =>3,'list_stylet' =>'none','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"0";s:4:"ptit";s:1:"3";}',);
				$var_6355=array('uniacid' =>$v_1,'num' =>96,'type' =>'showArt','statue' =>1,'cid' =>$var_2345,'name' =>'二手房源','ename' =>'','catepic'=>'http://2.cnhjdy.net/assetsj/fangchan/nav7.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>0,'list_type' =>1,'list_style' =>3,'list_stylet' =>'none','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"0";s:4:"ptit";s:1:"3";}',);
				$var_6356=array('uniacid' =>$v_1,'num' =>96,'type' =>'showArt','statue' =>1,'cid' =>$var_2345,'name' =>'关于我们','ename' =>'','catepic'=>'http://2.cnhjdy.net/assetsj/fangchan/nav8.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>0,'list_type' =>1,'list_style' =>3,'list_stylet' =>'none','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"0";s:4:"ptit";s:1:"3";}',);
				Db::table('ims_sudu8_page_cate')->insert($var_6350);
				Db::table('ims_sudu8_page_cate')->insert($var_6351);
				Db::table('ims_sudu8_page_cate')->insert($var_2451);
				Db::table('ims_sudu8_page_cate')->insert($var_6352);
				Db::table('ims_sudu8_page_cate')->insert($var_6353);
				Db::table('ims_sudu8_page_cate')->insert($var_6354);
				Db::table('ims_sudu8_page_cate')->insert($var_6355);
				Db::table('ims_sudu8_page_cate')->insert($var_6356);
				$var_1475=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showArt')->where('cid','neq',0)->order('id asc')->field('uniacid,id')->select();
				$var_6357=$var_1475[0]['id'];
				$var_6358=$var_1475[1]['id'];
				$var_6359=$var_1475[2]['id'];
				$var_6360=$var_1475[3]['id'];
				$var_6361=$var_1475[4]['id'];
				$var_6362=$var_1475[5]['id'];
				$var_6363=$var_1475[6]['id'];
				$var_6364=$var_1475[7]['id'];
			}
			else
			{
				$var_1475=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showArt')->where('cid','neq',0)->order('id asc')->field('uniacid,id')->select();
				$var_6357=$var_1475[0]['id'];
				$var_6358=$var_1475[1]['id'];
				$var_6359=$var_1475[2]['id'];
				$var_6360=$var_1475[3]['id'];
				$var_6361=$var_1475[4]['id'];
				$var_6362=$var_1475[5]['id'];
				$var_6363=$var_1475[6]['id'];
				$var_6364=$var_1475[7]['id'];
			}
			$var_6254=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showArt')->where('pcid',$var_2345)->order('id asc')->field('uniacid,id')->select();
			$var_6255=count($var_6254);
			if($var_6255==0)
			{
				$var_6256=array('uniacid' =>$v_1,'num'=>999,'cid'=> $var_6357,'pcid'=> $var_2345,'type'=> 'showArt','type_y'=> 1,'title'=> '威海天恒龙泽府','thumb'=> 'http://2.cnhjdy.net/assetsj/fangchan/art1.jpg','desc'=> '这里是文章内容文章简介','text'=> '这里是文章内容',);
				$var_6257=array('uniacid' =>$v_1,'num'=>99,'cid'=> $var_6357,'pcid'=> $var_2345,'type'=> 'showArt','type_y'=> 1,'title'=> '威海华夏山海城','thumb'=> 'http://2.cnhjdy.net/assetsj/fangchan/art2.jpg','desc'=> '这里是文章内容文章简介','text'=> '这里是文章内容',);
				$var_6258=array('uniacid' =>$v_1,'cid'=> $var_6357,'pcid'=> $var_2345,'type'=> 'showArt','type_y'=> 1,'title'=> '威海保利·红叶谷','thumb'=> 'http://2.cnhjdy.net/assetsj/fangchan/art3.jpg','desc'=> '这里是文章内容文章简介','text'=> '这里是文章内容',);
				$var_729=array('uniacid' =>$v_1,'cid'=> $var_6357,'pcid'=> $var_2345,'type'=> 'showArt','type_y'=> 1,'title'=> ' 威海荣成凤凰湖','thumb'=> 'http://2.cnhjdy.net/assetsj/fangchan/art4.jpg','desc'=> '这里是文章内容文章简介','text'=> '这里是文章内容',);
				Db::table('ims_sudu8_page_products')->insert($var_6256);
				Db::table('ims_sudu8_page_products')->insert($var_6257);
				Db::table('ims_sudu8_page_products')->insert($var_6258);
				Db::table('ims_sudu8_page_products')->insert($var_729);
			}
			$var_6237=Db::table('ims_sudu8_page_navlist')->where('uniacid',$v_1)->field('uniacid,id')->select();
			$var_6238=array('uniacid' =>$v_1,'num' =>99,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/fangchan/nav1.png','title' =>'楼盘点评','url' =>'/sudu8_page/listPic/listPic?cid='.$var_6357,);
			$var_486=array('uniacid' =>$v_1,'num' =>98,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/fangchan/nav2.png','title' =>'买房攻略','url' =>'/sudu8_page/listPic/listPic?cid='.$var_6358,);
			$var_6239=array('uniacid' =>$v_1,'num' =>97,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/fangchan/nav3.png','title' =>'玩转威海','url' =>'/sudu8_page/listPic/listPic?cid='.$var_6359,);
			$var_6240=array('uniacid' =>$v_1,'num' =>96,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/fangchan/nav4.png','title' =>'装修推荐','url' =>'/sudu8_page/listPic/listPic?cid='.$var_6360,);
			$var_6329=array('uniacid' =>$v_1,'num' =>95,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/fangchan/nav5.png','title' =>'新盘介绍','url' =>'/sudu8_page/listPic/listPic?cid='.$var_6361,);
			$var_6330=array('uniacid' =>$v_1,'num' =>94,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/fangchan/nav6.png','title' =>'租房房源','url' =>'/sudu8_page/listPic/listPic?cid='.$var_6362,);
			$var_6331=array('uniacid' =>$v_1,'num' =>93,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/fangchan/nav7.png','title' =>'二手房源','url' =>'/sudu8_page/listPic/listPic?cid='.$var_6363,);
			$var_6332=array('uniacid' =>$v_1,'num' =>92,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/fangchan/nav8.png','title' =>'关于我们','url' =>'/sudu8_page/listPic/listPic?cid='.$var_6364,);
			if(empty($var_6237))
			{
				Db::table('ims_sudu8_page_navlist')->insert($var_6238);
				Db::table('ims_sudu8_page_navlist')->insert($var_486);
				Db::table('ims_sudu8_page_navlist')->insert($var_6239);
				Db::table('ims_sudu8_page_navlist')->insert($var_6240);
				Db::table('ims_sudu8_page_navlist')->insert($var_6329);
				Db::table('ims_sudu8_page_navlist')->insert($var_6330);
				Db::table('ims_sudu8_page_navlist')->insert($var_6331);
				Db::table('ims_sudu8_page_navlist')->insert($var_6332);
			}
			else
			{
				$var_6237=Db::table('ims_sudu8_page_navlist')->where('uniacid',$v_1)->field('uniacid,id')->select();
				$var_375=$var_6237[0]['id'];
				$var_6241=$var_6237[1]['id'];
				$var_6242=$var_6237[2]['id'];
				$var_321=$var_6237[3]['id'];
				$var_6333=$var_6237[4]['id'];
				$var_6334=$var_6237[5]['id'];
				$var_6335=$var_6237[6]['id'];
				$var_6336=$var_6237[7]['id'];
				Db::table('ims_sudu8_page_navlist')->where('id',$var_375)->where('uniacid',$v_1)->update($var_6238);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_6241)->where('uniacid',$v_1)->update($var_486);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_6242)->where('uniacid',$v_1)->update($var_6239);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_321)->where('uniacid',$v_1)->update($var_6240);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_6333)->where('uniacid',$v_1)->update($var_6329);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_6334)->where('uniacid',$v_1)->update($var_6330);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_6335)->where('uniacid',$v_1)->update($var_6331);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_6336)->where('uniacid',$v_1)->update($var_6332);
			}
			$var_1212=array('url'=>'','uniacid' =>$v_1,'statue'=>2,'name_s'=>1,'box_p_tb'=>2,'box_p_lr'=>1,'number'=>4,'img_size'=>100,'title_color'=>'#222222','title_position'=>1,);
			$var_6243=Db::table('ims_sudu8_page_nav')->where('uniacid',$v_1)->field('uniacid')->find();
			if(empty($var_6243['uniacid']))
			{
				Db::table('ims_sudu8_page_nav')->insert($var_1212);
			}
			else
			{
				Db::table('ims_sudu8_page_nav')->where('uniacid',$v_1)->update($var_1212);
			}
			$var_6263=array('uniacid' =>$v_1,'forms_style'=> 1,'forms_title_s'=> 'title1','forms_head'=> 'slide','forms_name'=> '预约看房','forms_ename'=> '','forms_inps'=> 0,'subtime'=> 2,'forms_btn'=> '提交','success'=> '您已预约成功！','name'=> '姓名','name_must'=> 1,'tel'=> '电话','tel_use'=> 1,'tel_must'=> 1,'tel_i'=> 1,'single_n'=>'预算','single_num'=>2,'single_use'=>1,'single_use'=>1,'single_i'=>1,'single_v'=>'5000以下/平,5000-8000/平,8000-10000/平,10000以上/平','content_n'=> '其他需求','content_use'=> 1,'content_i'=> 1,);
			$var_6264=Db::table('ims_sudu8_page_forms_config')->where('uniacid',$v_1)->field('uniacid')->find();
			if(empty($var_6264['uniacid']))
			{
				Db::table('ims_sudu8_page_forms_config')->insert($var_6263);
			}
			else
			{
				Db::table('ims_sudu8_page_forms_config')->where('uniacid',$v_1)->update($var_6263);
			}
			$var_6265=array('uniacid' =>$v_1,'index_style' =>'slide','slide' =>'a:2:{i:0;s:52:"http://2.cnhjdy.net/assetsj/fangchan/slide1.jpg";i:1;s:52:"http://2.cnhjdy.net/assetsj/fangchan/slide2.jpg";}','banner'=>'','logo'=>'','video'=>'','v_img'=>'','name' =>'房产在线','desc'=>'房产在线','address' =>'南通世纪大道8888号',time =>'8:30 - 18:00','tel' =>15111111111,'latitude' =>31.983310,'longitude' =>120.946330,'about' =>'房产在线 ','base_color'=> '#007dd1','base_tcolor'=> '#ffffff','base_color2'=> '#007dd1','base_color_t'=> '','config'=>'a:12:{s:7:"newhead";s:1:"0";s:6:"search";s:1:"0";s:6:"bigadT";s:1:"0";s:6:"bigadC";s:1:"0";s:8:"bigadCTC";s:1:"3";s:8:"bigadCNN";s:18:"点击进入首页";s:7:"miniadT";s:1:"0";s:7:"miniadC";s:1:"0";s:7:"miniadN";s:12:"点击进入";s:7:"miniadB";s:12:"点击进入";s:4:"copT";s:1:"9";s:8:"userFood";s:1:"0";}','index_style'=> 'slide','tel_box'=> 0,'aboutCN' =>'门店介绍','aboutCNen' =>'About Us','index_about_title' =>9,'catename_x'=> '推荐专区','catenameen_x'=> '','i_b_x_ts'=>9,'i_b_x_iw'=> 600,'catename'=>'推荐楼盘','catenameen'=>'','i_b_y_ts'=> 1,'index_pro_lstyle'=> 2,'index_pro_ts_al'=>'tc','c_b_bg'=> 'http://2.cnhjdy.net/assetsj/fangchan/server.jpg','c_b_btn'=> 0,'form_index'=> 1,'c_title'=> 0,'tabbar_t'=>1,'tabbar_bg'=>'#ffffff','color_bar'=>'#cccccc','tabbar_tc'=>000000,'tabbar_tca'=>'#1c87d8','tabbar'=>'a:3:{i:0;s:217:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:53:"http://2.cnhjdy.net/assetsj/fangchan/tabbar1.png";s:9:"tabbar_p2";s:55:"http://2.cnhjdy.net/assetsj/fangchan/tabbar1_h.png";}";i:1;s:223:"a:4:{s:8:"tabbar_l";s:4:"book";s:8:"tabbar_t";s:12:"预约看房";s:9:"tabbar_p1";s:53:"http://2.cnhjdy.net/assetsj/fangchan/tabbar2.png";s:9:"tabbar_p2";s:55:"http://2.cnhjdy.net/assetsj/fangchan/tabbar2_h.png";}";i:2;s:220:"a:4:{s:8:"tabbar_l";s:3:"tel";s:8:"tabbar_t";s:12:"联系我们";s:9:"tabbar_p1";s:53:"http://2.cnhjdy.net/assetsj/fangchan/tabbar3.png";s:9:"tabbar_p2";s:53:"http://2.cnhjdy.net/assetsj/fangchan/tabbar3.png";}";}',);
			$var_6266=unserialize($var_6265['slide']);
			foreach($var_6266 as $var_6267=>$var_6268)
			{
				$var_6269['appletid']=$v_1;
				$var_6269['url']=$var_6268;
				$var_6269['dateline']=time();
				Db::table('image_url')->insert($var_6269);
			}
			if(empty($var_6222['uniacid']))
			{
				Db::table('ims_sudu8_page_base')->insert($var_6265);
			}
			else
			{
				Db::table('ims_sudu8_page_base')->where('uniacid',$v_1)->update($var_6265);
			}
		}
		elseif($v_2==6)
		{
			$var_6245=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
			$var_6315=count($var_6245);
			$var_6316=array('uniacid' =>$v_1,'num' =>999,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'洛阳线路','ename' =>'','catepic' =>'http://2.cnhjdy.net/assetsj/lvxingshe/nav1.png','cdesc' =>'','show_i' =>1,'list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'tl',);
			$var_6317=array('uniacid' =>$v_1,'num' =>99,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'国内线路','ename' =>'','catepic' =>'http://2.cnhjdy.net/assetsj/lvxingshe/nav2.png','cdesc' =>'','show_i' =>1,'list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'tl',);
			$var_905=array('uniacid' =>$v_1,'num' =>98,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'出境线路','ename' =>'','catepic' =>'http://2.cnhjdy.net/assetsj/lvxingshe/nav3.png','cdesc' =>'','show_i' =>1,'list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'tl',);
			$var_6318=array('uniacid' =>$v_1,'num' =>97,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'研学线路','ename' =>'','catepic' =>'http://2.cnhjdy.net/assetsj/lvxingshe/nav4.png','cdesc' =>'','show_i' =>1,'list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'tl',);
			$var_6319=array('uniacid' =>$v_1,'num' =>96,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'出国签证','ename' =>'','catepic' =>'http://2.cnhjdy.net/assetsj/lvxingshe/nav5.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'tl',);
			$var_255=array('uniacid' =>$v_1,'num' =>95,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'积分兑换区','ename' =>'','catepic' =>'','cdesc' =>'','show_i' =>1,'list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'tl',);
			if($var_6315==0)
			{
				Db::table('ims_sudu8_page_cate')->insert($var_6316);
				Db::table('ims_sudu8_page_cate')->insert($var_6317);
				Db::table('ims_sudu8_page_cate')->insert($var_905);
				Db::table('ims_sudu8_page_cate')->insert($var_6318);
				Db::table('ims_sudu8_page_cate')->insert($var_6319);
				Db::table('ims_sudu8_page_cate')->insert($var_255);
				$var_6322=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
				$var_6323=$var_6322[0]['id'];
				$var_6324=$var_6322[1]['id'];
				$var_6325=$var_6322[2]['id'];
				$var_6326=$var_6322[3]['id'];
				$var_849=$var_6322[4]['id'];
				$var_137=$var_6322[5]['id'];
			}
			else
			{
				$var_6322=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
				$var_6323=$var_6322[0]['id'];
				$var_6324=$var_6322[1]['id'];
				$var_6325=$var_6322[2]['id'];
				$var_6326=$var_6322[3]['id'];
				$var_849=$var_6322[4]['id'];
				$var_137=$var_6322[5]['id'];
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6323)->update($var_6316);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6324)->update($var_6317);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6325)->update($var_905);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6326)->update($var_6318);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_849)->update($var_6319);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_137)->update($var_255);
			}
			$var_240=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPro')->where('pcid',$var_6323)->order('id asc')->field('uniacid,id')->select();
			$var_6337=count($var_240);
			if($var_6337==0)
			{
				$var_6261=array('uniacid' =>$v_1,'num' =>99,'cid'=> $var_6323,'pcid'=> $var_6323,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=> 1,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>360,'market_price'=>360,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/lvxingshe/pro1.jpg','text'=> 'a:1:{i:0;s:51:"http://2.cnhjdy.net/assetsj/lvxingshe/pro1.jpg";}','labels'=> '洛阳','title'=> '云台山两日游','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				$var_815=array('uniacid' =>$v_1,'num' =>94,'cid'=> $var_6323,'pcid'=> $var_6323,'type'=> 'showPro','type_x'=>1,'type_y'=>0,'type_i'=> 1,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>388,'market_price'=>388,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/lvxingshe/pro2.jpg','text'=> 'a:2:{i:0;s:58:"http://2.cnhjdy.net/assetsj/lvxingshe/pro2_slide1.jpg";i:1;s:58:"http://2.cnhjdy.net/assetsj/lvxingshe/pro2_slide2.jpg";}','labels'=> '洛阳','title'=> '龙门石窟少林寺一日游','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				$var_6338=array('uniacid' =>$v_1,'num' =>99,'cid'=> $var_6324,'pcid'=> $var_6324,'type'=> 'showPro','type_x'=>0,'type_y'=>1,'type_i'=> 1,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>5880,'market_price'=>5880,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/lvxingshe/pro3.jpg','text'=> 'a:2:{i:0;s:58:"http://2.cnhjdy.net/assetsj/lvxingshe/pro3_slide1.jpg";i:1;s:58:"http://2.cnhjdy.net/assetsj/lvxingshe/pro3_slide2.jpg";}','labels'=> '海口','title'=> '【春节】洛阳直飞海口【五星盛宴】双飞5天/6天','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				$var_6365=array('uniacid' =>$v_1,'num' =>92,'cid'=> $var_6324,'pcid'=> $var_6324,'type'=> 'showPro','type_x'=>0,'type_y'=>1,'type_i'=> 1,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>1780,'market_price'=>1780,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/lvxingshe/pro4.jpg','text'=> 'a:3:{i:0;s:58:"http://2.cnhjdy.net/assetsj/lvxingshe/pro4_slide1.jpg";i:1;s:58:"http://2.cnhjdy.net/assetsj/lvxingshe/pro4_slide2.jpg";i:2;s:58:"http://2.cnhjdy.net/assetsj/lvxingshe/pro4_slide3.jpg";}','labels'=> '东北','title'=> '【东北】初遇雪乡双卧八日游','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				$var_6366=array('uniacid' =>$v_1,'num' =>99,'cid'=> $var_6325,'pcid'=>$var_6325,'type'=> 'showPro','type_x'=>1,'type_y'=>1,'type_i'=>1,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>15800,'market_price'=>15800,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/lvxingshe/pro5.jpg','text'=> 'a:3:{i:0;s:58:"http://2.cnhjdy.net/assetsj/lvxingshe/pro5_slide1.jpg";i:1;s:58:"http://2.cnhjdy.net/assetsj/lvxingshe/pro5_slide2.jpg";i:2;s:58:"http://2.cnhjdy.net/assetsj/lvxingshe/pro5_slide3.jpg";}','labels'=> '','title'=> '美国东西海岸+大瀑布+夏威夷14天','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				$var_6367=array('uniacid' =>$v_1,'num' =>95,'cid'=> $var_6325,'pcid'=>$var_6325,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=>1,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>4080,'market_price'=>4080,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/lvxingshe/pro6.jpg','text'=> 'a:3:{i:0;s:58:"http://2.cnhjdy.net/assetsj/lvxingshe/pro6_slide1.jpg";i:1;s:58:"http://2.cnhjdy.net/assetsj/lvxingshe/pro6_slide2.jpg";i:2;s:58:"http://2.cnhjdy.net/assetsj/lvxingshe/pro6_slide3.jpg";}','labels'=> '','title'=> ' 泰新马三飞11天','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				$var_760=array('uniacid' =>$v_1,'num' =>99,'cid'=> $var_6326,'pcid'=>$var_6326,'type'=> 'showPro','type_x'=>1,'type_y'=>1,'type_i'=>1,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>1480,'market_price'=>1480,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/lvxingshe/pro7.jpg','text'=> 'a:2:{i:0;s:58:"http://2.cnhjdy.net/assetsj/lvxingshe/pro7_slide1.jpg";i:1;s:58:"http://2.cnhjdy.net/assetsj/lvxingshe/pro7_slide2.jpg";}','labels'=> '','title'=> '洛阳 登封 开封中原文化研学五日游','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				$var_252=array('uniacid' =>$v_1,'num' =>95,'cid'=> $var_6326,'pcid'=>$var_6326,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=>1,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>1060,'market_price'=>1060,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/lvxingshe/pro8.jpg','text'=> 'a:3:{i:0;s:58:"http://2.cnhjdy.net/assetsj/lvxingshe/pro8_slide1.jpg";i:1;s:58:"http://2.cnhjdy.net/assetsj/lvxingshe/pro8_slide2.jpg";i:2;s:58:"http://2.cnhjdy.net/assetsj/lvxingshe/pro8_slide3.jpg";}','labels'=> '','title'=> '魅力古都西安文化研学三日游','desc'=> '概述：西安国家历史文化名城，历史上有周、秦、汉、隋、唐等在内的13个朝代在此建都，曾经作为中国首都和政治、经济、文化中心长达1100多年，7000年前的仰韶文化。','product_txt'=>'这里是商品的详细介绍，可放图文',);
				$var_6368=array('uniacid' =>$v_1,'num' =>95,'cid'=> $var_137,'pcid'=>$var_137,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=>1,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>15,'market_price'=>15,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/lvxingshe/pro9.jpg','text'=> 'a:1:{i:0;s:51:"http://2.cnhjdy.net/assetsj/lvxingshe/pro9.jpg";}','labels'=> '','title'=> '小草莓变色唇膏','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				$var_370=array('uniacid' =>$v_1,'num' =>95,'cid'=> $var_137,'pcid'=>$var_137,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=>1,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>360,'market_price'=>360,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/lvxingshe/pro10.jpg','text'=> 'a:2:{i:0;s:59:"http://2.cnhjdy.net/assetsj/lvxingshe/pro10_slide1.jpg";i:1;s:59:"http://2.cnhjdy.net/assetsj/lvxingshe/pro10_slide2.jpg";}','labels'=> '','title'=> '美容乳胶枕','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				Db::table('ims_sudu8_page_products')->insert($var_6261);
				Db::table('ims_sudu8_page_products')->insert($var_815);
				Db::table('ims_sudu8_page_products')->insert($var_6338);
				Db::table('ims_sudu8_page_products')->insert($var_6365);
				Db::table('ims_sudu8_page_products')->insert($var_6366);
				Db::table('ims_sudu8_page_products')->insert($var_6367);
				Db::table('ims_sudu8_page_products')->insert($var_760);
				Db::table('ims_sudu8_page_products')->insert($var_252);
				Db::table('ims_sudu8_page_products')->insert($var_6368);
				Db::table('ims_sudu8_page_products')->insert($var_370);
			}
			$var_6237=Db::table('ims_sudu8_page_navlist')->where('uniacid',$v_1)->field('uniacid,id')->select();
			$var_6238=array('uniacid' =>$v_1,'num' =>99,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/lvxingshe/nav1.png','title' =>'洛阳线路','url' =>'/sudu8_page/listPro/listPro?cid='.$var_6323,);
			$var_486=array('uniacid' =>$v_1,'num' =>98,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/lvxingshe/nav2.png','title' =>'国内线路','url' =>'/sudu8_page/listPic/listPic?cid='.$var_6324,);
			$var_6239=array('uniacid' =>$v_1,'num' =>97,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/lvxingshe/nav3.png','title' =>'出境线路','url' =>'/sudu8_page/listPic/listPic?cid='.$var_6325,);
			$var_6240=array('uniacid' =>$v_1,'num' =>96,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/lvxingshe/nav4.png','title' =>'研学线路','url' =>'/sudu8_page/listPic/listPic?cid='.$var_6326,);
			$var_6329=array('uniacid' =>$v_1,'num' =>95,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/lvxingshe/nav5.png','title' =>'出国签证','url' =>'/sudu8_page/listPic/listPic?cid='.$var_849,);
			if(empty($var_6237))
			{
				Db::table('ims_sudu8_page_navlist')->insert($var_6238);
				Db::table('ims_sudu8_page_navlist')->insert($var_486);
				Db::table('ims_sudu8_page_navlist')->insert($var_6239);
				Db::table('ims_sudu8_page_navlist')->insert($var_6240);
				Db::table('ims_sudu8_page_navlist')->insert($var_6329);
			}
			else
			{
				$var_6237=Db::table('ims_sudu8_page_navlist')->where('uniacid',$v_1)->field('uniacid,id')->select();
				$var_375=$var_6237[0]['id'];
				$var_6241=$var_6237[1]['id'];
				$var_6242=$var_6237[2]['id'];
				$var_321=$var_6237[3]['id'];
				$var_6333=$var_6237[4]['id'];
				Db::table('ims_sudu8_page_navlist')->where('id',$var_375)->where('uniacid',$v_1)->update($var_6238);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_6241)->where('uniacid',$v_1)->update($var_486);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_6242)->where('uniacid',$v_1)->update($var_6239);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_321)->where('uniacid',$v_1)->update($var_6240);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_6333)->where('uniacid',$v_1)->update($var_6329);
			}
			$var_1212=array('url'=>'','uniacid' =>$v_1,'statue'=>2,'name_s'=>1,'box_p_tb'=>2,'box_p_lr'=>1,'number'=>5,'img_size'=>80,'title_position'=>1,);
			$var_6243=Db::table('ims_sudu8_page_nav')->where('uniacid',$v_1)->field('uniacid')->find();
			if(empty($var_6243['uniacid']))
			{
				Db::table('ims_sudu8_page_nav')->insert($var_1212);
			}
			else
			{
				Db::table('ims_sudu8_page_nav')->where('uniacid',$v_1)->update($var_1212);
			}
			$var_6263=array('uniacid' =>$v_1,'forms_style'=> 1,'forms_title_s'=> 'title1','forms_head'=> header,'forms_name'=> '预约','forms_ename'=> '','forms_inps'=> 1,'subtime'=> 2,'forms_btn'=> '提交','success'=> '您已预约成功！','name'=> '姓名','name_must'=> 1,'tel'=> '电话','tel_use'=> 1,'tel_must'=> 1,'wechat'=>'成年人数','wechat_use'=> 1,'address'=>'1.2米以下儿童人数','address_use'=>1,date=>'出行日期','date_use'=>1,'single_n'=>'信息咨询','single_num'=>3,'single_use'=>3,'single_v'=>'洛阳线路,出境线路,国内线路,研学线路,旅游签证','content_n'=> '备注','content_use'=> 1,);
			$var_6264=Db::table('ims_sudu8_page_forms_config')->where('uniacid',$v_1)->field('uniacid')->find();
			if(empty($var_6264['uniacid']))
			{
				Db::table('ims_sudu8_page_forms_config')->insert($var_6263);
			}
			else
			{
				Db::table('ims_sudu8_page_forms_config')->where('uniacid',$v_1)->update($var_6263);
			}
			$var_6265=array('uniacid' =>$v_1,'index_style' =>'slide','slide' =>'a:1:{i:0;s:53:"http://2.cnhjdy.net/assetsj/lvxingshe/slide1.jpg";}','banner'=>'http://2.cnhjdy.net/assetsj/lvxingshe/logo_bg.jpg','logo'=>'http://2.cnhjdy.net/assetsj/lvxingshe/logo.jpg','name' =>'旅行社','desc'=>'旅行社','address' =>'南通世纪大道8888号',time =>'8:30 - 18:00','tel' =>15111111111,'latitude' =>31.983310,'longitude' =>120.946330,'about' =>'你身边的旅游管家，个性化私人定制！平民化消费线路！','base_color'=> '#4aa500','base_tcolor'=> '#ffffff','base_color2'=> '#4aa500','base_color_t'=> '#ffcf3d','config'=>'a:12:{s:7:"newhead";s:1:"0";s:6:"search";s:1:"0";s:6:"bigadT";s:1:"0";s:6:"bigadC";s:1:"0";s:8:"bigadCTC";s:1:"3";s:8:"bigadCNN";s:18:"点击进入首页";s:7:"miniadT";s:1:"0";s:7:"miniadC";s:1:"0";s:7:"miniadN";s:12:"点击进入";s:7:"miniadB";s:12:"点击进入";s:4:"copT";s:1:"9";s:8:"userFood";s:1:"0";}','index_style'=> 'slide','tel_box'=> 0,'aboutCN' =>'公司介绍','aboutCNen' =>'About Company','index_about_title' =>9,'catename_x'=> '特价线路','catenameen_x'=> 'Special line','i_b_x_ts'=>1,'i_b_x_iw'=> 235,'catename'=>'春节热门线路','catenameen'=>'','i_b_y_ts'=> 1,'index_pro_lstyle'=> 2,'index_pro_ts_al'=>'tc','c_b_bg'=> '','c_b_btn'=> 0,'form_index'=> 0,'c_title'=> 2,'video' =>'','v_img' =>'','tabbar_t'=>1,'tabbar_bg'=>'#ffffff','color_bar'=>'#cccccc','tabbar_tc'=>'#222222','tabbar_tca'=>'#4aa500','tabbar'=>'a:5:{i:0;s:219:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:54:"http://2.cnhjdy.net/assetsj/lvxingshe/tabbar1.png";s:9:"tabbar_p2";s:56:"http://2.cnhjdy.net/assetsj/lvxingshe/tabbar1_h.png";}";i:1;s:218:"a:4:{s:8:"tabbar_l";s:4:"book";s:8:"tabbar_t";s:6:"预约";s:9:"tabbar_p1";s:54:"http://2.cnhjdy.net/assetsj/lvxingshe/tabbar2.png";s:9:"tabbar_p2";s:56:"http://2.cnhjdy.net/assetsj/lvxingshe/tabbar2_h.png";}";i:2;s:222:"a:4:{s:8:"tabbar_l";s:3:"tel";s:8:"tabbar_t";s:12:"电话预订";s:9:"tabbar_p1";s:54:"http://2.cnhjdy.net/assetsj/lvxingshe/tabbar3.png";s:9:"tabbar_p2";s:54:"http://2.cnhjdy.net/assetsj/lvxingshe/tabbar4.png";}";i:3;s:215:"a:4:{s:8:"tabbar_l";s:3:"map";s:8:"tabbar_t";s:6:"导航";s:9:"tabbar_p1";s:54:"http://2.cnhjdy.net/assetsj/lvxingshe/tabbar4.png";s:9:"tabbar_p2";s:54:"http://2.cnhjdy.net/assetsj/lvxingshe/tabbar4.png";}";i:4;s:232:"a:4:{s:8:"tabbar_l";s:10:"usercenter";s:8:"tabbar_t";s:12:"个人中心";s:9:"tabbar_p1";s:54:"http://2.cnhjdy.net/assetsj/lvxingshe/tabbar5.png";s:9:"tabbar_p2";s:56:"http://2.cnhjdy.net/assetsj/lvxingshe/tabbar5_h.png";}";}',);
			$var_6266=unserialize($var_6265['slide']);
			foreach($var_6266 as $var_6267=>$var_6268)
			{
				$var_6269['appletid']=$v_1;
				$var_6269['url']=$var_6268;
				$var_6269['dateline']=time();
				Db::table('image_url')->insert($var_6269);
			}
			if(empty($var_6222['uniacid']))
			{
				Db::table('ims_sudu8_page_base')->insert($var_6265);
			}
			else
			{
				Db::table('ims_sudu8_page_base')->where('uniacid',$v_1)->update($var_6265);
			}
		}
		elseif($v_2==7)
		{
			$var_6227=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPic')->where('cid',0)->order('id asc')->field('uniacid,id')->find();
			$var_6228=array('uniacid' =>$v_1,'num' =>97,'type' =>'showPic','statue' =>1,'cid' =>0,'name' =>'榜样学员','ename' =>'Successful students','show_i' =>1,'list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>5,'list_stylet' =>'tc','pic_page_btn'=>0,);
			if(empty($var_6227['uniacid']))
			{
				Db::table('ims_sudu8_page_cate')->insert($var_6228);
			}
			else
			{
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6227['id'])->update($var_6228);
			}
			$var_6228=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPic')->where('cid',0)->order('id asc')->field('uniacid,id')->find();
			$var_967=$var_6228['id'];
			$var_6245=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
			$var_6315=count($var_6245);
			$var_6246=array('uniacid' =>$v_1,'num' =>999,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'精品课程','ename' =>'Excellent course','catepic' =>'http://2.cnhjdy.net/assetsj/peixun/nav1.png','cdesc' =>'','show_i' =>1,'list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>11,'list_stylet' =>'tl',);
			if($var_6315==0)
			{
				Db::table('ims_sudu8_page_cate')->insert($var_6246);
				$var_6322=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
				$var_6323=$var_6322[0]['id'];
			}
			else
			{
				$var_6322=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
				$var_6323=$var_6322[0]['id'];
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6323)->update($var_6246);
			}
			$var_1203=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showArt')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
			$var_900=array('uniacid' =>$v_1,'num' =>99,'type' =>'showArt','statue' =>1,'cid' =>0,'name' =>'名师风采','ename' =>'Famous teachers','catepic' =>'','cdesc' =>'','show_i' =>1,'list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>5,'list_stylet' =>'tc','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"0";s:4:"ptit";s:1:"1";}',);
			$var_6270=array('uniacid' =>$v_1,'num' =>98,'type' =>'showArt','statue' =>1,'cid' =>0,'name' =>'公司动态','ename' =>'News feed','catepic' =>'','cdesc' =>'','show_i' =>1,'list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>1,'list_style' =>3,'list_stylet' =>'tl','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"0";s:4:"ptit";s:1:"1";}',);
			if(empty($var_6348['uniacid']))
			{
				Db::table('ims_sudu8_page_cate')->insert($var_900);
				Db::table('ims_sudu8_page_cate')->insert($var_6270);
			}
			else
			{
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6348[0]['id'])->update($var_900);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6348[1]['id'])->update($var_6270);
			}
			$var_6244=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showArt')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
			$var_6369=$var_6244[0]['id'];
			$var_6370=$var_6244[1]['id'];
			$var_6287=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','page')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
			$var_956=array('uniacid' =>$v_1,'num' =>99,'type' =>'page','statue' =>1,'cid' =>0,'name' =>'公司简介','ename' =>'','catepic' =>'http://2.cnhjdy.net/assetsj/peixun/nav1.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>2,'list_tstylel' =>1,'list_type' =>1,'content' =>'此处是栏目内容',);
			if(empty($var_6287['uniacid']))
			{
				Db::table('ims_sudu8_page_cate')->insert($var_956);
			}
			$var_6237=Db::table('ims_sudu8_page_navlist')->where('uniacid',$v_1)->field('uniacid,id')->select();
			if(empty($var_6237))
			{
				$var_6238=array('uniacid' =>$v_1,'num' =>99,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/peixun/nav1.png','title' =>'关于我们','url' =>'/sudu8_page/about/about',);
				$var_486=array('uniacid' =>$v_1,'num' =>98,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/peixun/nav2.png','title' =>'课程挑选','url' =>'/sudu8_page/listPro/listPro?cid='.$var_6323,);
				$var_6239=array('uniacid' =>$v_1,'num' =>97,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/peixun/nav3.png','title' =>'优惠券','url' =>'/sudu8_page/coupon/coupon',);
				$var_6240=array('uniacid' =>$v_1,'num' =>96,'flag' =>1,'type' =>1,'pic' =>'http://2.cnhjdy.net/assetsj/peixun/nav4.png','title' =>'联系我们','url' =>'',);
				Db::table('ims_sudu8_page_navlist')->insert($var_6238);
				Db::table('ims_sudu8_page_navlist')->insert($var_486);
				Db::table('ims_sudu8_page_navlist')->insert($var_6239);
				Db::table('ims_sudu8_page_navlist')->insert($var_6240);
			}
			$var_1212=array('url'=>'','uniacid' =>$v_1,'statue'=>2,'name_s'=>1,'box_p_tb'=>4,'box_p_lr'=>1,'number'=>4,'img_size'=>60,'title_position'=>1,'title_color' =>'#222222',);
			if(empty($var_6243['uniacid']))
			{
				Db::table('ims_sudu8_page_nav')->insert($var_1212);
			}
			else
			{
				Db::table('ims_sudu8_page_nav')->where('uniacid',$v_1)->update($var_1212);
			}
			$var_240=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPro')->where('pcid',$var_6323)->field('uniacid,id')->select();
			$var_6337=count($var_240);
			if($var_6337==0)
			{
				$var_6261=array('uniacid' =>$v_1,'num' =>99,'cid'=> $var_6323,'pcid'=> $var_6323,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=> 1,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>360,'market_price'=>360,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/peixun/pro1.png','text'=> 'a:1:{i:0;s:48:"http://2.cnhjdy.net/assetsj/peixun/pro1.png";}','labels'=> '期末,小学,名师','title'=> '期末数学冲刺课','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				$var_815=array('uniacid' =>$v_1,'num' =>94,'cid'=> $var_6323,'pcid'=> $var_6323,'type'=> 'showPro','type_x'=>1,'type_y'=>0,'type_i'=> 1,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>388,'market_price'=>388,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/peixun/pro2.jpg','text'=> 'a:2:{i:0;s:55:"http://2.cnhjdy.net/assetsj/peixun/pro2_slide1.jpg";i:1;s:55:"http://2.cnhjdy.net/assetsj/peixun/pro2_slide2.jpg";}','labels'=> '','title'=> '6人团包半价','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				Db::table('ims_sudu8_page_products')->insert($var_6261);
				Db::table('ims_sudu8_page_products')->insert($var_815);
			}
			$var_6248=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPic')->where('pcid',$var_967)->field('uniacid,id')->select();
			$var_6249=count($var_6248);
			$var_6250=array('uniacid' =>$v_1,'num' =>99,'cid'=> $var_967,'pcid'=> $var_967,'type_x'=> 1,'type'=> 'showPic','type_i'=> 1,'title'=> '高考案例：谢轩考入中山大学','thumb'=> 'http://2.cnhjdy.net/assetsj/peixun/pic1.png','text'=> 'a:1:{i:0;s:51:"http://2.cnhjdy.net/assetsj/peixun/pic1_p1.png";}',);
			$var_6251=array('uniacid' =>$v_1,'num' =>98,'cid'=> $var_967,'pcid'=> $var_967,'type_x'=> 1,'type'=> 'showPic','type_i'=> 1,'title'=> '高考案例：吴恩培考入中山大学','thumb'=> 'http://2.cnhjdy.net/assetsj/peixun/pic2.png','text'=> 'a:1:{i:0;s:51:"http://2.cnhjdy.net/assetsj/peixun/pic1_p1.png";}',);
			$var_6252=array('uniacid' =>$v_1,'num' =>97,'cid'=> $var_967,'pcid'=> $var_967,'type_x'=> 1,'type'=> 'showPic','type_i'=> 1,'title'=> '高考案例：谢虹考入中山大学','thumb'=> 'http://2.cnhjdy.net/assetsj/peixun/pic3.png','text'=> 'a:1:{i:0;s:51:"http://2.cnhjdy.net/assetsj/peixun/pic1_p1.png";}',);
			if($var_6249==0)
			{
				Db::table('ims_sudu8_page_products')->insert($var_6250);
				Db::table('ims_sudu8_page_products')->insert($var_6251);
				Db::table('ims_sudu8_page_products')->insert($var_6252);
			}
			else
			{
				$var_6371=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPic')->where('pcid',$var_967)->field('uniacid,id')->select();
				$var_6372=$var_6371[0]['id'];
				$var_6373=$var_6371[1]['id'];
				$var_6374=$var_6371[2]['id'];
				Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('id',$var_6372)->update($var_6250);
				Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('id',$var_6373)->update($var_6251);
				Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('id',$var_6374)->update($var_6252);
			}
			$var_6375=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showArt')->where('pcid',$var_6369)->field('uniacid,id')->select();
			$var_6376=count($var_6375);
			if($var_6376==0)
			{
				$var_6256=array('uniacid' =>$v_1,'num'=>999,'cid'=> $var_6369,'pcid'=> $var_6369,'type'=> 'showArt','type_i'=> 1,'title'=> '白老师','thumb'=> 'http://2.cnhjdy.net/assetsj/peixun/art1.jpg','desc'=> '','text'=> '这里是文章内容',);
				$var_6257=array('uniacid' =>$v_1,'num'=>99,'cid'=> $var_6369,'pcid'=> $var_6369,'type'=> 'showArt','type_i'=> 1,'title'=> '封老师','thumb'=> 'http://2.cnhjdy.net/assetsj/peixun/art2.jpg','desc'=> '','text'=> '这里是文章内容',);
				$var_6258=array('uniacid' =>$v_1,'num'=>98,'cid'=> $var_6369,'pcid'=> $var_6369,'type'=> 'showArt','type_i'=> 1,'title'=> '秋老师','thumb'=> 'http://2.cnhjdy.net/assetsj/peixun/art3.jpg','desc'=> '','text'=> '这里是文章内容',);
				Db::table('ims_sudu8_page_products')->insert($var_6256);
				Db::table('ims_sudu8_page_products')->insert($var_6257);
				Db::table('ims_sudu8_page_products')->insert($var_6258);
			}
			$var_6377=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showArt')->where('pcid',$var_6370)->field('uniacid,id')->select();
			$var_6378=count($var_6377);
			if($var_6378==0)
			{
				$var_6256=array('uniacid' =>$v_1,'num'=>999,'cid'=> $var_6370,'pcid'=> $var_6370,'type'=> 'showArt','type_i'=> 1,'title'=> '品牌数学寒假班课接受报名啦！','thumb'=> 'http://2.cnhjdy.net/assetsj/peixun/art4.jpg','desc'=> '品牌数学寒假课程 ，倾注全部人力物力打造的名师课程，全体骨干老师整合全年级常年教育资源和成果，并采取连续紧凑的教学模式，通过科学教学于帮助孩子提前预习课本知识和提升学习主动性，为新学期打下坚实基础。','text'=> '这里是文章内容',);
				Db::table('ims_sudu8_page_products')->insert($var_6256);
			}
			$v_2=array('uniacid' =>$v_1,header=>1,'tel_box'=>1,'serv_box'=>1,'content'=>'<p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p>',);
			$var_6262=Db::table('ims_sudu8_page_about')->where('uniacid',$v_1)->find();
			if(empty($var_6262['uniacid']))
			{
				Db::table('ims_sudu8_page_about')->insert($v_2);
			}
			else
			{
				Db::table('ims_sudu8_page_about')->where('uniacid',$v_1)->update($v_2);
			}
			$var_6263=array('uniacid' =>$v_1,'forms_style'=> 2,'forms_title_s'=> 'title1','forms_head'=> 'none','forms_name'=> '自助预约','forms_ename'=> 'Self Booking','forms_inps'=> 0,'subtime'=> 2,'forms_btn'=> '立即预约','success'=> '您已预约成功！','name'=> '姓名','name_must'=> 1,'tel'=> '联系电话','tel_use'=> 1,'tel_must'=> 1,'wechat'=>'年纪','wechat_use'=> 1,date=>'预约日期','date_use'=>1,time=>'预约时间','time_use'=>1,'checkbox_n'=>'课程选择','checkbox_num'=>2,'checkbox_use'=>1,'checkbox_v'=>'小学奥数,初中理科,高中理科,免费试听','content_n'=> '备注','content_use'=> 1,);
			$var_6264=Db::table('ims_sudu8_page_forms_config')->where('uniacid',$v_1)->field('uniacid')->find();
			if(empty($var_6264['uniacid']))
			{
				Db::table('ims_sudu8_page_forms_config')->insert($var_6263);
			}
			else
			{
				Db::table('ims_sudu8_page_forms_config')->where('uniacid',$v_1)->update($var_6263);
			}
			$var_6265=array('uniacid' =>$v_1,'index_style' =>'slide','slide' =>'a:2:{i:0;s:50:"http://2.cnhjdy.net/assetsj/peixun/slide1.jpg";i:1;s:50:"http://2.cnhjdy.net/assetsj/peixun/slide2.jpg";}','banner'=>'http://2.cnhjdy.net/assetsj/peixun/logo_bg.jpg','logo'=>'http://2.cnhjdy.net/assetsj/peixun/logo.png','name' =>'教育培训','desc'=>'教育培训','address' =>'南通世纪大道8888号',time =>'8:30 - 18:00','tel' =>15111111111,'latitude' =>31.983310,'longitude' =>120.946330,'about' =>'教育培训教育培训','base_color'=> '#007deb','base_tcolor'=> '#ffffff','base_color2'=> '#007deb','base_color_t'=> '#ffcf3d','config'=>'a:12:{s:7:"newhead";s:1:"0";s:6:"search";s:1:"0";s:6:"bigadT";s:1:"0";s:6:"bigadC";s:1:"0";s:8:"bigadCTC";s:1:"3";s:8:"bigadCNN";s:18:"点击进入首页";s:7:"miniadT";s:1:"0";s:7:"miniadC";s:1:"0";s:7:"miniadN";s:12:"点击进入";s:7:"miniadB";s:12:"点击进入";s:4:"copT";s:1:"9";s:8:"userFood";s:1:"0";}','index_style'=> 'slide','tel_box'=> 0,'aboutCN' =>'教育简介','aboutCNen' =>'About Company','index_about_title' =>'title2','catename_x'=> '特价线路','catenameen_x'=> 'Special line','i_b_x_ts'=>9,'i_b_x_iw'=> 235,'catename'=>'春节热门线路','catenameen'=>'','i_b_y_ts'=> 9,'index_pro_lstyle'=> 2,'index_pro_ts_al'=>'tc','c_b_bg'=> '','c_b_btn'=> 0,'form_index'=> 0,'c_title'=> 1,'video' =>'','v_img' =>'','tabbar_t'=>1,'tabbar_bg'=>'#ffffff','color_bar'=>'#ffffff','tabbar_tc'=>'#000000','tabbar_tca'=>'#ff0a0a','tabbar'=>'a:5:{i:0;s:211:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:51:"http://2.cnhjdy.net/assetsj/peixun/tabbar1.png";s:9:"tabbar_p2";s:51:"http://2.cnhjdy.net/assetsj/peixun/tabbar1.png";}";i:1;s:207:"a:4:{s:8:"tabbar_l";s:1:"7";s:8:"tabbar_t";s:6:"课程";s:9:"tabbar_p1";s:51:"http://2.cnhjdy.net/assetsj/peixun/tabbar2.png";s:9:"tabbar_p2";s:51:"http://2.cnhjdy.net/assetsj/peixun/tabbar2.png";}";i:2;s:210:"a:4:{s:8:"tabbar_l";s:4:"book";s:8:"tabbar_t";s:6:"预约";s:9:"tabbar_p1";s:51:"http://2.cnhjdy.net/assetsj/peixun/tabbar3.png";s:9:"tabbar_p2";s:51:"http://2.cnhjdy.net/assetsj/peixun/tabbar3.png";}";i:3;s:209:"a:4:{s:8:"tabbar_l";s:3:"map";s:8:"tabbar_t";s:6:"校区";s:9:"tabbar_p1";s:51:"http://2.cnhjdy.net/assetsj/peixun/tabbar4.png";s:9:"tabbar_p2";s:51:"http://2.cnhjdy.net/assetsj/peixun/tabbar4.png";}";i:4;s:224:"a:4:{s:8:"tabbar_l";s:10:"usercenter";s:8:"tabbar_t";s:12:"个人中心";s:9:"tabbar_p1";s:51:"http://2.cnhjdy.net/assetsj/peixun/tabbar5.png";s:9:"tabbar_p2";s:51:"http://2.cnhjdy.net/assetsj/peixun/tabbar5.png";}";}',);
			$var_6266=unserialize($var_6265['slide']);
			foreach($var_6266 as $var_6267=>$var_6268)
			{
				$var_6269['appletid']=$v_1;
				$var_6269['url']=$var_6268;
				$var_6269['dateline']=time();
				Db::table('image_url')->insert($var_6269);
			}
			if(empty($var_6222['uniacid']))
			{
				Db::table('ims_sudu8_page_base')->insert($var_6265);
			}
			else
			{
				Db::table('ims_sudu8_page_base')->where('uniacid',$v_1)->update($var_6265);
			}
		}
		elseif($v_2==8)
		{
			$var_6348=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showArt')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
			$var_900=array('uniacid' =>$v_1,'num' =>999,'type' =>'showArt','statue' =>1,'cid' =>0,'name' =>'花艺','ename' =>'Famous teachers','catepic' =>'','cdesc' =>'','show_i' =>1,'list_tstyle' =>1,'list_tstylel' =>0,'list_type' =>0,'list_style' =>6,'list_stylet' =>'none','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',);
			$var_6270=array('uniacid' =>$v_1,'num' =>99,'type' =>'showArt','statue' =>1,'cid' =>0,'name' =>'花艺展示','ename' =>'','catepic' =>'','cdesc' =>'','show_i' =>1,'list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>0,'list_style' =>2,'list_stylet' =>'tc','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:2:"10";s:4:"ptit";s:1:"3";}',);
			$var_6271=array('uniacid' =>$v_1,'num' =>98,'type' =>'showArt','statue' =>1,'cid' =>0,'name' =>'花束欣赏','ename' =>'','catepic' =>'','cdesc' =>'','show_i' =>1,'list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>0,'list_style' =>2,'list_stylet' =>'tc','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:2:"10";s:4:"ptit";s:1:"3";}',);
			$var_6379=array('uniacid' =>$v_1,'num' =>97,'type' =>'showArt','statue' =>1,'cid' =>0,'name' =>'新品推荐','ename' =>'','catepic' =>'','cdesc' =>'','show_i' =>1,'list_tstyle' =>2,'list_tstylel' =>0,'list_type' =>0,'list_style' =>2,'list_stylet' =>'tc','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:2:"10";s:4:"ptit";s:1:"0";}',);
			if(empty($var_6348['uniacid']))
			{
				Db::table('ims_sudu8_page_cate')->insert($var_900);
				Db::table('ims_sudu8_page_cate')->insert($var_6270);
				Db::table('ims_sudu8_page_cate')->insert($var_6271);
				Db::table('ims_sudu8_page_cate')->insert($var_6379);
			}
			else
			{
				Db::table('ims_sudu8_page_cate')->where('id',$var_6348[0]['id'])->where('uniacid',$v_1)->update($var_900);
				Db::table('ims_sudu8_page_cate')->where('id',$var_6348[1]['id'])->where('uniacid',$v_1)->update($var_6270);
				Db::table('ims_sudu8_page_cate')->where('id',$var_6348[2]['id'])->where('uniacid',$v_1)->update($var_6271);
				Db::table('ims_sudu8_page_cate')->where('id',$var_6348[3]['id'])->where('uniacid',$v_1)->update($var_6379);
			}
			$var_6244=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showArt')->order('id asc')->where('cid',0)->field('uniacid,id')->select();
			$var_6369=$var_6244[0]['id'];
			$var_6370=$var_6244[1]['id'];
			$var_267=$var_6244[2]['id'];
			$var_6380=$var_6244[3]['id'];
			$var_6381=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showArt')->where('cid',$var_6369)->field('uniacid,id')->select();
			$var_6382=count($var_6381);
			if($var_6382==0)
			{
				$var_6350=array('uniacid' =>$v_1,'num' =>9,'type' =>'showArt','statue' =>1,'cid' =>$var_6369,'name' =>'栏目1','ename' =>'','catepic'=>'http://2.cnhjdy.net/assetsj/huadian/cat1.jpg','show_i' =>1,'list_tstyle' =>0,'list_tstylel' =>1,'list_type' =>0,'list_style' =>2,'list_stylet' =>'tc','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',);
				$var_6351=array('uniacid' =>$v_1,'num' =>9,'type' =>'showArt','statue' =>1,'cid' =>$var_6369,'name' =>'栏目2','ename' =>'','catepic'=>'http://2.cnhjdy.net/assetsj/huadian/cat2.jpg','show_i' =>1,'list_tstyle' =>0,'list_tstylel' =>1,'list_type' =>0,'list_style' =>2,'list_stylet' =>'tc','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',);
				$var_2451=array('uniacid' =>$v_1,'num' =>9,'type' =>'showArt','statue' =>1,'cid' =>$var_6369,'name' =>'栏目3','ename' =>'','catepic'=>'http://2.cnhjdy.net/assetsj/huadian/cat3.jpg','show_i' =>1,'list_tstyle' =>0,'list_tstylel' =>1,'list_type' =>0,'list_style' =>2,'list_stylet' =>'tc','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',);
				$var_6352=array('uniacid' =>$v_1,'num' =>9,'type' =>'showArt','statue' =>1,'cid' =>$var_6369,'name' =>'栏目4','ename' =>'','catepic'=>'http://2.cnhjdy.net/assetsj/huadian/cat4.jpg','show_i' =>1,'list_tstyle' =>0,'list_tstylel' =>1,'list_type' =>0,'list_style' =>2,'list_stylet' =>'tc','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',);
				Db::table('ims_sudu8_page_cate')->insert($var_6350);
				Db::table('ims_sudu8_page_cate')->insert($var_6351);
				Db::table('ims_sudu8_page_cate')->insert($var_2451);
				Db::table('ims_sudu8_page_cate')->insert($var_6352);
			}
			$var_6383=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showArt')->where('cid',$var_6370)->field('uniacid,id')->select();
			$var_1668=count($var_6383);
			if($var_1668==0)
			{
				$var_6350=array('uniacid' =>$v_1,'num' =>9,'type' =>'showArt','statue' =>1,'cid' =>$var_6370,'name' =>'百合花','ename' =>'','catepic'=>'http://2.cnhjdy.net/assetsj/huadian/cat5.jpg','show_i' =>1,'list_tstyle' =>0,'list_tstylel' =>1,'list_type' =>0,'list_style' =>2,'list_stylet' =>'tc','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',);
				$var_6351=array('uniacid' =>$v_1,'num' =>9,'type' =>'showArt','statue' =>1,'cid' =>$var_6370,'name' =>'红玫瑰','ename' =>'','catepic'=>'http://2.cnhjdy.net/assetsj/huadian/cat6.jpg','show_i' =>1,'list_tstyle' =>0,'list_tstylel' =>1,'list_type' =>0,'list_style' =>2,'list_stylet' =>'tc','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',);
				Db::table('ims_sudu8_page_cate')->insert($var_6350);
				Db::table('ims_sudu8_page_cate')->insert($var_6351);
			}
			$var_106=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showArt')->where('cid',$var_267)->field('uniacid,id')->select();
			$var_6384=count($var_106);
			if($var_6384==0)
			{
				$var_6350=array('uniacid' =>$v_1,'num' =>9,'type' =>'showArt','statue' =>1,'cid' =>$var_267,'name' =>'香槟玫瑰','ename' =>'','catepic'=>'http://2.cnhjdy.net/assetsj/huadian/cat7.jpg','show_i' =>1,'list_tstyle' =>0,'list_tstylel' =>1,'list_type' =>0,'list_style' =>2,'list_stylet' =>'tc','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',);
				$var_6351=array('uniacid' =>$v_1,'num' =>9,'type' =>'showArt','statue' =>1,'cid' =>$var_267,'name' =>'玫瑰百合','ename' =>'','catepic'=>'http://2.cnhjdy.net/assetsj/huadian/cat8.jpg','show_i' =>1,'list_tstyle' =>0,'list_tstylel' =>1,'list_type' =>0,'list_style' =>2,'list_stylet' =>'tc','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',);
				Db::table('ims_sudu8_page_cate')->insert($var_6350);
				Db::table('ims_sudu8_page_cate')->insert($var_6351);
			}
			$var_6385=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showArt')->where('cid',$var_6380)->field('uniacid,id')->select();
			$var_6386=count($var_6385);
			if($var_6386==0)
			{
				$var_6350=array('uniacid' =>$v_1,'num' =>9,'type' =>'showArt','statue' =>1,'cid' =>$var_6380,'name' =>'红玫瑰','ename' =>'','catepic'=>'http://2.cnhjdy.net/assetsj/huadian/cat9.jpg','show_i' =>1,'list_tstyle' =>0,'list_tstylel' =>1,'list_type' =>0,'list_style' =>2,'list_stylet' =>'tc','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',);
				$var_6351=array('uniacid' =>$v_1,'num' =>9,'type' =>'showArt','statue' =>1,'cid' =>$var_6380,'name' =>'雏菊','ename' =>'','catepic'=>'http://2.cnhjdy.net/assetsj/huadian/cat10.jpg','show_i' =>1,'list_tstyle' =>0,'list_tstylel' =>1,'list_type' =>0,'list_style' =>2,'list_stylet' =>'tc','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',);
				$var_2451=array('uniacid' =>$v_1,'num' =>9,'type' =>'showArt','statue' =>1,'cid' =>$var_6380,'name' =>'蓝玫瑰','ename' =>'','catepic'=>'http://2.cnhjdy.net/assetsj/huadian/cat11.jpg','show_i' =>1,'list_tstyle' =>0,'list_tstylel' =>1,'list_type' =>0,'list_style' =>2,'list_stylet' =>'tc','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',);
				$var_6352=array('uniacid' =>$v_1,'num' =>9,'type' =>'showArt','statue' =>1,'cid' =>$var_6380,'name' =>'康乃馨','ename' =>'','catepic'=>'http://2.cnhjdy.net/assetsj/huadian/cat12.jpg','show_i' =>1,'list_tstyle' =>0,'list_tstylel' =>1,'list_type' =>0,'list_style' =>2,'list_stylet' =>'tc','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:1:"1";s:4:"ptit";s:1:"2";}',);
				Db::table('ims_sudu8_page_cate')->insert($var_6350);
				Db::table('ims_sudu8_page_cate')->insert($var_6351);
				Db::table('ims_sudu8_page_cate')->insert($var_2451);
				Db::table('ims_sudu8_page_cate')->insert($var_6352);
			}
			$v_2=array('uniacid' =>$v_1,header=>1,'tel_box'=>1,'serv_box'=>0,'content'=>'<p>花艺鲜花店鲜花是江苏地区较早专业开展网上订花送花的实体花店，是一家以鲜花批发、零售为一体的专业实体花店，提供精美潮流花束，生日用花，婚庆花艺，全国县级以上城市和地区均可送达。</p><p><br/></p><p>我们拥有专业的花艺师团队，特别在婚礼花艺和艺术花艺上有特别的研究和创新，为客户提供完美的花艺艺术，始终走在前端引领着市场的潮流！</p>',);
			$var_6262=Db::table('ims_sudu8_page_about')->where('uniacid',$v_1)->field('uniacid')->find();
			if(empty($var_6262['uniacid']))
			{
				Db::table('ims_sudu8_page_about')->insert($v_2);
			}
			else
			{
				Db::table('ims_sudu8_page_about')->where('uniacid',$v_1)->update($v_2);
			}
			$var_6265=array('uniacid' =>$v_1,'index_style' =>'slide','slide' =>'a:3:{i:0;s:51:"http://2.cnhjdy.net/assetsj/huadian/slide1.jpg";i:1;s:51:"http://2.cnhjdy.net/assetsj/huadian/slide2.jpg";i:2;s:51:"http://2.cnhjdy.net/assetsj/huadian/slide3.jpg";}','banner'=>'http://2.cnhjdy.net/assetsj/huadian/logo_bg.jpg','logo'=>'http://2.cnhjdy.net/assetsj/huadian/logo.jpg','name' =>'花艺行业','desc'=>'花束出售','address' =>'南通世纪大道8888号',time =>'8:30 - 18:00','tel' =>15111111111,'latitude' =>31.983310,'longitude' =>120.946330,'about' =>'花束出售','base_color'=> '#ffffff','base_tcolor'=> '#000000','base_color2'=> '#8787f0','base_color_t'=> '#8787f0','config'=>'a:12:{s:7:"newhead";s:1:"0";s:6:"search";s:1:"0";s:6:"bigadT";s:1:"0";s:6:"bigadC";s:1:"0";s:8:"bigadCTC";s:1:"3";s:8:"bigadCNN";s:18:"点击进入首页";s:7:"miniadT";s:1:"0";s:7:"miniadC";s:1:"0";s:7:"miniadN";s:12:"点击进入";s:7:"miniadB";s:12:"点击进入";s:4:"copT";s:1:"9";s:8:"userFood";s:1:"0";}','index_style'=> 'slide','tel_box'=> 0,'aboutCN' =>'教育简介','aboutCNen' =>'About Company','index_about_title' =>9,'catename_x'=> '特价线路','catenameen_x'=> 'Special line','i_b_x_ts'=>9,'i_b_x_iw'=> 235,'catename'=>'春节热门线路','catenameen'=>'','i_b_y_ts'=> 9,'index_pro_lstyle'=> 2,'index_pro_ts_al'=>'tc','c_b_bg'=> '','c_b_btn'=> 0,'form_index'=> 0,'c_title'=> 2,'video' =>'','v_img' =>'','tabbar_t'=>1,'tabbar_bg'=>'#ffffff','color_bar'=>'#cccccc','tabbar_tc'=>'#222222','tabbar_tca'=>'#cccccc','tabbar'=>'a:3:{i:0;s:213:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:52:"http://2.cnhjdy.net/assetsj/huadian/tabbar1.jpg";s:9:"tabbar_p2";s:52:"http://2.cnhjdy.net/assetsj/huadian/tabbar1.jpg";}";i:1;s:209:"a:4:{s:8:"tabbar_l";s:1:"7";s:8:"tabbar_t";s:6:"简介";s:9:"tabbar_p1";s:52:"http://2.cnhjdy.net/assetsj/huadian/tabbar2.jpg";s:9:"tabbar_p2";s:52:"http://2.cnhjdy.net/assetsj/huadian/tabbar2.jpg";}";i:2;s:226:"a:4:{s:8:"tabbar_l";s:10:"usercenter";s:8:"tabbar_t";s:12:"个人中心";s:9:"tabbar_p1";s:52:"http://2.cnhjdy.net/assetsj/huadian/tabbar3.jpg";s:9:"tabbar_p2";s:52:"http://2.cnhjdy.net/assetsj/huadian/tabbar3.jpg";}";}',);
			$var_6266=unserialize($var_6265['slide']);
			foreach($var_6266 as $var_6267=>$var_6268)
			{
				$var_6269['appletid']=$v_1;
				$var_6269['url']=$var_6268;
				$var_6269['dateline']=time();
				Db::table('image_url')->insert($var_6269);
			}
			if(empty($var_6222['uniacid']))
			{
				Db::table('ims_sudu8_page_base')->insert($var_6265);
			}
			else
			{
				Db::table('ims_sudu8_page_base')->where('uniacid',$v_1)->update($var_6265);
			}
		}
		elseif($v_2==9)
		{
			$var_1203=$var_1203=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showArt')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
			$var_900=array('uniacid' =>$v_1,'num' =>999,'type' =>'showArt','statue' =>1,'cid' =>0,'name' =>'检车环境','ename' =>'','catepic' =>'http://2.cnhjdy.net/assetsj/qixiu/nav2.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>1,'list_type' =>1,'list_style' =>1,'list_stylet' =>'none','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:2:"10";s:4:"ptit";s:1:"1";}',);
			$var_6270=array('uniacid' =>$v_1,'num' =>98,'type' =>'showArt','statue' =>1,'cid' =>0,'name' =>'检车准备','ename' =>'','catepic' =>'http://2.cnhjdy.net/assetsj/qixiu/nav3.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>1,'list_type' =>1,'list_style' =>1,'list_stylet' =>'none','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:2:"10";s:4:"ptit";s:1:"1";}',);
			$var_6271=array('uniacid' =>$v_1,'num' =>97,'type' =>'showArt','statue' =>1,'cid' =>0,'name' =>'关于我们','ename' =>'','catepic' =>'http://2.cnhjdy.net/assetsj/qixiu/nav4.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>1,'list_type' =>1,'list_style' =>1,'list_stylet' =>'none','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:2:"10";s:4:"ptit";s:1:"1";}',);
			$var_6379=array('uniacid' =>$v_1,'num' =>96,'type' =>'showArt','statue' =>1,'cid' =>0,'name' =>'行业资讯','ename' =>'Industry information','catepic' =>'','cdesc' =>'','show_i' =>0,'list_tstyle' =>2,'list_tstylel' =>2,'list_type' =>1,'list_style' =>2,'list_stylet' =>'tlb','pic_page_btn'=>0,'cateconf'=>'a:2:{s:5:"pmarb";s:2:"10";s:4:"ptit";s:1:"1";}',);
			if(empty($var_6348['uniacid']))
			{
				Db::table('ims_sudu8_page_cate')->insert($var_900);
				Db::table('ims_sudu8_page_cate')->insert($var_6270);
				Db::table('ims_sudu8_page_cate')->insert($var_6271);
				Db::table('ims_sudu8_page_cate')->insert($var_6379);
			}
			else
			{
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6348[0]['id'])->update($var_900);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6348[1]['id'])->update($var_6270);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6348[2]['id'])->update($var_6271);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6348[3]['id'])->update($var_6379);
			}
			$var_6244=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showArt')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
			$var_6369=$var_6244[0]['id'];
			$var_6370=$var_6244[1]['id'];
			$var_267=$var_6244[2]['id'];
			$var_6380=$var_6244[3]['id'];
			$var_6245=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
			$var_6315=count($var_6245);
			$var_6316=array('uniacid' =>$v_1,'num' =>999,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'所有项目','ename' =>'','catepic' =>'http://2.cnhjdy.net/assetsj/qixiu/nav1.png','cdesc' =>'','show_i' =>0,'list_tstyle' =>0,'list_tstylel' =>2,'list_type' =>1,'list_style' =>12,'list_stylet' =>'none',);
			$var_6317=array('uniacid' =>$v_1,'num' =>98,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'产品&服务','ename' =>'Products and Services','catepic' =>'','cdesc' =>'','show_i' =>1,'list_tstyle' =>1,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'tl',);
			if($var_6315==0)
			{
				Db::table('ims_sudu8_page_cate')->insert($var_6316);
				Db::table('ims_sudu8_page_cate')->insert($var_6317);
				$var_6322=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
				$var_6323=$var_6322[0]['id'];
				$var_6324=$var_6322[1]['id'];
			}
			else
			{
				$var_6322=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
				$var_6323=$var_6322[0]['id'];
				$var_6324=$var_6322[1]['id'];
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6323)->update($var_6316);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6324)->update($var_6317);
			}
			$var_6237=Db::table('ims_sudu8_page_navlist')->where('uniacid',$v_1)->field('uniacid,id')->select();
			$var_6238=array('uniacid' =>$v_1,'num' =>99,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/qixiu/nav1.png','title' =>'所有项目','url' =>'/sudu8_page/listPro/listPro?cid='.$var_6323,);
			$var_486=array('uniacid' =>$v_1,'num' =>98,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/qixiu/nav2.png','title' =>'检车环境','url' =>'/sudu8_page/listPic/listPic?cid='.$var_6369,);
			$var_6239=array('uniacid' =>$v_1,'num' =>97,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/qixiu/nav3.png','title' =>'检车准备','url' =>'/sudu8_page/listPic/listPic?cid='.$var_6370,);
			$var_6240=array('uniacid' =>$v_1,'num' =>96,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/qixiu/nav4.png','title' =>'关于我们','url' =>'/sudu8_page/listPic/listPic?cid='.$var_267,);
			if(empty($var_6237))
			{
				Db::table('ims_sudu8_page_navlist')->insert($var_6238);
				Db::table('ims_sudu8_page_navlist')->insert($var_486);
				Db::table('ims_sudu8_page_navlist')->insert($var_6239);
				Db::table('ims_sudu8_page_navlist')->insert($var_6240);
			}
			else
			{
				$var_6237=Db::table('ims_sudu8_page_navlist')->where('uniacid',$v_1)->field('uniacid,id')->select();
				$var_375=$var_6237[0]['id'];
				$var_6241=$var_6237[1]['id'];
				$var_6242=$var_6237[2]['id'];
				$var_321=$var_6237[3]['id'];
				Db::table('ims_sudu8_page_navlist')->where('id',$var_375)->where('uniacid',$v_1)->update($var_6238);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_6241)->where('uniacid',$v_1)->update($var_486);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_6242)->where('uniacid',$v_1)->update($var_6239);
				Db::table('ims_sudu8_page_navlist')->where('id',$var_321)->where('uniacid',$v_1)->update($var_6240);
			}
			$var_1212=array('url'=> '','uniacid' =>$v_1,'statue'=>1,'name_s'=>1,'box_p_tb'=>2,'box_p_lr'=>1,'number'=>4,'img_size'=>80,'title_position'=>0,);
			$var_6243=Db::table('ims_sudu8_page_nav')->where('uniacid',$v_1)->field('uniacid')->find();
			if(empty($var_6243['uniacid']))
			{
				Db::table('ims_sudu8_page_nav')->insert($var_1212);
			}
			else
			{
				Db::table('ims_sudu8_page_nav')->where('uniacid',$v_1)->update($var_1212);
			}
			$var_240=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPro')->where('pcid',$var_6323)->order('id asc')->field('uniacid,id')->select();
			$var_6337=count($var_240);
			if($var_6337==0)
			{
				$var_6261=array('uniacid' =>$v_1,'num' =>99,'cid'=> $var_6323,'pcid'=> $var_6323,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=> 0,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'购买','price'=>360,'market_price'=>360,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/qixiu/pro1.jpg','text'=> 'a:1:{i:0;s:47:"http://2.cnhjdy.net/assetsj/qixiu/pro1.jpg";}','labels'=> '','title'=> '家庭轿车','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				Db::table('ims_sudu8_page_products')->insert($var_6261);
			}
			$var_6339=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPro')->where('pcid',$var_6324)->order('id asc')->field('uniacid,id')->select();
			$var_459=count($var_6339);
			if($var_459==0)
			{
				$var_6261=array('uniacid' =>$v_1,'num' =>99,'cid'=> $var_6324,'pcid'=> $var_6324,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=> 1,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'购买','price'=>360,'market_price'=>360,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/qixiu/pro1.jpg','text'=> 'a:1:{i:0;s:47:"http://2.cnhjdy.net/assetsj/qixiu/pro1.jpg";}','labels'=> '','title'=> '家庭轿车','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				$var_815=array('uniacid' =>$v_1,'num' =>98,'cid'=> $var_6324,'pcid'=> $var_6324,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=> 1,'pro_flag' =>1,'pro_flag_tel' =>1,'pro_flag_add' =>0,'pro_flag_ding'=>1,'buy_type'=>'购买','price'=>360,'market_price'=>360,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/qixiu/pro2.jpg','text'=> 'a:1:{i:0;s:47:"http://2.cnhjdy.net/assetsj/qixiu/pro2.jpg";}','labels'=> '','title'=> '货车（营运）','desc'=> '','product_txt'=>'这里是商品的详细介绍，可放图文',);
				Db::table('ims_sudu8_page_products')->insert($var_6261);
				Db::table('ims_sudu8_page_products')->insert($var_815);
			}
			$var_23=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showArt')->where('pcid',$var_6380)->order('id asc')->field('uniacid,id')->select();
			$var_6387=count($var_23);
			if($var_6387==0)
			{
				$var_6256=array('uniacid' =>$v_1,'num'=>999,'cid'=> $var_6380,'pcid'=> $var_6380,'type'=> 'showArt','type_x' =>1,'type_i'=> 1,'title'=> '检车注意事项','thumb'=> 'http://2.cnhjdy.net/assetsj/qixiu/art1.jpg','desc'=> '','text'=> '这里是文章内容',);
				$var_6257=array('uniacid' =>$v_1,'num'=>99,'cid'=> $var_6380,'pcid'=> $var_6380,'type'=> 'showArt','type_x' =>1,'type_i'=> 1,'title'=> '检车环境','thumb'=> 'http://2.cnhjdy.net/assetsj/qixiu/art2.jpg','desc'=> '','text'=> '这里是文章内容',);
				Db::table('ims_sudu8_page_products')->insert($var_6256);
				Db::table('ims_sudu8_page_products')->insert($var_6257);
			}
			$var_6263=array('uniacid' =>$v_1,'forms_style'=> 2,'forms_title_s'=> 'title1','forms_head'=> header,'forms_name'=> '在线预约','forms_ename'=> '','forms_inps'=> 1,'subtime'=> 2,'forms_btn'=> '立即预约','success'=> '您已预约成功！','name'=> '姓名','name_must'=> 1,'tel'=> '电话','tel_use'=> 1,'tel_must'=> 1,'tel_i'=> 1,date=>'预约日期','date_use'=>1,'date_i'=>1,time=>'预约时间','time_use'=>1,'time_i'=>1,'checkbox_n'=>'项目','checkbox_num'=>2,'checkbox_use'=>1,'checkbox_i'=>1,'checkbox_v'=>'上门取车,自驾检车,家庭轿车,货车,三轮货车,正三轮,两轮',);
			$var_6264=Db::table('ims_sudu8_page_forms_config')->where('uniacid',$v_1)->field('uniacid')->find();
			if(empty($var_6264['uniacid']))
			{
				Db::table('ims_sudu8_page_forms_config')->insert($var_6263);
			}
			else
			{
				Db::table('ims_sudu8_page_forms_config')->where('uniacid',$v_1)->update($var_6263);
			}
			$var_6265=array('uniacid' =>$v_1,'index_style' =>'slide','slide' =>'a:1:{i:0;s:49:"http://2.cnhjdy.net/assetsj/qixiu/slide1.jpg";}','banner'=>'http://2.cnhjdy.net/assetsj/qixiu/logo_bg.jpg','logo'=>'','name' =>'汽修行业','desc'=>'汽修','address' =>'南通世纪大道8888号',time =>'8:30 - 18:00','tel' =>15111111111,'latitude' =>31.983310,'longitude' =>120.946330,'about' =>'汽修','base_color'=> '#3f7bc4','base_tcolor'=> '#ffffff','base_color2'=> '#3f7bc4','base_color_t'=> '#ffcf3d','config'=>'a:12:{s:7:"newhead";s:1:"0";s:6:"search";s:1:"1";s:6:"bigadT";s:1:"0";s:6:"bigadC";s:1:"0";s:8:"bigadCTC";s:1:"3";s:8:"bigadCNN";s:18:"点击进入首页";s:7:"miniadT";s:1:"0";s:7:"miniadC";s:1:"0";s:7:"miniadN";s:12:"点击进入";s:7:"miniadB";s:12:"点击进入";s:4:"copT";s:1:"9";s:8:"userFood";s:1:"0";}','index_style'=> 'slide','tel_box'=> 0,'aboutCN' =>'教育简介2','aboutCNen' =>'About Company','index_about_title' =>9,'catename_x'=> '行业资讯','catenameen_x'=> 'Industry information','i_b_x_ts'=>2,'i_b_x_iw'=> 500,'catename'=>'春节热门线路','catenameen'=>'','i_b_y_ts'=> 9,'index_pro_lstyle'=> 2,'index_pro_ts_al'=>'tc','c_b_bg'=> '','c_b_btn'=> 0,'form_index'=> 1,'c_title'=> 2,'video' =>'','v_img' =>'','tabbar_t'=>1,'tabbar_bg'=>'#ffffff','color_bar'=>'#cccccc','tabbar_tc'=>'#595959','tabbar_tca'=>'#3f7bc4','tabbar'=>'a:5:{i:0;s:211:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:50:"http://2.cnhjdy.net/assetsj/qixiu/tabbar1.png";s:9:"tabbar_p2";s:52:"http://2.cnhjdy.net/assetsj/qixiu/tabbar1_h.png";}";i:1;s:217:"a:4:{s:8:"tabbar_l";s:4:"book";s:8:"tabbar_t";s:12:"自助预约";s:9:"tabbar_p1";s:50:"http://2.cnhjdy.net/assetsj/qixiu/tabbar2.png";s:9:"tabbar_p2";s:52:"http://2.cnhjdy.net/assetsj/qixiu/tabbar2_h.png";}";i:2;s:207:"a:4:{s:8:"tabbar_l";s:3:"map";s:8:"tabbar_t";s:6:"导航";s:9:"tabbar_p1";s:50:"http://2.cnhjdy.net/assetsj/qixiu/tabbar3.png";s:9:"tabbar_p2";s:50:"http://2.cnhjdy.net/assetsj/qixiu/tabbar3.png";}";i:3;s:207:"a:4:{s:8:"tabbar_l";s:3:"tel";s:8:"tabbar_t";s:6:"电话";s:9:"tabbar_p1";s:50:"http://2.cnhjdy.net/assetsj/qixiu/tabbar4.png";s:9:"tabbar_p2";s:50:"http://2.cnhjdy.net/assetsj/qixiu/tabbar4.png";}";i:4;s:210:"a:4:{s:8:"tabbar_l";s:6:"wechat";s:8:"tabbar_t";s:6:"客服";s:9:"tabbar_p1";s:50:"http://2.cnhjdy.net/assetsj/qixiu/tabbar5.png";s:9:"tabbar_p2";s:50:"http://2.cnhjdy.net/assetsj/qixiu/tabbar5.png";}";}',);
			$var_6266=unserialize($var_6265['slide']);
			foreach($var_6266 as $var_6267=>$var_6268)
			{
				$var_6269['appletid']=$v_1;
				$var_6269['url']=$var_6268;
				$var_6269['dateline']=time();
				Db::table('image_url')->insert($var_6269);
			}
			if(empty($var_6222['uniacid']))
			{
				Db::table('ims_sudu8_page_base')->insert($var_6265);
			}
			else
			{
				Db::table('ims_sudu8_page_base')->where('uniacid',$v_1)->update($var_6265);
			}
		}
		elseif($v_2==10)
		{
			$var_6245=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
			$var_6315=count($var_6245);
			$var_6246=array('uniacid' =>$v_1,'num' =>99,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'高级设计师','ename' =>'Designer','catepic' =>'http://2.cnhjdy.net/assetsj/zxzs/nav1.png','cdesc' =>'','show_i' =>1,'list_tstyle' =>1,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'none',);
			if($var_6315==0)
			{
				Db::table('ims_sudu8_page_cate')->insert($var_6246);
				$var_6322=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
				$var_6323=$var_6322[0]['id'];
			}
			else
			{
				$var_6322=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
				$var_6323=$var_6322[0]['id'];
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6323)->update($var_6246);
			}
			$var_6227=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPic')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
			$var_6388=array('uniacid' =>$v_1,'num' =>99,'type' =>'showPic','statue' =>1,'cid' =>0,'name' =>'产品&服务','ename' =>'Products and Services','show_i' =>1,'list_tstyle' =>1,'list_tstylel' =>0,'list_type' =>1,'list_style' =>2,'list_stylet' =>'tcb','pic_page_btn'=>0,);
			$var_6389=array('uniacid' =>$v_1,'num' =>97,'type' =>'showPic','statue' =>1,'cid' =>0,'name' =>'样板风格','ename' =>'style','show_i' =>1,'list_tstyle' =>1,'list_tstylel' =>0,'list_type' =>1,'list_style' =>2,'list_stylet' =>'tcb','pic_page_btn'=>0,);
			if(empty($var_6227['uniacid']))
			{
				Db::table('ims_sudu8_page_cate')->insert($var_6388);
				Db::table('ims_sudu8_page_cate')->insert($var_6389);
				$var_6228=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPic')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
				$var_6390=$var_6228[0]['id'];
				$var_6391=$var_6228[1]['id'];
			}
			else
			{
				$var_6228=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPic')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
				$var_6390=$var_6228[0]['id'];
				$var_6391=$var_6228[1]['id'];
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6390)->update($var_6388);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6391)->update($var_6389);
			}
			$var_6237=Db::table('ims_sudu8_page_navlist')->where('uniacid',$v_1)->order('id asc')->field('uniacid,id')->select();
			if(empty($var_6237))
			{
				$var_6238=array('uniacid' =>$v_1,'num' =>99,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/zxzs/nav1.png','title' =>'全国分店','url' =>'/sudu8_page/store/store',);
				$var_486=array('uniacid' =>$v_1,'num' =>98,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/zxzs/nav2.png','title' =>'优惠券','url' =>'/sudu8_page/coupon/coupon',);
				$var_6239=array('uniacid' =>$v_1,'num' =>97,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/zxzs/nav3.png','title' =>'品牌保障','url' =>'/sudu8_page/about/about',);
				$var_6240=array('uniacid' =>$v_1,'num' =>96,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/zxzs/nav4.png','title' =>'预约','url' =>'/sudu8_page/book/book',);
				$var_6329=array('uniacid' =>$v_1,'num' =>96,'flag' =>1,'type' =>3,'pic' =>'http://2.cnhjdy.net/assetsj/zxzs/nav5.png','title' =>'客服经理',);
				Db::table('ims_sudu8_page_navlist')->insert($var_6238);
				Db::table('ims_sudu8_page_navlist')->insert($var_486);
				Db::table('ims_sudu8_page_navlist')->insert($var_6239);
				Db::table('ims_sudu8_page_navlist')->insert($var_6240);
				Db::table('ims_sudu8_page_navlist')->insert($var_6329);
			}
			$var_1212=array('url'=>'','uniacid' =>$v_1,'statue'=>2,'name_s'=>1,'box_p_tb'=>2,'box_p_lr'=>1,'number'=>5,'img_size'=>60,'title_position'=>1,'title_color' =>'#000000',);
			if(empty($var_6243['uniacid']))
			{
				Db::table('ims_sudu8_page_nav')->insert($var_1212);
			}
			else
			{
				Db::table('ims_sudu8_page_nav')->where('uniacid',$v_1)->update($var_1212);
			}
			$var_240=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPro')->where('pcid',$var_6323)->order('id asc')->field('uniacid,id')->select();
			$var_6337=count($var_240);
			if($var_6337==0)
			{
				$var_6261=array('uniacid' =>$v_1,'num' =>99,'cid'=> $var_6323,'pcid'=> $var_6323,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=> 1,'pro_flag' =>2,'pro_flag_tel' =>2,'pro_flag_add' =>2,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>360,'market_price'=>360,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/zxzs/pro1.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/zxzs/pro1.jpg";}','labels'=> '','title'=> '周晓安','desc'=> '','product_txt'=>'这里是设计师的详细介绍，可放图文',);
				$var_815=array('uniacid' =>$v_1,'num' =>98,'cid'=> $var_6323,'pcid'=> $var_6323,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=> 1,'pro_flag' =>2,'pro_flag_tel' =>2,'pro_flag_add' =>2,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>360,'market_price'=>360,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/zxzs/pro2.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/zxzs/pro2.jpg";}','labels'=> '','title'=> '何育红','desc'=> '','product_txt'=>'这里是设计师的详细介绍，可放图文',);
				$var_6338=array('uniacid' =>$v_1,'num' =>99,'cid'=> $var_6323,'pcid'=> $var_6323,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=> 1,'pro_flag' =>2,'pro_flag_tel' =>2,'pro_flag_add' =>2,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>360,'market_price'=>360,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/zxzs/pro3.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/zxzs/pro3.jpg";}','labels'=> '','title'=> '张咚冬','desc'=> '','product_txt'=>'这里是设计师的详细介绍，可放图文',);
				$var_6365=array('uniacid' =>$v_1,'num' =>99,'cid'=> $var_6323,'pcid'=> $var_6323,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=> 1,'pro_flag' =>2,'pro_flag_tel' =>2,'pro_flag_add' =>2,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>360,'market_price'=>360,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/zxzs/pro4.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/zxzs/pro4.jpg";}','labels'=> '','title'=> '杨萍','desc'=> '','product_txt'=>'这里是设计师的详细介绍，可放图文',);
				Db::table('ims_sudu8_page_products')->insert($var_6261);
				Db::table('ims_sudu8_page_products')->insert($var_815);
				Db::table('ims_sudu8_page_products')->insert($var_6338);
				Db::table('ims_sudu8_page_products')->insert($var_6365);
			}
			$v_45=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPic')->where('pcid',$var_6390)->order('id asc')->field('uniacid,id')->select();
			$var_6392=count($v_45);
			if($var_6392==0)
			{
				$var_6250=array('uniacid' =>$v_1,'cid'=> $var_6390,'pcid'=> $var_6390,'type_x'=> 1,'type'=> 'showPic','type_i'=> 1,'title'=> '南亚风格','thumb'=> 'http://2.cnhjdy.net/assetsj/zxzs/pic1.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/zxzs/pic1.jpg";}',);
				$var_6251=array('uniacid' =>$v_1,'cid'=> $var_6390,'pcid'=> $var_6390,'type_x'=> 1,'type'=> 'showPic','type_i'=> 1,'title'=> '地中海风格','thumb'=> 'http://2.cnhjdy.net/assetsj/zxzs/pic2.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/zxzs/pic2.jpg";}',);
				$var_6252=array('uniacid' =>$v_1,'cid'=> $var_6390,'pcid'=> $var_6390,'type_x'=> 1,'type'=> 'showPic','type_i'=> 1,'title'=> '欧美风格','thumb'=> 'http://2.cnhjdy.net/assetsj/zxzs/pic3.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/zxzs/pic3.jpg";}',);
				$var_6253=array('uniacid' =>$v_1,'cid'=> $var_6390,'pcid'=> $var_6390,'type_x'=> 1,'type'=> 'showPic','type_i'=> 1,'title'=> '传统风格','thumb'=> 'http://2.cnhjdy.net/assetsj/zxzs/pic4.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/zxzs/pic4.jpg";}',);
				Db::table('ims_sudu8_page_products')->insert($var_6253);
				Db::table('ims_sudu8_page_products')->insert($var_6252);
				Db::table('ims_sudu8_page_products')->insert($var_6251);
				Db::table('ims_sudu8_page_products')->insert($var_6250);
			}
			$var_6393=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPic')->where('pcid',$var_6391)->order('id asc')->field('uniacid,id')->select();
			$var_6394=count($var_6393);
			if($var_6394==0)
			{
				$var_6250=array('uniacid' =>$v_1,'cid'=> $var_6391,'pcid'=> $var_6391,'type_x'=> 1,'type'=> 'showPic','type_i'=> 1,'title'=> '样板间1','thumb'=> 'http://2.cnhjdy.net/assetsj/zxzs/pic5.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/zxzs/pic5.jpg";}',);
				$var_6251=array('uniacid' =>$v_1,'cid'=> $var_6391,'pcid'=> $var_6391,'type_x'=> 1,'type'=> 'showPic','type_i'=> 1,'title'=> '样板间2','thumb'=> 'http://2.cnhjdy.net/assetsj/zxzs/pic6.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/zxzs/pic6.jpg";}',);
				$var_6252=array('uniacid' =>$v_1,'cid'=> $var_6391,'pcid'=> $var_6391,'type_x'=> 1,'type'=> 'showPic','type_i'=> 1,'title'=> '样板间3','thumb'=> 'http://2.cnhjdy.net/assetsj/zxzs/pic7.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/zxzs/pic7.jpg";}',);
				$var_6253=array('uniacid' =>$v_1,'cid'=> $var_6391,'pcid'=> $var_6391,'type_x'=> 1,'type'=> 'showPic','type_i'=> 1,'title'=> '样板间4','thumb'=> 'http://2.cnhjdy.net/assetsj/zxzs/pic8.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/zxzs/pic8.jpg";}',);
				Db::table('ims_sudu8_page_products')->insert($var_6250);
				Db::table('ims_sudu8_page_products')->insert($var_6251);
				Db::table('ims_sudu8_page_products')->insert($var_6252);
				Db::table('ims_sudu8_page_products')->insert($var_6253);
			}
			$v_2=array('uniacid' =>$v_1,header=>1,'tel_box'=>1,'serv_box'=>2,'content'=>'<p>十五年装修装饰经验</p>',);
			$var_6262=Db::table('ims_sudu8_page_about')->where('uniacid',$v_1)->field('uniacid')->find();
			if(empty($var_6262['uniacid']))
			{
				Db::table('ims_sudu8_page_about')->insert($v_2);
			}
			else
			{
				Db::table('ims_sudu8_page_about')->where('uniacid',$v_1)->update($v_2);
			}
			$var_6263=array('uniacid' =>$v_1,'forms_style'=> 1,'forms_title_s'=> 'title1','forms_head'=> 'slide','forms_name'=> '预约设计师','forms_ename'=> '','forms_inps'=> 1,'subtime'=> 2,'forms_btn'=> '提交','success'=> '您已预约成功！','name'=> '您的名称','name_must'=> 1,'tel'=> '手机号码','tel_use'=> 1,'tel_must'=> 1,'tel_i'=> 1,'wechat'=> '房子面积','wechat_use'=> 1,'wechat_must'=> 1,'wechat_i'=> 1,date=>'预约日期','date_use'=>1,'date_must'=> 1,'date_i'=>1,);
			$var_6264=Db::table('ims_sudu8_page_forms_config')->where('uniacid',$v_1)->field('uniacid')->find();
			if(empty($var_6264['uniacid']))
			{
				Db::table('ims_sudu8_page_forms_config')->insert($var_6263);
			}
			else
			{
				Db::table('ims_sudu8_page_forms_config')->where('uniacid',$v_1)->update($var_6263);
			}
			$var_6395=array('uniacid' =>$v_1,'num' =>9,'title' =>'满50000立减1000','color' =>'#f57082','price' =>1000,'pay_money' =>50000,'counts' =>999,'xz_count' =>1,'btime' =>1512486016,'etime' =>1534559624,'flag' =>1,);
			if(empty($var_6222['uniacid']))
			{
				Db::table('ims_sudu8_page_coupon')->insert($var_6395);
			}
			else
			{
				Db::table('ims_sudu8_page_coupon')->where('uniacid',$v_1)->update($var_6395);
			}
			$var_6265=array('uniacid' =>$v_1,'index_style' =>'slide','slide' =>'a:2:{i:0;s:48:"http://2.cnhjdy.net/assetsj/zxzs/slide1.png";i:1;s:48:"http://2.cnhjdy.net/assetsj/zxzs/slide2.png";}','banner'=>'http://2.cnhjdy.net/assetsj/zxzs/logo_bg.png','logo'=>'http://2.cnhjdy.net/assetsj/zxzs/logo.png','name' =>'装修装饰门店','desc'=>'十五年装修装饰经验','address' =>'南通世纪大道8888号',time =>'8:30 - 18:00','tel' =>15111111111,'latitude' =>31.983310,'longitude' =>120.946330,'about' =>'十五年装修装饰经验','base_color'=> '#f57082','base_tcolor'=> '#ffffff','base_color2'=> '#f57082','base_color_t'=> '#f57082','config'=>'a:12:{s:7:"newhead";s:1:"0";s:6:"search";s:1:"1";s:6:"bigadT";s:1:"0";s:6:"bigadC";s:1:"0";s:8:"bigadCTC";s:1:"3";s:8:"bigadCNN";s:18:"点击进入首页";s:7:"miniadT";s:1:"0";s:7:"miniadC";s:1:"0";s:7:"miniadN";s:12:"点击进入";s:7:"miniadB";s:12:"点击进入";s:4:"copT";s:1:"0";s:8:"userFood";s:1:"0";}','index_style'=> 'slide','tel_box'=> 1,'aboutCN' =>'教育简介2','aboutCNen' =>'About Company','index_about_title' =>9,'catename_x'=> '行业资讯','catenameen_x'=> 'Industry information','i_b_x_ts'=>9,'i_b_x_iw'=> 500,'catename'=>'春节热门线路','catenameen'=>'','i_b_y_ts'=> 9,'index_pro_lstyle'=> 2,'index_pro_ts_al'=>'tc','c_b_bg'=> 'http://2.cnhjdy.net/assetsj/zxzs/server_bg.png','c_b_btn'=> 2,'form_index'=> 1,'c_title'=> 2,'video' =>'','v_img' =>'','tabbar_t'=>1,'tabbar_bg'=>'#ffffff','color_bar'=>'#ffffff','tabbar_tc'=>'#333333','tabbar_tca'=>'#f57082','tabbar'=>'a:3:{i:0;s:207:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:49:"http://2.cnhjdy.net/assetsj/zxzs/tabbar1.png";s:9:"tabbar_p2";s:49:"http://2.cnhjdy.net/assetsj/zxzs/tabbar1.png";}";i:1;s:214:"a:4:{s:8:"tabbar_l";s:5:"about";s:8:"tabbar_t";s:12:"公司介绍";s:9:"tabbar_p1";s:49:"http://2.cnhjdy.net/assetsj/zxzs/tabbar2.png";s:9:"tabbar_p2";s:49:"http://2.cnhjdy.net/assetsj/zxzs/tabbar2.png";}";i:2;s:220:"a:4:{s:8:"tabbar_l";s:10:"usercenter";s:8:"tabbar_t";s:12:"个人中心";s:9:"tabbar_p1";s:49:"http://2.cnhjdy.net/assetsj/zxzs/tabbar3.png";s:9:"tabbar_p2";s:49:"http://2.cnhjdy.net/assetsj/zxzs/tabbar3.png";}";}',);
			$var_6266=unserialize($var_6265['slide']);
			foreach($var_6266 as $var_6267=>$var_6268)
			{
				$var_6269['appletid']=$v_1;
				$var_6269['url']=$var_6268;
				$var_6269['dateline']=time();
				Db::table('image_url')->insert($var_6269);
			}
			if(empty($var_6222['uniacid']))
			{
				Db::table('ims_sudu8_page_base')->insert($var_6265);
			}
			else
			{
				Db::table('ims_sudu8_page_base')->where('uniacid',$v_1)->update($var_6265);
			}
		}
		elseif($v_2==11)
		{
			$var_6245=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
			$var_6315=count($var_6245);
			$var_6396=array('uniacid' =>$v_1,'num' =>99,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'教练预约','ename' =>'subscribe/trainer','catepic' =>'','cdesc' =>'','show_i' =>1,'list_tstyle' =>1,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'none',);
			$var_6397=array('uniacid' =>$v_1,'num' =>88,'type' =>'showPro','statue' =>1,'cid' =>0,'name' =>'会员卡办理','ename' =>'power','catepic' =>'','cdesc' =>'','show_i' =>1,'list_tstyle' =>1,'list_tstylel' =>0,'list_type' =>1,'list_style' =>12,'list_stylet' =>'none',);
			if($var_6315==0)
			{
				Db::table('ims_sudu8_page_cate')->insert($var_6396);
				Db::table('ims_sudu8_page_cate')->insert($var_6397);
				$var_6322=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
				$var_6323=$var_6322[0]['id'];
				$var_6324=$var_6322[1]['id'];
			}
			else
			{
				$var_6322=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPro')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
				$var_6323=$var_6322[0]['id'];
				$var_6324=$var_6322[1]['id'];
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6323)->update($var_6396);
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6324)->update($var_6397);
			}
			$var_6227=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPic')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
			$var_6388=array('uniacid' =>$v_1,'num' =>90,'type' =>'showPic','statue' =>1,'cid' =>0,'name' =>'俱乐部器材','ename' =>'equipment','show_i' =>1,'list_tstyle' =>1,'list_tstylel' =>0,'list_type' =>1,'list_style' =>5,'list_stylet' =>'none','pic_page_btn'=>0,);
			if(empty($var_6227['uniacid']))
			{
				Db::table('ims_sudu8_page_cate')->insert($var_6388);
			}
			else
			{
				Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('id',$var_6227['id'])->update($var_6388);
			}
			$var_6398=Db::table('ims_sudu8_page_cate')->where('uniacid',$v_1)->where('type','showPic')->where('cid',0)->order('id asc')->field('uniacid,id')->select();
			$var_6390=$var_6398[0]['id'];
			$var_6237=Db::table('ims_sudu8_page_navlist')->where('uniacid',$v_1)->order('id asc')->field('uniacid,id')->select();
			if(empty($var_6237))
			{
				$var_6238=array('uniacid' =>$v_1,'num' =>99,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/jshs/nav1.png','title' =>'会员卡开通','url' =>'',);
				$var_486=array('uniacid' =>$v_1,'num' =>98,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/jshs/nav2.png','title' =>'美体瘦身','url' =>'',);
				$var_6239=array('uniacid' =>$v_1,'num' =>97,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/jshs/nav3.png','title' =>'跑步训练','url' =>'',);
				$var_6240=array('uniacid' =>$v_1,'num' =>96,'flag' =>1,'type' =>0,'pic' =>'http://2.cnhjdy.net/assetsj/jshs/nav4.png','title' =>'力量训练','url' =>'',);
				Db::table('ims_sudu8_page_navlist')->insert($var_6238);
				Db::table('ims_sudu8_page_navlist')->insert($var_486);
				Db::table('ims_sudu8_page_navlist')->insert($var_6239);
				Db::table('ims_sudu8_page_navlist')->insert($var_6240);
			}
			$var_1212=array('url'=>'','uniacid' =>$v_1,'statue'=>2,'name_s'=>1,'box_p_tb'=>2,'box_p_lr'=>1,'number'=>4,'img_size'=>60,'title_position'=>1,'title_color' =>'#000000',);
			if(empty($var_6243['uniacid']))
			{
				Db::table('ims_sudu8_page_nav')->insert($var_1212);
			}
			else
			{
				Db::table('ims_sudu8_page_nav')->where('uniacid',$v_1)->update($var_1212);
			}
			$var_240=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPro')->where('pcid',$var_6323)->order('id asc')->field('uniacid,id')->select();
			$var_6337=count($var_240);
			if($var_6337==0)
			{
				$var_6261=array('uniacid' =>$v_1,'num' =>99,'cid'=> $var_6323,'pcid'=> $var_6323,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=> 1,'pro_flag' =>2,'pro_flag_tel' =>2,'pro_flag_add' =>2,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>360,'market_price'=>360,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/jshs/pro1.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/jshs/pro1.jpg";}','labels'=> '','title'=> '张甜瑜伽教练','desc'=> '','product_txt'=>'这里是训练教练的详细介绍，可放图文',);
				$var_815=array('uniacid' =>$v_1,'num' =>98,'cid'=> $var_6323,'pcid'=> $var_6323,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=> 1,'pro_flag' =>2,'pro_flag_tel' =>2,'pro_flag_add' =>2,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>360,'market_price'=>360,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/jshs/pro2.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/jshs/pro2.jpg";}','labels'=> '','title'=> '李飞力量训练教练','desc'=> '','product_txt'=>'这里是设计师的详细介绍，可放图文',);
				$var_6338=array('uniacid' =>$v_1,'num' =>99,'cid'=> $var_6323,'pcid'=> $var_6323,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=> 1,'pro_flag' =>2,'pro_flag_tel' =>2,'pro_flag_add' =>2,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>360,'market_price'=>360,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/jshs/pro3.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/jshs/pro3.jpg";}','labels'=> '','title'=> '张笛教练','desc'=> '','product_txt'=>'这里是设计师的详细介绍，可放图文',);
				$var_6365=array('uniacid' =>$v_1,'num' =>99,'cid'=> $var_6323,'pcid'=> $var_6323,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=> 1,'pro_flag' =>2,'pro_flag_tel' =>2,'pro_flag_add' =>2,'pro_flag_ding'=>1,'buy_type'=>'预约','price'=>360,'market_price'=>360,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/jshs/pro4.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/jshs/pro4.jpg";}','labels'=> '','title'=> '郝梅教练','desc'=> '','product_txt'=>'这里是设计师的详细介绍，可放图文',);
				Db::table('ims_sudu8_page_products')->insert($var_6261);
				Db::table('ims_sudu8_page_products')->insert($var_815);
				Db::table('ims_sudu8_page_products')->insert($var_6338);
				Db::table('ims_sudu8_page_products')->insert($var_6365);
			}
			$var_6339=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPro')->where('pcid',$var_6324)->order('id asc')->field('uniacid,id')->select();
			$var_459=count($var_6339);
			if($var_459==0)
			{
				$var_6261=array('uniacid' =>$v_1,'num' =>99,'cid'=> $var_6324,'pcid'=> $var_6324,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=> 1,'pro_flag' =>2,'pro_flag_tel' =>2,'pro_flag_add' =>2,'pro_flag_ding'=>1,'buy_type'=>'办卡','price'=>360,'market_price'=>360,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/jshs/pro5.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/jshs/pro5.jpg";}','labels'=> '','title'=> '会员月卡','desc'=> '','product_txt'=>'这里是训练教练的详细介绍，可放图文',);
				$var_815=array('uniacid' =>$v_1,'num' =>98,'cid'=> $var_6324,'pcid'=> $var_6324,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=> 1,'pro_flag' =>2,'pro_flag_tel' =>2,'pro_flag_add' =>2,'pro_flag_ding'=>1,'buy_type'=>'办卡','price'=>360,'market_price'=>360,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/jshs/pro5.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/jshs/pro5.jpg";}','labels'=> '','title'=> '全年1对1专属教练','desc'=> '','product_txt'=>'这里是设计师的详细介绍，可放图文',);
				$var_6338=array('uniacid' =>$v_1,'num' =>99,'cid'=> $var_6324,'pcid'=> $var_6324,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=> 1,'pro_flag' =>2,'pro_flag_tel' =>2,'pro_flag_add' =>2,'pro_flag_ding'=>1,'buy_type'=>'办卡','price'=>360,'market_price'=>360,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/jshs/pro5.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/jshs/pro5.jpg";}','labels'=> '','title'=> '2年会员卡','desc'=> '','product_txt'=>'这里是设计师的详细介绍，可放图文',);
				$var_6365=array('uniacid' =>$v_1,'num' =>99,'cid'=> $var_6324,'pcid'=> $var_6324,'type'=> 'showPro','type_x'=>0,'type_y'=>0,'type_i'=> 1,'pro_flag' =>2,'pro_flag_tel' =>2,'pro_flag_add' =>2,'pro_flag_ding'=>1,'buy_type'=>'办卡','price'=>360,'market_price'=>360,'pro_kc'=>500,'pro_xz'=>0,'thumb'=> 'http://2.cnhjdy.net/assetsj/jshs/pro5.jpg','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/jshs/pro5.jpg";}','labels'=> '','title'=> '会员年卡','desc'=> '','product_txt'=>'这里是设计师的详细介绍，可放图文',);
				Db::table('ims_sudu8_page_products')->insert($var_6261);
				Db::table('ims_sudu8_page_products')->insert($var_815);
				Db::table('ims_sudu8_page_products')->insert($var_6338);
				Db::table('ims_sudu8_page_products')->insert($var_6365);
			}
			$v_45=Db::table('ims_sudu8_page_products')->where('uniacid',$v_1)->where('type','showPic')->where('pcid',$var_6390)->order('id asc')->field('uniacid,id')->select();
			$var_6392=count($v_45);
			if($var_6392==0)
			{
				$var_6250=array('num' =>99,'uniacid' =>$v_1,'cid'=> $var_6390,'pcid'=> $var_6390,'type_x'=> 1,'type'=> 'showPic','type_i'=> 1,'title'=> '杠铃','thumb'=> 'http://2.cnhjdy.net/assetsj/jshs/pic1.png','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/jshs/pic1.png";}',);
				$var_6251=array('num' =>98,'uniacid' =>$v_1,'cid'=> $var_6390,'pcid'=> $var_6390,'type_x'=> 1,'type'=> 'showPic','type_i'=> 1,'title'=> '弹力绳','thumb'=> 'http://2.cnhjdy.net/assetsj/jshs/pic2.png','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/jshs/pic2.png";}',);
				$var_6252=array('num' =>97,'uniacid' =>$v_1,'cid'=> $var_6390,'pcid'=> $var_6390,'type_x'=> 1,'type'=> 'showPic','type_i'=> 1,'title'=> '哑铃','thumb'=> 'http://2.cnhjdy.net/assetsj/jshs/pic3.png','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/jshs/pic3.png";}',);
				$var_6253=array('num' =>96,'uniacid' =>$v_1,'cid'=> $var_6390,'pcid'=> $var_6390,'type_x'=> 1,'type'=> 'showPic','type_i'=> 1,'title'=> '瑞士球','thumb'=> 'http://2.cnhjdy.net/assetsj/jshs/pic4.png','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/jshs/pic4.png";}',);
				$var_6399=array('num' =>95,'uniacid' =>$v_1,'cid'=> $var_6390,'pcid'=> $var_6390,'type_x'=> 1,'type'=> 'showPic','type_i'=> 1,'title'=> '夹胸器','thumb'=> 'http://2.cnhjdy.net/assetsj/jshs/pic5.png','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/jshs/pic5.png";}',);
				$var_6400=array('num' =>94,'uniacid' =>$v_1,'cid'=> $var_6390,'pcid'=> $var_6390,'type_x'=> 1,'type'=> 'showPic','type_i'=> 1,'title'=> '龙门架','thumb'=> 'http://2.cnhjdy.net/assetsj/jshs/pic6.png','text'=> 'a:1:{i:0;s:46:"http://2.cnhjdy.net/assetsj/jshs/pic6.png";}',);
				Db::table('ims_sudu8_page_products')->insert($var_6250);
				Db::table('ims_sudu8_page_products')->insert($var_6251);
				Db::table('ims_sudu8_page_products')->insert($var_6252);
				Db::table('ims_sudu8_page_products')->insert($var_6253);
				Db::table('ims_sudu8_page_products')->insert($var_6399);
				Db::table('ims_sudu8_page_products')->insert($var_6400);
			}
			$var_6263=array('uniacid' =>$v_1,'forms_style'=> 1,'forms_title_s'=> 'title1','forms_head'=> 'slide','forms_name'=> '预约设体验','forms_ename'=> '','forms_inps'=> 1,'subtime'=> 2,'forms_btn'=> '提交预约','success'=> '您已预约成功！','name'=> '您的姓名','name_must'=> 1,'tel'=> '您的手机号码','tel_use'=> 1,'tel_must'=> 1,date=>'预约日期','date_use'=>1,'date_must'=> 1,time=>'时间','time_use'=>1,'time_must'=> 1,'single_n'=>'健身项目','single_num'=>3,'single_use'=>1,'single_must'=>1,'single_v'=>'力量训练,瑜伽,瘦身美体,自助健身,办会员',);
			$var_6264=Db::table('ims_sudu8_page_forms_config')->where('uniacid',$v_1)->field('uniacid')->find();
			if(empty($var_6264['uniacid']))
			{
				Db::table('ims_sudu8_page_forms_config')->insert($var_6263);
			}
			else
			{
				Db::table('ims_sudu8_page_forms_config')->where('uniacid',$v_1)->update($var_6263);
			}
			$var_6395=array('uniacid' =>$v_1,'num' =>9,'title' =>'满1000立减100','color' =>'#737373','price' =>100,'pay_money' =>1000,'counts' =>999,'xz_count' =>1,'btime' =>1512486016,'etime' =>1534559624,'flag' =>1,);
			if(empty($var_6222['uniacid']))
			{
				Db::table('ims_sudu8_page_coupon')->insert($var_6395);
			}
			else
			{
				Db::table('ims_sudu8_page_coupon')->where('uniacid',$v_1)->update($var_6395);
			}
			$var_6265=array('uniacid' =>$v_1,'index_style' =>'slide','slide' =>'a:2:{i:0;s:48:"http://2.cnhjdy.net/assetsj/jshs/slide1.jpg";i:1;s:48:"http://2.cnhjdy.net/assetsj/jshs/slide2.jpg";}','banner'=>'http://2.cnhjdy.net/assetsj/jshs/logo_bg.jpg','logo'=>'','name' =>'健身会所','desc'=>'健身会所','address' =>'南通世纪大道8888号',time =>'8:30 - 18:00','tel' =>15111111111,'latitude' =>31.983310,'longitude' =>120.946330,'about' =>'健身会所','base_color'=> '#4d4d4d','base_tcolor'=> '#ffffff','base_color2'=> '#414147','base_color_t'=> '#ffffff','config'=>'a:12:{s:7:"newhead";s:1:"0";s:6:"search";s:1:"0";s:6:"bigadT";s:1:"0";s:6:"bigadC";s:1:"0";s:8:"bigadCTC";s:1:"3";s:8:"bigadCNN";s:18:"点击进入首页";s:7:"miniadT";s:1:"0";s:7:"miniadC";s:1:"0";s:7:"miniadN";s:12:"点击进入";s:7:"miniadB";s:12:"点击进入";s:4:"copT";s:1:"0";s:8:"userFood";s:1:"0";}','index_style'=> 'slide','tel_box'=> 1,'aboutCN' =>'教育简介2','aboutCNen' =>'About Company','index_about_title' =>9,'catename_x'=> '行业资讯','catenameen_x'=> 'Industry information','i_b_x_ts'=>9,'i_b_x_iw'=> 500,'catename'=>'春节热门线路','catenameen'=>'','i_b_y_ts'=> 9,'index_pro_lstyle'=> 2,'index_pro_ts_al'=>'tc','c_b_bg'=> 'http://2.cnhjdy.net/assetsj/jshs/server_bg.jpg','c_b_btn'=> 2,'form_index'=> 0,'c_title'=> 2,'video' =>'','v_img' =>'','tabbar_t'=>1,'tabbar_bg'=>'#4d4d4d','color_bar'=>'#000000','tabbar_tc'=>'#ffffff','tabbar_tca'=>'#ffffff','tabbar'=>'a:3:{i:0;s:207:"a:4:{s:8:"tabbar_l";s:5:"index";s:8:"tabbar_t";s:6:"首页";s:9:"tabbar_p1";s:49:"http://2.cnhjdy.net/assetsj/jshs/tabbar1.png";s:9:"tabbar_p2";s:49:"http://2.cnhjdy.net/assetsj/jshs/tabbar1.png";}";i:1;s:213:"a:4:{s:8:"tabbar_l";s:4:"book";s:8:"tabbar_t";s:12:"项目预约";s:9:"tabbar_p1";s:49:"http://2.cnhjdy.net/assetsj/jshs/tabbar2.png";s:9:"tabbar_p2";s:49:"http://2.cnhjdy.net/assetsj/jshs/tabbar2.png";}";i:2;s:220:"a:4:{s:8:"tabbar_l";s:10:"usercenter";s:8:"tabbar_t";s:12:"个人中心";s:9:"tabbar_p1";s:49:"http://2.cnhjdy.net/assetsj/jshs/tabbar3.png";s:9:"tabbar_p2";s:49:"http://2.cnhjdy.net/assetsj/jshs/tabbar3.png";}";}',);
			$var_6266=unserialize($var_6265['slide']);
			foreach($var_6266 as $var_6267=>$var_6268)
			{
				$var_6269['appletid']=$v_1;
				$var_6269['url']=$var_6268;
				$var_6269['dateline']=time();
				Db::table('image_url')->insert($var_6269);
			}
			if(empty($var_6222['uniacid']))
			{
				Db::table('ims_sudu8_page_base')->insert($var_6265);
			}
			else
			{
				Db::table('ims_sudu8_page_base')->where('uniacid',$v_1)->update($var_6265);
			}
		}
		return 1;
	}
}
?>