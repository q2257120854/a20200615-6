<?php
namespace Houtai\Common\help;
/**
 * 处理无限级分类
 */
class Category{
    /**
     * [递归一维数组]
     * @param  [type] $cate  [传递一个数组$cate]
     * @param  string $html  [标示符]
     * @param  [type] $pid   [所属哪个类]
     * @param  [type] $level [等级]
     * @return [type]        [把数组返回出去]
     */
    static function curl($url)
	{
		$UserAgent = 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1';
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}
}
//http://www.thinkphp.cn/topic/13132.html