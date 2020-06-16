<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Menu extends Base
{
    public function index(){
        if(check_login()){
        	if(powerget()){
        		$appletid = input("appletid");
        		$res = Db::table('applet')->where("id",$appletid)->find();
                if(!$res){
                    $this->error("找不到对应的小程序！");
                }
        		$this->assign('applet',$res);
                $bases = Db::table('ims_sudu8_page_base')->where("uniacid",$appletid)->find();
                $item['tabbar'] = unserialize($bases['tabbar']);
                if($item['tabbar']){
                    $count = count($item['tabbar']);
                }else{
                    $count = 0;
                    $items = "";
                }
                if($count>0){
          
                    $items[] = unserialize($item['tabbar'][0]);
                    if(!isset($items[0]['tabbar_url'])){
                        $items[0]['tabbar_url'] = "";
                    }
                }
                if($count>1){
                
                    $items[] = unserialize($item['tabbar'][1]);
                    if(!isset($items[1]['tabbar_url'])){
                        $items[1]['tabbar_url'] = "";
                    }
                }
                if($count>2){
                  
                    $items[] = unserialize($item['tabbar'][2]);
                    if(!isset($items[2]['tabbar_url'])){
                        $items[2]['tabbar_url'] = "";
                    }
                }
                if($count>3){
                 
                    $items[] = unserialize($item['tabbar'][3]);
                    if(!isset($items[3]['tabbar_url'])){
                        $items[3]['tabbar_url'] = "";
                    }
                }
                if($count>4){
                  
                    $items[] = unserialize($item['tabbar'][4]);
                    if(!isset($items[4]['tabbar_url'])){
                        $items[4]['tabbar_url'] = "";
                    }
                }
                $cate = Db::table('ims_sudu8_page_cate')->where("uniacid",$appletid)->order('num desc')->select();
                $this->assign('tabbar',$items);
                $this->assign('count',$count);
                $this->assign('bases',$bases);
                $this->assign('cate',$cate);
        	}else{
        		$usergroup = Session::get('usergroup');
        		if($usergroup==1){
        			$this->error("您没有权限操作该小程序或找不到相应小程序！",'Applet/applet');
        		}
        		if($usergroup==2){
        			$this->error("您没有权限操作该小程序或找不到相应小程序！",'Applet/index');
        		}
                if($usergroup==3){
                    $this->error("您没有权限操作该小程序或找不到相应小程序！",'Applet/index');
                }
        	}
            return $this->fetch('index');
        }else{
            $this->redirect('Login/index');
        }
    }
    public function newfoot(){
        if(check_login()){
            if(powerget()){
                $appletid = input("appletid");
                $res = Db::table('applet')->where("id",$appletid)->find();
                if(!$res){
                    $this->error("找不到对应的小程序！");
                }
                $this->assign('applet',$res);
                $item = Db::table('ims_sudu8_page_base')->where("uniacid",$appletid)->find();
                $item['tabbar'] = unserialize($item['tabbar_new']);
                if(!$item['tabbar']){
                    $item1 = "";
                    $item2 = "";
                    $item3 = "";
                    $item4 = "";
                    $item5 = "";
                }
                if(isset($item['tabbar'][0]) && $item['tabbar'][0]){
                    $item['tabbar'][0] = unserialize($item['tabbar'][0]);
                    $item1 = $item['tabbar'][0];
                }else{
                    $item1 = "";
                }
                if(isset($item['tabbar'][1]) && $item['tabbar'][1]){
                    $item['tabbar'][1] = unserialize($item['tabbar'][1]);
                    $item2 = $item['tabbar'][1];
                }else{
                    $item2 = "";
                }
                if(isset($item['tabbar'][2]) && $item['tabbar'][2]){
                    $item['tabbar'][2] = unserialize($item['tabbar'][2]);
                    $item3 = $item['tabbar'][2];
                }else{
                    $item3 = "";
                }
                if(isset($item['tabbar'][3]) && $item['tabbar'][3]){
                    $item['tabbar'][3] = unserialize($item['tabbar'][3]);
                    $item4 = $item['tabbar'][3];
                }else{
                    $item4 = "";
                }
                if(isset($item['tabbar'][4]) && $item['tabbar'][4]){
                    $item['tabbar'][4] = unserialize($item['tabbar'][4]);
                    $item5 = $item['tabbar'][4];
                }else{
                    $item5 = "";
                }
                $this->assign('item1',$item1);
                $this->assign('item2',$item2);
                $this->assign('item3',$item3);
                $this->assign('item4',$item4);
                $this->assign('item5',$item5);
                $this->assign('bases',$item);
            }else{
                $usergroup = Session::get('usergroup');
                if($usergroup==1){
                    $this->error("您没有权限操作该小程序或找不到相应小程序！",'Applet/applet');
                }
                if($usergroup==2){
                    $this->error("您没有权限操作该小程序或找不到相应小程序！",'Applet/index');
                }
                if($usergroup==3){
                    $this->error("您没有权限操作该小程序或找不到相应小程序！",'Applet/index');
                }
            }
            return $this->fetch('new');
        }else{
            $this->redirect('Login/index');
        }
    }
    public function savenew(){
            $appletid = input("appletid");
            $tabbar = array();
            $tabbar1=array(
            'tabbar_name' => input('tabbar1_name'),
            'tabbar_url' => input('tabbar1_url'),
            'tabbar_linktype' => input('tabbar1_linktype')?input('tabbar1_linktype'):'page',
            'tabbar' =>input('tabbar1')?input('tabbar1'):1
            );
            if(input('tabbar1')==2){
                $tabbar1['tabimginput_1'] = input('tabimginput1_3');
            }else{
                $tabbar1['tabimginput_1'] = input('tabimginput1_1');
                $tabbar1['tabimginput_2'] = input('tabimginput1_2');
            }
            $tabbar2=array(
            'tabbar_name' => input('tabbar2_name'),
            'tabbar_url' => input('tabbar2_url'),
            'tabbar_linktype' => input('tabbar2_linktype')?input('tabbar2_linktype'):'page',
            'tabbar' => input('tabbar2')?input('tabbar2'):1
            );
            if(input('tabbar2')==2){
                $tabbar2['tabimginput_1'] = input('tabimginput2_3');
            }else{
                $tabbar2['tabimginput_1'] = input('tabimginput2_1');
                $tabbar2['tabimginput_2'] = input('tabimginput2_2');
            }
            $tabbar3=array(
            'tabbar_name' => input('tabbar3_name'),
            'tabbar_url' => input('tabbar3_url'),
            'tabbar_linktype' => input('tabbar3_linktype')?input('tabbar3_linktype'):'page',
            'tabbar' => input('tabbar3')?input('tabbar3'):1
            );
            if(input('tabbar3') ==2){
                $tabbar3['tabimginput_1'] = input('tabimginput3_3');
            }else{
                $tabbar3['tabimginput_1'] = input('tabimginput3_1');
                $tabbar3['tabimginput_2'] = input('tabimginput3_2');
            }
            $tabbar4=array(
            'tabbar_name' => input('tabbar4_name'),
            'tabbar_url' => input('tabbar4_url'),
            'tabbar_linktype' => input('tabbar4_linktype')?input('tabbar4_linktype'):'page',
            'tabbar' => input('tabbar4')?input('tabbar4'):1
            );
            if(input('tabbar4')==2){
                $tabbar4['tabimginput_1'] = input('tabimginput4_3');
            }else{
                $tabbar4['tabimginput_1'] = input('tabimginput4_1');
                $tabbar4['tabimginput_2'] = input('tabimginput4_2');
            }
            $tabbar5=array(
            'tabbar_name' => input('tabbar5_name'),
            'tabbar_url' => input('tabbar5_url'),
            'tabbar_linktype' => input('tabbar5_linktype')?input('tabbar5_linktype'):'page',
            'tabbar' => input('tabbar5')?input('tabbar5'):1
            );
            if(input('tabbar5')==2){
                $tabbar5['tabimginput_1'] = input('tabimginput5_3');
            }else{
                $tabbar5['tabimginput_1'] = input('tabimginput5_1');
                $tabbar5['tabimginput_2'] = input('tabimginput5_2');
            }
            $tabbar1 = serialize($tabbar1);
            $tabbar2 = serialize($tabbar2);
            $tabbar3 = serialize($tabbar3);
            $tabbar4 = serialize($tabbar4);
            $tabbar5 = serialize($tabbar5);
            if(input('tabbar1_url') != ''){
                $tabbar[0]=$tabbar1;
            }
            if(input('tabbar2_url') != ''){
                $tabbar[1]=$tabbar2;
            }
            if(input('tabbar3_url') != ''){
                $tabbar[2]=$tabbar3;
            }
            if(input('tabbar4_url') != ''){
                $tabbar[3]=$tabbar4;
            }
            if(input('tabbar5_url') != ''){
                $tabbar[4]=$tabbar5;
            }
            $tabnum = count($tabbar);
            if($tabnum === 0){
                $tabbar = "";
            }else{
                $tabbar = serialize($tabbar);
            }
            $data = array(
                'uniacid' => $appletid,
                'tabbar_t' => input('tabbar_t'),
                'tabbar_bg' => input('tabbar_bg'),
                'color_bar' => input('color_bar'),
                'tabbar_tc' => input('tabbar_tc'),
                'tabbar_tca'=>input('tabbar_tca'),
                'tabnum_new' => intval($tabnum),
                'tabbar_new' => $tabbar,
            );
            
  
            $res =  Db::table("ims_sudu8_page_base")->where("uniacid",$appletid)->update($data);
        if($res){
          $this->success('底部菜单更新成功！');
        }else{
          $this->error('底部菜单更新失败，没有修改项！');
          exit;
        }
    }
    public function save(){
    	$appletid = input("appletid");
        
        $data = array();
        //小程序ID
        $data['uniacid'] = input("appletid");
        $tabbar_t = input("tabbar_t");
        if($tabbar_t){
            $data['tabbar_t'] = $tabbar_t;
        }else{
            $data['tabbar_t'] = 0;
        }
        //菜单栏背景色
        $tabbar_bg = input("tabbar_bg");
        if($tabbar_bg){
            $data['tabbar_bg'] = "#".$tabbar_bg;
        }
        //菜单栏横线颜色
        $color_bar = input("color_bar");
        if($color_bar){
            $data['color_bar'] = "#".$color_bar;
        }
        //菜单栏文字颜色
        $tabbar_tc = input("tabbar_tc");
        if($tabbar_tc){
            $data['tabbar_tc'] = "#".$tabbar_tc;
        }
        //菜单栏文字颜色
        $tabbar_tca = input("tabbar_tca");
        if($tabbar_tca){
            $data['tabbar_tca'] = "#".$tabbar_tca;
        }
        //搜索当前的基本信息
        $isyou = 0;
        $bases = Db::table('ims_sudu8_page_base')->where("uniacid",$appletid)->find();
        if($bases){
            $isyou = 1;
            $item['tabbar'] = unserialize($bases['tabbar']);
            $tabbarcount = count($item['tabbar']);
            if($tabbarcount>0){
                $items1 = unserialize($item['tabbar'][0]);
            }
            if($tabbarcount>1){
                $items2 = unserialize($item['tabbar'][1]);
            }
            if($tabbarcount>2){
                $items3 = unserialize($item['tabbar'][2]);
            }
            if($tabbarcount>3){
                $items4 = unserialize($item['tabbar'][3]);
            }
            if($tabbarcount>4){
               $items5 = unserialize($item['tabbar'][4]);
            }
        }else{
            $isyou = 0;
        }
        
        $button1 = array();
        $button2 = array();
        $button3 = array();
        $button4 = array();
        $button5 = array();
        // 按钮1的数据
        //内容
        $button1['tabbar_l'] = input("tabbar1_l");
        //名称
        $tabbar1_t = input("tabbar1_t");
        if($tabbar1_t){
            $button1['tabbar_t'] = $tabbar1_t;
        }else{
            if($isyou==1 && $tabbarcount>0){
                $button1['tabbar_t'] = $items1['tabbar_t'];
            }else{
                $button1['tabbar_t'] = "";
            }    
        }
        //url地址
        $tabbar_url = input("tabbar1_url");
        if($tabbar_url){
            $button1['tabbar_url'] = $tabbar_url;
        }else{
            // if($isyou==1 && $tabbarcount>0){
            //     $button1['tabbar_url'] = $items1['tabbar_url'];
            // }else{
                $button1['tabbar_url'] = "";
            // }    
        }
        //图标1
        $tabbar1_p1 = $this->onepic_uploade("tabbar1_p1");
        $isyc11 = input("isyc11");
        if($tabbar1_p1){
            $button1['tabbar_p1'] = $tabbar1_p1;   //有图片上传
        }else{
            if($isyc11==1){
                $button1['tabbar_p1'] = "";
            }else{
                if($isyou==1 && $tabbarcount>0){
                    $button1['tabbar_p1'] = $items1['tabbar_p1'];
                }else{
                    $button1['tabbar_p1'] = "";
                }   
            }
            
        }
        // echo "<pre>";
        // var_dump($isyc11);
        // var_dump($button1['tabbar_p1']);
        // echo "</pre>";
        // die();
        //图标2
        $tabbar1_p2 = $this->onepic_uploade("tabbar1_p2");
        $isyc12 = input("isyc12");
        if($tabbar1_p2){
            $button1['tabbar_p2'] = $tabbar1_p2;
        }else{
            if($isyc12==1){
                $button1['tabbar_p2'] = "";
            }else{
            if($isyou==1 && $tabbarcount>0){
                $button1['tabbar_p2'] = $items1['tabbar_p2'];
            }else{
                $button1['tabbar_p2'] = "";
            }   
        }
        }
        // echo "<pre>";
        // var_dump($isyc12);
        // var_dump($button1['tabbar_p2']);
        // echo "</pre>";
        // die();
        // 按钮2的数据
        //内容
        $button2['tabbar_l'] = input("tabbar2_l");
        //名称
        $tabbar2_t = input("tabbar2_t");
        if($tabbar2_t){
            $button2['tabbar_t'] = $tabbar2_t;
        }else{
            if($isyou==1 && $tabbarcount>1){
                $button2['tabbar_t'] = $items2['tabbar_t'];
            }else{
                $button2['tabbar_t'] = "";
            }   
        }
        //url地址
        $tabbar_url = input("tabbar2_url");
        if($tabbar_url){
            $button2['tabbar_url'] = $tabbar_url;
        }else{
            // if($isyou==1 && $tabbarcount>0){
            //     $button2['tabbar_url'] = $items1['tabbar_url'];
            // }else{
                $button2['tabbar_url'] = "";
            // }    
        }
        //图标1
        $tabbar2_p1 = $this->onepic_uploade("tabbar2_p1");
         $isyc21 = input("isyc21");
        if($tabbar2_p1){
            $button2['tabbar_p1'] = $tabbar2_p1;
        }
        else{
            if($isyc21==1){
                $button2['tabbar_p1'] = "";
            }else{
            if($isyou==1 && $tabbarcount>1){
                $button2['tabbar_p1'] = $items2['tabbar_p1'];
            }else{
                $button2['tabbar_p1'] = "";
            } 
        }
        }
        //图标2
        $tabbar2_p2 = $this->onepic_uploade("tabbar2_p2");
        $isyc22 = input("isyc22");
        if($tabbar2_p2){
            $button2['tabbar_p2'] = $tabbar2_p2;
        }
        else{
            if($isyc22==1){
                $button2['tabbar_p2'] = "";
            }else{
            if($isyou==1 && $tabbarcount>1){
                $button2['tabbar_p2'] = $items2['tabbar_p2'];
            }else{
                $button2['tabbar_p2'] = "";
            } 
        }
        }
        // 按钮3的数据
        //内容
        $button3['tabbar_l'] = input("tabbar3_l");
        //名称
        $tabbar3_t = input("tabbar3_t");
        if($tabbar3_t){
            $button3['tabbar_t'] = $tabbar3_t;
        }else{
            if($isyou==1 && $tabbarcount>2){
                $button3['tabbar_t'] = $items3['tabbar_t'];
            }else{
                $button3['tabbar_t'] = "";
            } 
        }
        //url地址
        $tabbar_url = input("tabbar3_url");
        if($tabbar_url){
            $button3['tabbar_url'] = $tabbar_url;
        }else{
            // if($isyou==1 && $tabbarcount>0){
            //     $button3['tabbar_url'] = $items1['tabbar_url'];
            // }else{
                $button3['tabbar_url'] = "";
            // }    
        }
        //图标1
        $tabbar3_p1 = $this->onepic_uploade("tabbar3_p1");
         $isyc31 = input("isyc31");
        if($tabbar3_p1){
            $button3['tabbar_p1'] = $tabbar3_p1;
        }else{
            if($isyc31==1){
                $button3['tabbar_p1'] = "";
            }else{
            if($isyou==1 && $tabbarcount>2){
                $button3['tabbar_p1'] = $items3['tabbar_p1'];
            }else{
                $button3['tabbar_p1'] = "";
            } 
        }
        }
        //图标2
        $tabbar3_p2 = $this->onepic_uploade("tabbar3_p2");
         $isyc32 = input("isyc32");
        if($tabbar3_p2){
            $button3['tabbar_p2'] = $tabbar3_p2;
        }else{
            if($isyc32==1){
                $button3['tabbar_p2'] = "";
            }else{
            if($isyou==1 && $tabbarcount>2){
                $button3['tabbar_p2'] = $items3['tabbar_p2'];
            }else{
                $button3['tabbar_p2'] = "";
            } 
        }
        }
        // 按钮4的数据
        //内容
        $button4['tabbar_l'] = input("tabbar4_l");
        //名称
        $tabbar4_t = input("tabbar4_t");
        if($tabbar4_t){
            $button4['tabbar_t'] = $tabbar4_t;
        }else{
            if($isyou==1 && $tabbarcount>3){
                $button4['tabbar_t'] = $items4['tabbar_t'];
            }else{
                $button4['tabbar_t'] = "";
            } 
        }
        //url
        $tabbar_url = input("tabbar4_url");
        if($tabbar_url){
            $button4['tabbar_url'] = $tabbar_url;
        }else{
            // if($isyou==1 && $tabbarcount>0){
            //     $button4['tabbar_url'] = $items1['tabbar_url'];
            // }else{
                $button4['tabbar_url'] = "";
            // }    
        }
        //图标1
        $tabbar4_p1 = $this->onepic_uploade("tabbar4_p1");
         $isyc41 = input("isyc41");
        if($tabbar4_p1){
            $button4['tabbar_p1'] = $tabbar4_p1;
        }else{
            if($isyc41==1){
                $button4['tabbar_p1'] = "";
            }else{
            if($isyou==1 && $tabbarcount>3){
                $button4['tabbar_p1'] = $items4['tabbar_p1'];
            }else{
                $button4['tabbar_p1'] = "";
            } 
        }
        }
        //图标
        $tabbar4_p2 = $this->onepic_uploade("tabbar4_p2");
         $isyc42 = input("isyc42");
        if($tabbar4_p2){
            $button4['tabbar_p2'] = $tabbar4_p2;
        }else{
            if($isyc42==1){
                $button4['tabbar_p2'] = "";
            }else{
            if($isyou==1 && $tabbarcount>3){
                $button4['tabbar_p2'] = $items4['tabbar_p2'];
            }else{
                $button4['tabbar_p2'] = "";
            } 
        }
        }
        // 按钮5的数据
        //内容
        $button5['tabbar_l'] = input("tabbar5_l");
        //名称
        $tabbar5_t = input("tabbar5_t");
        if($tabbar5_t){
            $button5['tabbar_t'] = $tabbar5_t;
        }else{
            if($isyou==1 && $tabbarcount>4){
                $button5['tabbar_t'] = $items5['tabbar_t'];
            }else{
                $button5['tabbar_t'] = "";
            } 
        }
        //url
        $tabbar_url = input("tabbar5_url");
        if($tabbar_url){
            $button5['tabbar_url'] = $tabbar_url;
        }else{
            // if($isyou==1 && $tabbarcount>0){
            //     $button5['tabbar_url'] = $items1['tabbar_url'];
            // }else{
                $button5['tabbar_url'] = "";
            // }    
        }
        //图标1
        $tabbar5_p1 = $this->onepic_uploade("tabbar5_p1");
         $isyc51 = input("isyc51");
        if($tabbar5_p1){
            $button5['tabbar_p1'] = $tabbar5_p1;
        }else{
            if($isyc51==1){
                $button5['tabbar_p1'] = "";
            }else{
            if($isyou==1 && $tabbarcount>4){
                $button5['tabbar_p1'] = $items5['tabbar_p1'];
            }else{
                $button5['tabbar_p1'] = "";
            } 
        }
        }
        //图标2
        $tabbar5_p2 = $this->onepic_uploade("tabbar5_p2");
         $isyc52 = input("isyc52");
        if($tabbar5_p2){
            $button5['tabbar_p2'] = $tabbar5_p2;
        }else{
            if($isyc52==1){
                $button5['tabbar_p2'] = "";
            }else{
            if($isyou==1 && $tabbarcount>4){
                $button5['tabbar_p2'] = $items5['tabbar_p2'];
            }else{
                $button5['tabbar_p2'] = "";
            } 
        }
        }
        $tabbar1 = serialize($button1);
        $tabbar2 = serialize($button2);
        $tabbar3 = serialize($button3);
        $tabbar4 = serialize($button4);
        $tabbar5 = serialize($button5);
        $tabbar = array();
        if(input("tabbar1_l") != 'none'){
            $tabbar[]=$tabbar1;
        }
        if(input("tabbar2_l") != 'none'){
            $tabbar[]=$tabbar2;
        }
        if(input("tabbar3_l") != 'none'){
            $tabbar[]=$tabbar3;
        }
        if(input("tabbar4_l") != 'none'){
            $tabbar[]=$tabbar4;
        }
        if(input("tabbar5_l") != 'none'){
            $tabbar[]=$tabbar5;
        }
        $data['tabnum'] = count($tabbar);
        $data['tabbar'] = serialize($tabbar);
        // echo "<pre>";
        // var_dump($data);
        // echo "</pre>";
        // die();
        
        $bases = Db::table('ims_sudu8_page_base')->where("uniacid",$appletid)->count();
        if($bases>0){
            $res = Db::table('ims_sudu8_page_base')->where("uniacid",$appletid)->update($data);
        }else{
            $data['uniacid'] = $appletid;
            $res = Db::table('ims_sudu8_page_base')->insert($data);
        }
        if($res){
          $this->success('基础信息更新成功！');
        }else{
          $this->error('基础信息更新失败，没有修改项！');
          exit;
        }
    }
    //单个图片上传操作
    function onepic_uploade($file){
        $thumb = request()->file($file);
        if(isset($thumb)){
            $dir = upload_img();
            $info = $thumb->validate(['ext'=>'jpg,png,gif,jpeg'])->move($dir); 
            if($info){  
                $imgurl = ROOT_HOST."/upimages/".date("Ymd",time())."/".$info->getFilename();
                return $imgurl;
            }  
        }
    }
}