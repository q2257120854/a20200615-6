<?php
/****************优客365网址导航系统 开源版********************/
/*                                                            */
/*  Youke365.site (C)2017 Youke365 Inc.                       */
/*  This is NOT a freeware, use is subject to license terms   */
/*  优客365网址导航开源版 个人用户可免费使用  请保留底部版权  */
/*  2018.4                                                    */
/*  官方网址：http://www.yunziyuan.com.cn                     */
/*  官方论坛：http://www.yunziyuan.com.cn                        */                           
/**************************************************************/
// 获得广告列表
function get_adver_list($where = 1, $field = 'adver_id', $order = 'DESC', $start = 0, $pagesize = 0) 
{
	global $Db;	
	$sql = "SELECT * FROM ".table('advers')." WHERE $where ORDER BY $field $order LIMIT $start,$pagesize";
	$resData = $Db->query($sql);
	
	return $resData;
}
	
// 获取一条广告信息
function get_one_adver($adver_id) 
{
	global $Db;
	
	$sql = "SELECT * FROM ".table('advers')." WHERE adver_id=$adver_id LIMIT 1";
	$resData = $Db->query($sql,"Row");
	
	return $resData;
}

// 广告选项类型
function get_adtype_option($adtype = 0) 
{
	$types = array('0' => '所有类型', '1' => '文字链接', '2' => '广告代码');
	
	$option = '';
	foreach ($types as $key => $val) {
		$option .= '<option value="'.$key.'"';
		if ($adtype == $key) {
			$option .= ' selected';
		}
		$option .= '>'.$val.'</option>';
	}
	
	return $option;
}

// 获得所有广告
function get_all_adver() 
{
	global $Db;
	
	$sql = "SELECT * FROM ".table('advers')." ORDER BY adver_id ASC";
	$query = $Db->query($sql);
	$resData = array();
	foreach($query as $row){
		$resData[$row['adver_id']] = $row;
	}
	unset($row);
	
		
	return $resData;
}

// 调用获得广告
function get_adver($type = 1) 
{
	global $Db;
	
	$advers  = get_all_adver();
	$resData = [];
	foreach ($advers as $aid => $ad) {
		//广告必须开启
		if ($ad['adver_type'] == $type && $ad['adver_status'] == 1) {
			$resData[$aid] = $ad;
		}
	}
	unset($advers);

	return $resData;
}


function get_adcode($aid = 0) 
{
	    $ad = get_one_adver($aid);
	    if($ad['adver_status'] ==1){
		         $ad_code = stripslashes($ad['adver_code']);
				$ad_tips = $ad['adver_etips'];
				$ad_days = $ad['adver_days'];
				$ad_date = $ad['adver_date'];
				
				$endtime = $ad_date + $ad_days * 24 * 3600;
				if ($ad_days > 0) {
					return $endtime > $adver['adver_date'] ? $ad_code : $ad_tips;
				} else {
					return $ad_code;
				}   

	    }
	 

}
