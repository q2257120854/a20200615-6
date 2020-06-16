<?php 
   /**
      * 权限验证
      * @param rule string|array  需要验证的规则列表,支持逗号分隔的权限规则或索引数组
      * @param uid  int           认证用户的id
      * @param string mode        执行check的模式
      * @param relation string    如果为 'or' 表示满足任一条规则即通过验证;如果为 'and'则表示需满足所有规则才能通过验证
      * @return boolean           通过验证返回true;失败返回false
     */
    function authCheck($rule,$uid,$type=1, $mode='url', $relation='or'){
        //超级管理员跳过验证
        $auth=new \Think\Auth();
        //获取当前uid所在的角色组id

        if(in_array($uid, C('ADMINISTRATOR'))){
            return true;
        }else{
            return $auth->check($rule,$uid,$type,$mode,$relation)?true:false;
        }
    }

    /**
      * 取得指定时间戳在当天的开始时间戳或结束时间戳
      * @param time int         指定的时间戳
      * @param state  int       0：获取当天开始时间戳  1：获取当天最后时间戳
      * @return times int       返回结果 时间戳
      * @return author          aifece  244154198@qq.com
     */
    function timeSets($time,$state=0){
        $time = explode('-', $time);
        if ($state == 0) {
            $times = mktime(0,0,0,$time[1],$time[2],$time[0]);
        }else{
            $times = mktime(23,59,59,$time[1],$time[2],$time[0]);
        }
        return $times;
    }

    /**
      * 出去多维数组重复值
      * @param array  array     多维数组
      * @return newarr array    去除重复值后 新的数组
      * @return author          aifece  244154198@qq.com
     */
    function arr_unique($array){
        $newarr = array();
        foreach($array as $key=>$v){
            if(!in_array($v, $newarr)){
              $newarr[$key]=$v;
            }
        }
        return $newarr;
    }

    /**
      * 获取品牌的第一个字母
      * @param str  string      字符串
      * @return str             返回一个大写字母
      * @return author          aifece  244154198@qq.com
     */
    function getFirstChar($str){
        $firstchar_ord=ord(strtoupper($str{0}));
        if (($firstchar_ord>=65 and $firstchar_ord<=91)or($firstchar_ord>=48 and $firstchar_ord<=57)) 
            return $str{0}; 
        $s=iconv("UTF-8","gb2312", $str); 
        $asc=ord($s{0})*256+ord($s{1})-65536; 
        if($asc>=-20319 and $asc<=-20284)
            return "A"; 
        if($asc>=-20283 and $asc<=-19776)
            return "B"; 
        if($asc>=-19775 and $asc<=-19219)
            return "C"; 
        if($asc>=-19218 and $asc<=-18711)
            return "D"; 
        if($asc>=-18710 and $asc<=-18527)
            return "E"; 
        if($asc>=-18526 and $asc<=-18240)
            return "F"; 
        if($asc>=-18239 and $asc<=-17923)
            return "G"; 
        if($asc>=-17922 and $asc<=-17418)
            return "H"; 
        if($asc>=-17417 and $asc<=-16475)
            return "J"; 
        if($asc>=-16474 and $asc<=-16213)
            return "K"; 
        if($asc>=-16212 and $asc<=-15641)
            return "L"; 
        if($asc>=-15640 and $asc<=-15166)
            return "M"; 
        if($asc>=-15165 and $asc<=-14923)
            return "N"; 
        if($asc>=-14922 and $asc<=-14915)
            return "O"; 
        if($asc>=-14914 and $asc<=-14631)
            return "P"; 
        if($asc>=-14630 and $asc<=-14150)
            return "Q"; 
        if($asc>=-14149 and $asc<=-14091)
            return "R"; 
        if($asc>=-14090 and $asc<=-13319)
            return "S"; 
        if($asc>=-13318 and $asc<=-12839)
            return "T"; 
        if($asc>=-12838 and $asc<=-12557)
            return "W"; 
        if($asc>=-12556 and $asc<=-11848)
            return "X"; 
        if($asc>=-11847 and $asc<=-11056)
            return "Y"; 
        if($asc>=-11055 and $asc<=-10247)
            return "Z"; 
        return null; 
    } 
    
    
    //支付方式
    
    function paytype($type){
    	$str='';
    	switch ($type){
    		case 0:$str='未支付';break;
    		case 1:$str='微信支付';break;
    		case 2:$str='支付宝支付';break;
    		case 3:$str='货到付款';break;
    	}
    	return $str;
    }
    
    
    
    
    
    
    
    
    
    
    
    
