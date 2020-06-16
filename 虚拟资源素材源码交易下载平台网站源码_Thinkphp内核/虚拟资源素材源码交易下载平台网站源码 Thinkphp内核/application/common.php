<?php

use app\common\Hook;
use Captcha\Captcha;
use org\Http;
use PHPMailer\PHPMailer\PHPMailer;
use think\Cache;
use think\Db;
use think\Loader;
use think\Request;
use think\Url;

function systemSetKey($user = '')
{
    if (is_array($user) && !empty($user)) {
        cookie('sys_key', encrypt(serialize($user)), 3600);
    }
}

function catenamebyid($id)
{
    $name = Db::name('forumcate')->where('id', $id)->value('name');

    return $name;
}

function arttmplbyid($id)
{
    if ($id == 0) {
        return '无此文章';
    } else {
        $children = Db::name('article')->alias('a')->join('articlecate c', 'c.id=a.tid')->where('a.id', $id)->find();

        if (empty($children)) {

            return '无此文章';
        } else {
            return $children['template'];
        }

    }
}

/**
 * 加密函数
 * @param string $txt 需要加密的字符串
 * @param string $key 密钥
 * @return string 返回加密结果
 */
function encrypt($txt, $key = '')
{
    if (empty($txt)) {
        return $txt;
    }

    if (empty($key)) {
        $salt = Db::name('admin_user')->where('id', 1)->value('salt');
        $key = md5($salt);
    }
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
    $ikey = "-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";
    $nh1 = rand(0, 64);
    $nh2 = rand(0, 64);
    $nh3 = rand(0, 64);
    $ch1 = $chars{$nh1};
    $ch2 = $chars{$nh2};
    $ch3 = $chars{$nh3};
    $nhnum = $nh1 + $nh2 + $nh3;
    $knum = 0;
    $i = 0;
    while (isset($key{$i})) {
        $knum += ord($key{$i++});
    }

    $mdKey = substr(md5(md5(md5($key . $ch1) . $ch2 . $ikey) . $ch3), $nhnum % 8, $knum % 8 + 16);
    $txt = base64_encode(time() . '_' . $txt);
    $txt = str_replace(array('+', '/', '='), array('-', '_', '.'), $txt);
    $tmp = '';
    $j = 0;
    $k = 0;
    $tlen = strlen($txt);
    $klen = strlen($mdKey);
    for ($i = 0; $i < $tlen; $i++) {
        $k = $k == $klen ? 0 : $k;
        $j = ($nhnum + strpos($chars, $txt{$i}) + ord($mdKey{$k++})) % 64;
        $tmp .= $chars{$j};
    }
    $tmplen = strlen($tmp);
    $tmp = substr_replace($tmp, $ch3, $nh2 % ++$tmplen, 0);
    $tmp = substr_replace($tmp, $ch2, $nh1 % ++$tmplen, 0);
    $tmp = substr_replace($tmp, $ch1, $knum % ++$tmplen, 0);
    return $tmp;
}

/**
 * 解密函数
 * @param string $txt 需要解密的字符串
 * @param string $key 密匙
 * @return string 字符串类型的返回结果
 */
function decrypt($txt, $key = '', $ttl = 0)
{
    if (empty($txt)) {
        return $txt;
    }

    if (empty($key)) {
        $salt = Db::name('admin_user')->where('id', 1)->value('salt');
        $key = md5($salt);
    }
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
    $ikey = "-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";
    $knum = 0;
    $i = 0;
    $tlen = @strlen($txt);
    while (isset($key{$i})) {
        $knum += ord($key{$i++});
    }

    $ch1 = @$txt{$knum % $tlen};
    $nh1 = strpos($chars, $ch1);
    $txt = @substr_replace($txt, '', $knum % $tlen--, 1);
    $ch2 = @$txt{$nh1 % $tlen};
    $nh2 = @strpos($chars, $ch2);
    $txt = @substr_replace($txt, '', $nh1 % $tlen--, 1);
    $ch3 = @$txt{$nh2 % $tlen};
    $nh3 = @strpos($chars, $ch3);
    $txt = @substr_replace($txt, '', $nh2 % $tlen--, 1);
    $nhnum = $nh1 + $nh2 + $nh3;
    $mdKey = substr(md5(md5(md5($key . $ch1) . $ch2 . $ikey) . $ch3), $nhnum % 8, $knum % 8 + 16);
    $tmp = '';
    $j = 0;
    $k = 0;
    $tlen = @strlen($txt);
    $klen = @strlen($mdKey);
    for ($i = 0; $i < $tlen; $i++) {
        $k = $k == $klen ? 0 : $k;
        $j = strpos($chars, $txt{$i}) - $nhnum - ord($mdKey{$k++});
        while ($j < 0) {
            $j += 64;
        }

        $tmp .= $chars{$j};
    }
    $tmp = str_replace(array('-', '_', '.'), array('+', '/', '='), $tmp);
    $tmp = trim(base64_decode($tmp));
    if (preg_match("/\d{10}_/s", substr($tmp, 0, 11))) {
        if ($ttl > 0 && (time() - substr($tmp, 0, 11) > $ttl)) {
            $tmp = null;
        } else {
            $tmp = substr($tmp, 11);
        }
    }
    return $tmp;
}

function captcha($id = "", $config = [])
{
    $captcha = new \think\captcha\Captcha($config);
    return $captcha->entry($id);
}

/**
 * @param $id
 * @return string
 */
function captcha_src($id = "")
{
    return \think\Url::build('/captcha' . ($id ? "/{$id}" : ''));
}

/**
 * @param $id
 * @return mixed
 */
function captcha_img($id = "")
{
    return '<img src="' . captcha_src($id) . '" alt="captcha" />';
}

/**
 * @param        $value
 * @param string $id
 * @param array $config
 * @return bool
 */
function captcha_check($value, $id = "", $config = [])
{
    $captcha = new Captcha($config);
    return $captcha->check($value, $id);
}

/**
 * @param        $value
 * @param string $id
 * @param array $config
 * @return bool
 */
function sms_code_check($value,$mobile, $type='REG')
{   
    $where['content']=$value;
    $where['status']=1;
    $where['created_at']=['gt',date('Y-m-d H:i:s',time()-600)];
    $where['mobile']=['eq',$mobile];
    $find=Db::name('sms')->where($where)->find();
    if(!$find){
        return false;
    }
    return $find['id'];
}

/**
 * 签名字符串
 * @param $prestr 需要签名的字符串
 * @param $key 私钥
 * return 签名结果
 */
function md5Sign($prestr, $key)
{
    $prestr = $prestr . $key;
    return md5($prestr);
}

/**
 * 验证签名
 * @param $prestr 需要签名的字符串
 * @param $sign 签名结果
 * @param $key 私钥
 * return 签名结果
 */
function md5Verify($prestr, $sign, $key)
{
    $prestr = $prestr . $key;
    $mysgin = md5($prestr);

    if ($mysgin == $sign) {
        return true;
    } else {
        return false;
    }
}

/**
 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
 * @param $para 需要拼接的数组
 * return 拼接完成以后的字符串
 */
function createLinkstring($para)
{
    $arg = "";
    while (list($key, $val) = each($para)) {
        $arg .= $key . "=" . $val . "&";
    }
    //去掉最后一个&字符
    $arg = substr($arg, 0, count($arg) - 2);

    //如果存在转义字符，那么去掉转义
    if (get_magic_quotes_gpc()) {
        $arg = stripslashes($arg);
    }

    return $arg;
}

/**
 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
 * @param $para 需要拼接的数组
 * return 拼接完成以后的字符串
 */
function createLinkstringUrlencode($para)
{
    $arg = "";
    while (list($key, $val) = each($para)) {
        $arg .= $key . "=" . urlencode($val) . "&";
    }
    //去掉最后一个&字符
    $arg = substr($arg, 0, count($arg) - 2);

    //如果存在转义字符，那么去掉转义
    if (get_magic_quotes_gpc()) {
        $arg = stripslashes($arg);
    }

    return $arg;
}

/**
 * 除去数组中的空值和签名参数
 * @param $para 签名参数组
 * return 去掉空值与签名参数后的新签名参数组
 */
function paraFilter($para)
{
    $para_filter = array();
    while (list($key, $val) = each($para)) {
        if ($key == "sign" || $key == "sign_type" || $val == "") {
            continue;
        } else {
            $para_filter[$key] = $para[$key];
        }

    }
    return $para_filter;
}

/**
 * 对数组排序
 * @param $para 排序前的数组
 * return 排序后的数组
 */
function argSort($para)
{
    ksort($para);
    reset($para);
    return $para;
}

/**
 * 写日志，方便测试（看网站需求，也可以改成把记录存入数据库）
 * 注意：服务器需要开通fopen配置
 * @param $word 要写入日志里的文本内容 默认值：空值
 */
function logResult($word = '')
{
    $fp = fopen("log.txt", "a");
    flock($fp, LOCK_EX);
    fwrite($fp, "执行日期：" . strftime("%Y%m%d%H%M%S", time()) . "\n" . $word . "\n");
    flock($fp, LOCK_UN);
    fclose($fp);
}

/**
 * 远程获取数据，POST模式
 * 注意：
 * 1.使用Crul需要修改服务器中php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
 * 2.文件夹中cacert.pem是SSL证书请保证其路径有效，目前默认路径是：getcwd().'\\cacert.pem'
 * @param $url 指定URL完整路径地址
 * @param $cacert_url 指定当前工作目录绝对路径
 * @param $para 请求的数据
 * @param $input_charset 编码格式。默认值：空值
 * return 远程输出的数据
 */
function getHttpResponsePOST($url, $cacert_url, $para, $input_charset = '')
{

    if (trim($input_charset) != '') {
        $url = $url . "_input_charset=" . $input_charset;
    }
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true); //SSL证书认证
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); //严格认证
    curl_setopt($curl, CURLOPT_CAINFO, $cacert_url); //证书地址
    curl_setopt($curl, CURLOPT_HEADER, 0); // 过滤HTTP头
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 显示输出结果
    curl_setopt($curl, CURLOPT_POST, true); // post传输数据
    curl_setopt($curl, CURLOPT_POSTFIELDS, $para); // post传输数据
    $responseText = curl_exec($curl);
    //var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
    curl_close($curl);

    return $responseText;
}

/**
 * 远程获取数据，GET模式
 * 注意：
 * 1.使用Crul需要修改服务器中php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
 * 2.文件夹中cacert.pem是SSL证书请保证其路径有效，目前默认路径是：getcwd().'\\cacert.pem'
 * @param $url 指定URL完整路径地址
 * @param $cacert_url 指定当前工作目录绝对路径
 * return 远程输出的数据
 */
function getHttpResponseGET($url, $cacert_url)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, 0); // 过滤HTTP头
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 显示输出结果
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true); //SSL证书认证
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); //严格认证
    curl_setopt($curl, CURLOPT_CAINFO, $cacert_url); //证书地址
    $responseText = curl_exec($curl);
    //var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
    curl_close($curl);

    return $responseText;
}

/**
 * 实现多种字符编码方式
 * @param $input 需要编码的字符串
 * @param $_output_charset 输出的编码格式
 * @param $_input_charset 输入的编码格式
 * return 编码后的字符串
 */
function charsetEncode($input, $_output_charset, $_input_charset)
{
    $output = "";
    if (!isset($_output_charset)) {
        $_output_charset = $_input_charset;
    }

    if ($_input_charset == $_output_charset || $input == null) {
        $output = $input;
    } elseif (function_exists("mb_convert_encoding")) {
        $output = mb_convert_encoding($input, $_output_charset, $_input_charset);
    } elseif (function_exists("iconv")) {
        $output = iconv($_input_charset, $_output_charset, $input);
    } else {
        die("sorry, you have no libs support for charset change.");
    }

    return $output;
}

/**
 * 实现多种字符解码方式
 * @param $input 需要解码的字符串
 * @param $_output_charset 输出的解码格式
 * @param $_input_charset 输入的解码格式
 * return 解码后的字符串
 */
function charsetDecode($input, $_input_charset, $_output_charset)
{
    $output = "";
    if (!isset($_input_charset)) {
        $_input_charset = $_input_charset;
    }

    if ($_input_charset == $_output_charset || $input == null) {
        $output = $input;
    } elseif (function_exists("mb_convert_encoding")) {
        $output = mb_convert_encoding($input, $_output_charset, $_input_charset);
    } elseif (function_exists("iconv")) {
        $output = iconv($_input_charset, $_output_charset, $input);
    } else {
        die("sorry, you have no libs support for charset changes.");
    }

    return $output;
}

function do_post($url, $data)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_URL, $url);
    $ret = curl_exec($ch);

    curl_close($ch);
    return $ret;
}

function get_url_contents($url)
{
    if (ini_get("allow_url_fopen") == "1") {
        return file_get_contents($url);
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

function getgradenamebyid($point, $id = 0)
{
    if ($id == 0) {
        $name = Db::name('usergrade')->where('id', $point)->value('name');

        if (empty($name)) {
            $name = '普通会员';
        }
    } else {
        $map['score'] = array('elt', $point);

        $res = Db::name('usergrade')->where($map)->order('score desc')->limit(1)->value('id');
        $info = Db::name('user')->where('id', $id)->find();

        if (!empty($res) && $res != $info['grades']) {
            Db::name('user')->where('id', $id)->setField('grades', $res);

        }
        $name = Db::name('usergrade')->where('id', $res)->value('name');
        if (empty($name)) {
            $name = '普通会员';
        }

    }

    return $name;
}

function url($url = '', $vars = '', $suffix = true, $domain = false)
{

    if (strtolower(request()->module()) == 'admin' && !config('url_route_on')) {
        Url::root(getbaseurl() . 'index.php');
    }
    if (strtolower(request()->module()) == 'bbs' && config('url_route_on')) {
        Url::root(getbaseurl() . '/');
    }

    return Url::build($url, $vars, $suffix, $domain);
}

function routerurl($url, $arr = array())
{
    if (empty($arr)) {
        $str = url($url);
    } else {
        $str = url($url, $arr);
    }

    $str = str_replace('admin.php', 'index.php', $str);

    return $str;
}

// function urlExt($ext="index",$url, $arr = array())
// {
//     if (empty($arr)) {
//         $str = url($url);
//     } else {
//         $str = url($url, $arr);
//     }
//     return $ext.$str;
// }
function remove_xss($html)
{
    $html = htmlspecialchars_decode($html);
    preg_match_all("/\<([^\<]+)\>/is", $html, $ms);

    $searchs[]  = '<';
    $replaces[] = '&lt;';
    $searchs[]  = '>';
    $replaces[] = '&gt;';

    if ($ms[1]) {
        $allowtags = 'videoext|iframe|video|attach|img|a|font|div|table|tbody|caption|tr|td|th|br|p|b|strong|i|u|em|span|ol|ul|li|blockquote|strike|pre|code|embed';
        $ms[1]     = array_unique($ms[1]);
        foreach ($ms[1] as $value) {
            $searchs[] = "&lt;" . $value . "&gt;";

            $value = str_replace('&amp;', '_uch_tmp_str_', $value);
            $value = string_htmlspecialchars($value);
            $value = str_replace('_uch_tmp_str_', '&amp;', $value);

            $value    = str_replace(array('\\', '/*'), array('.', '/.'), $value);
            $skipkeys = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate',
                'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange',
                'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick',
                'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate',
                'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete',
                'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel',
                'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart',
                'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop',
                'onsubmit', 'onunload', 'javascript', 'script', 'eval', 'behaviour', 'expression');
            $skipstr = implode('|', $skipkeys);
            $value   = preg_replace(array("/($skipstr)/i"), '.', $value);
            if (!preg_match("/^[\/|\s]?($allowtags)(\s+|$)/is", $value)) {
                $value = '';
            }
            $replaces[] = empty($value) ? '' : "<" . str_replace('&quot;', '"', $value) . ">";
        }
    }
    $html = str_replace($searchs, $replaces, $html);
    $html = htmlspecialchars($html);
    return $html;
}

function string_htmlspecialchars($string, $flags = null)
{
    if (is_array($string)) {
        foreach ($string as $key => $val) {
            $string[$key] = string_htmlspecialchars($val, $flags);
        }
    } else {
        if ($flags === null) {
            $string = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string);
            if (strpos($string, '&amp;#') !== false) {
                $string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1', $string);
            }
        } else {
            if (PHP_VERSION < '5.4.0') {
                $string = htmlspecialchars($string, $flags);
            } else {
                if (!defined('CHARSET') || (strtolower(CHARSET) == 'utf-8')) {
                    $charset = 'UTF-8';
                } else {
                    $charset = 'ISO-8859-1';
                }
                $string = htmlspecialchars($string, $flags, $charset);
            }
        }
    }

    return $string;
}

//判断是否为数字
function is_number($number)
{
    if (preg_match("/^[0-9]+$/", $number)) {
        return true;
    }
}

/**
 * +----------------------------------------------------------
 * 判断是否为合法有效字符（字母、数字、下划线）
 * +----------------------------------------------------------
 */
function is_valid_character($str)
{
    if (preg_match("/^[A-Za-z0-9_]*$/", $str)) {
        return true;
    }
    return false;
}

/**
 * +----------------------------------------------------------
 * 判断是否包含非法字符
 * +----------------------------------------------------------
 */
function is_illegal_char($char)
{
    // if (preg_match("/[\\\~@$%^&=+{};'\"<>\/]/", $char)) {
    if (preg_match("/[\\\~@$%^&=+{};'\"<>]/", $char)) {
        return true;
    }
}

/**
 * +----------------------------------------------------------
 * 判断搜素关键字是否合法：字母、中文、数字
 * +----------------------------------------------------------
 */
function is_search_keyword($search_keyword)
{
    if (preg_match("/^[\x{4e00}-\x{9fa5}0-9a-zA-Z_]*$/u", $search_keyword)) {
        return true;
    }
}

/**
 * +----------------------------------------------------------
 * 判断是否合法URL
 * +----------------------------------------------------------
 */
function check_url($domain)
{
    return !empty($domain) && strpos($domain, '--') === false &&
    preg_match('/^([a-z0-9]+([a-z0-9-]*(?:[a-z0-9]+))?\.)?[a-z0-9]+([a-z0-9-]*(?:[a-z0-9]+))?(\.us|\.tv|\.org\.cn|\.org|\.net\.cn|\.net|\.mobi|\.me|\.la|\.info|\.hk|\.gov\.cn|\.edu|\.com\.cn|\.com|\.co\.jp|\.co|\.cn|\.cc|\.biz)$/i', $domain) ? true : false;
}

function getbanzhu()
{

}

function string_remove_xss($val)
{
    $val = htmlspecialchars_decode($val);
    $val = strip_tags($val, '<img><attach><u><p><b><i><a><strike><pre><code><font><blockquote><span><ul><li><table><tbody><tr><td><ol><iframe><embed>');

    $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);

    return $val;

    $search = 'abcdefghijklmnopqrstuvwxyz';
    $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $search .= '1234567890!@#$%^&*()';
    $search .= '~`";:?+/={}[]-_|\'\\';

    for ($i = 0; $i < strlen($search); $i++) {
        $val = preg_replace('/(&#[xX]0{0,8}' . dechex(ord($search[$i])) . ';?)/i', $search[$i], $val);
        $val = preg_replace('/(�{0,8}' . ord($search[$i]) . ';?)/', $search[$i], $val);
    }

    $ra1 = array('embed', 'iframe', 'frame', 'ilayer', 'layer', 'javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'script', 'object', 'frameset', 'bgsound', 'title', 'base');
    $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
    $ra = array_merge($ra1, $ra2);

    $found = true;
    while ($found == true) {
        $val_before = $val;
        for ($i = 0; $i < sizeof($ra); $i++) {
            $pattern = '/';
            for ($j = 0; $j < strlen($ra[$i]); $j++) {
                if ($j > 0) {
                    $pattern .= '(';
                    $pattern .= '(&#[xX]0{0,8}([9ab]);)';
                    $pattern .= '|';
                    $pattern .= '|(�{0,8}([9|10|13]);)';
                    $pattern .= ')*';
                }
                $pattern .= $ra[$i][$j];
            }
            $pattern .= '/i';
            $replacement = substr($ra[$i], 0, 2) . '<x>' . substr($ra[$i], 2);
            $val = preg_replace($pattern, $replacement, $val);
            if ($val_before == $val) {
                $found = false;
            }
        }
    }
    $val = htmlspecialchars($val);
    return $val;
}

function updategrade($data)
{
    $map['score'] = array('elt', $data['point']);

    $res = Db::name('usergrade')->where($map)->order('score desc')->limit(1)->value('id');

    if (!empty($res) && $res != $data['grades']) {
        Db::name('user')->where('id', $data['id'])->setField('grades', $res);
    }

    $data['grades'] = $res;
    return $data;
}

//发送站内信
function send_message($from, $to, $content, $type = 0)
{
    $messdata['type'] = $type;
    $messdata['content'] = $content;
    $messdata['status'] = 1;
    $messdata['uid'] = $from;
    $messdata['touid'] = $to;
    $messdata['time'] = time();
    Db::name('message')->insert($messdata);
}

function applyinsert($uid, $type, $content, $newcontent = '')
{
    $data['addtime'] = time();
    $data['uid'] = $uid;
    $data['type'] = $type;
    $data['content'] = $content;
    $data['newcontent'] = $newcontent;
    if (Db::name('apply')->insert($data)) {
        return true;
    }
    return false;
}

function checksqsta()
{
    $path = dirname($_SERVER['SCRIPT_FILENAME']) . '/application/extra/sqsta.php';
    if (!file_exists($path)) {
        return false;
    } else {
        $arr = include $path;
        if (@$arr['status'] < 0) {
            return false;
        }
    }
    return true;
}

function point_note($score, $uid, $controller, $pointid = 0)
{

    if ($score != 0) {

        if ($controller == 'login') {

            $time = time();
            $maptime['add_time'] = array('gt', $time - 24 * 60 * 60);
            $maptime['uid'] = $uid;
            $maptime['controller'] = 'login';

            $count = Db::name('point_note')->where($maptime)->count();
            if ($count > 0) {
                return;
            }
        } else {

            if ($controller == 'yzemail') {

                $mapmail['uid'] = $uid;
                $mapmail['controller'] = 'yzemail';

                $count = Db::name('point_note')->where($mapmail)->count();
                if ($count > 0) {
                    return;
                }

            }

        }

        Db::name('user')->where('id', $uid)->setInc('point', $score);
        $data['uid'] = $uid;
        $data['add_time'] = time();
        $data['controller'] = $controller;
        $data['score'] = $score;
        $data['pointid'] = $pointid;

        Db::name('point_note')->insert($data);
        //根据用户积分提升或降低用户等级

        $data = Db::name('user')->where('id', $uid)->find();

        $map['score'] = array('elt', $data['point']);

        $res = Db::name('usergrade')->where($map)->order('score desc')->limit(1)->value('id');

        if (!empty($res) && $res != $data['grades']) {
            Db::name('user')->where('id', $uid)->setField('grades', $res);
        }
        session('point', session('point') + $score);

    }

    return;

}

function getpoint($uid, $controller, $pointid)
{
    $map['uid'] = $uid;
    $map['pointid'] = $pointid;
    $map['controller'] = $controller;

    $res = Db::name('Point_note')->where($map)->value('score');
    return $res;
}

/**
 * 加载模型
 */
function load_model($name = '', $module = '')
{

    // 回溯跟踪
    $backtrace_array = debug_backtrace(false, 1);

    // 调用者目录名称
    $current_directory_name = basename(dirname($backtrace_array[0]['file']));

    // 设置模块
    !empty($module) && $name = $module . '/' . $name;

    // 返回的对象
    $return_object = null;

    // 加载模型规则
    switch ($current_directory_name) {

        case LAYER_CONTROLLER_NAME:
            $return_object = model($name, LAYER_LOGIC_NAME);
            break;
        case LAYER_LOGIC_NAME:
            $return_object = model($name, LAYER_MODEL_NAME);
            break;
        case LAYER_SERVICE_NAME:
            $return_object = model($name, LAYER_MODEL_NAME);
            break;
        case LAYER_MODEL_NAME:
            $return_object = model($name, LAYER_MODEL_NAME);
            break;
        default:
            $return_object = model($name, LAYER_LOGIC_NAME);
            break;
    }

    return $return_object;
}

function check_addon_ser($name)
{
    $res = Db::name('system')->where('name', 'otaservice')->find();
    if ($res) {
        $ota_info = unserialize($res['value']);
        if ($ota_info) {
            $htd = new Http();
            $url = $ota_info['updateurl'] . '?upkey=' . $ota_info['updatekey'] . '&type=check&ver=' . $name;
            $data = $htd->get_curl($url);
            $arr = json_decode($data, true);
            if ($arr['code'] == 200) {
                return true;
            }
        }
    }
    return false;
}

/**
 * 获取插件类的类名
 * @param $name 插件名
 * @param string $type 返回命名空间类型
 * @param string $class 当前类名
 * @return string
 */
function get_addon_class($name = '', $class = null)
{
    $name = \think\Loader::parseName($name);
    $class = \think\Loader::parseName(is_null($class) ? $name : $class, 0);
    return $namespace = "addons\\" . $name . "\\" . $class;

}

function D($name = '', $layer = '')
{

    if (empty($name)) {
        return new Think\Model;
    }

    static $_model = array();
    $layer = $layer ?: 'model';

    if (isset($_model[$name])) {
        return $_model[$name];
    }

    $class = parse_res_name($name, $layer);

    if (class_exists($class)) {
        $model = new $class(basename($name));
    } elseif (false === strpos($name, '/')) {
        // 自动加载公共模块下面的模型

        $class = '\\common\\' . $layer . '\\' . $name;

        $model = class_exists($class) ? new $class($name) : new Think\Model($name);
    } else {
        Think\Log::record('D方法实例化没找到模型类' . $class, Think\Log::NOTICE);
        $model = new Think\Model(basename($name));
    }
    $_model[$name . $layer] = $model;

    return $model;
}

/**
 * 字符串命名风格转换
 * type 0 将Java风格转换为C的风格 1 将C风格转换为Java的风格
 * @param string $name 字符串
 * @param integer $type 转换类型
 * @return string
 */
function parse_name($name, $type = 0)
{
    if ($type) {
        return ucfirst(preg_replace_callback('/_([a-zA-Z])/', function ($match) {
            return strtoupper($match[1]);
        }, $name));
    } else {
        return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
    }
}

/**
 * 解析资源地址并导入类库文件
 * 例如 module/controller addon://module/behavior
 * @param string $name 资源地址 格式：[扩展://][模块/]资源名
 * @param string $layer 分层名称
 * @return string
 */
function parse_res_name($name, $layer, $level = 1)
{
    if (strpos($name, '://')) { // 指定扩展资源
        list($extend, $name) = explode('://', $name);
    } else {
        $extend = '';
    }
    if (strpos($name, '/') && substr_count($name, '/') >= $level) { // 指定模块
        list($module, $name) = explode('/', $name, 2);
    } else {
        $module = Request::instance()->module();
    }
    $array = explode('/', $name);
    $class = $module . '\\' . $layer;

    foreach ($array as $name) {
        $class .= '\\' . parse_name($name, 1);
    }

    // 导入资源类库
    if ($extend) { // 扩展资源
        $class = $extend . '\\' . $class;
    }

    return $class; //.$layer;
}

function AURL($name, $layer = '', $level = 0)
{
    static $_action = array();
    $layer = $layer ?: 'Controller';

    $class = parse_res_name($name, $layer);

    return $class;
}

function A($name, $layer = '', $level = 0)
{
    static $_action = array();
    $layer = $layer ?: 'controller';

    if (isset($_action[$name . $layer])) {
        return $_action[$name . $layer];
    }

    $class = parse_res_name($name, $layer);

    if (class_exists($class)) {
        $action = new $class();
        $_action[$name . $layer] = $action;

        return $action;
    } else {
        return false;
    }
}

function get_cover($cover_id, $field = null)
{
    if (empty($cover_id)) {
        return false;
    }
    $picture = Db::name('file')->find($cover_id);

    return WEB_URL . $picture[$field];
}

function gethook($controller, $name)
{

    Hook::call($controller, $name);

}

//查询目录下的文件夹名
function get_subdirs($dir)
{
    $subdirs = array();

    if (!$handle = @opendir($dir)) {
        return $subdirs;
    }

    while ($file = @readdir($handle)) {
        if ($file == '.' || $file == '..' || strpos($file, '.') !== false) {
            continue;
        }

        $subdirs[] = $file;
    }
    return $subdirs;
}

function int_to_string(&$data, $map = array('status' => array(1 => '正常', -1 => '删除', 0 => '禁用', 2 => '未审核', 3 => '草稿')))
{
    if ($data === false || $data === null) {
        return $data;
    }
    $data = (array)$data;
    foreach ($data as $key => $row) {
        foreach ($map as $col => $pair) {
            if (isset($row[$col]) && isset($pair[$row[$col]])) {
                $data[$key][$col . '_text'] = $pair[$row[$col]];
            }
        }
    }
    return $data;
}

/**
 * 字符串转换为数组，主要用于把分隔符调整到第二个参数
 * @param  string $str 要分割的字符串
 * @param  string $glue 分割符
 * @return array
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function str2arr($str, $glue = ',')
{
    return explode($glue, $str);
}

/**
 * 数组转换为字符串，主要用于把分隔符调整到第二个参数
 * @param  array $arr 要连接的数组
 * @param  string $glue 分割符
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function arr2str($arr, $glue = ',')
{
    return implode($glue, $arr);
}

/**
 * 对查询结果集进行排序
 * @access public
 * @param array $list 查询结果
 * @param string $field 排序的字段名
 * @param array $sortby 排序类型
 * asc正向排序 desc逆向排序 nat自然排序
 * @return array
 */
function list_sort_by($list, $field, $sortby = 'asc')
{

    if (is_array($list)) {
        $refer = array();
        $resultSet = array();

        foreach ($list as $i => $data) {

            $refer[$i] = $data[$field];

        }

        switch ($sortby) {
            case 'asc': // 正向排序
                asort($refer);
                break;
            case 'desc': // 逆向排序
                arsort($refer);
                break;
            case 'nat': // 自然排序
                natcasesort($refer);
                break;
        }
        foreach ($refer as $key => $val) {
            $resultSet[] = &$list[$key];
        }

        return $resultSet;
    }
    return false;
}

/**
 * 处理插件钩子
 * @param string $hook 钩子名称
 * @param mixed $params 传入参数
 * @return void
 */
function hook($hook, $params = array(), $n = false, $field = '')
{

    if ($n) {
        $m = \Think\Hook::listen($hook, $params);
        if (!empty($m)) {
            return $m[0];
        } else {
            return $params[$field];
        }

    } else {
        \Think\Hook::listen($hook, $params);
    }

}

/**
 * 获取插件类的配置文件数组
 * @param string $name 插件名
 */
function get_addon_config($name)
{
    $class = get_addon_class($name);
    if (class_exists($class)) {
        $addon = new $class();
        return $addon->getConfig();
    } else {
        return array();
    }
}

function addonurl($name, $action)
{

    return get_addon_class($name) . '\\' . $action;

}

/**
 * 插件显示内容里生成访问插件的url
 * @param string $url url
 * @param array $param 参数
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function addons_url($url, $param = array(), $json = false)
{
    $url = parse_url($url);
    $addons = $url['scheme'];
    $controller = $url['host'];
    $action = $url['path'];

    /* 基础参数 */
    $params_array = array(
        'addon_name' => $addons,
        'controller_name' => $controller,
        'action_name' => substr($action, 1),
        'json' => $json,
    );

    $params = array_merge($params_array, $param); //添加额外参数

    $str = url('addons/execute', $params);

    return $str;
}

function userhead($userhead)
{
    if ($userhead == '') {
        return '/public/images/default.png';
    } else {
        return $userhead;
    }
}

function getheadurl($head)
{
    if (preg_match("/^(http:\/\/|https:\/\/).*$/", $head)) {
        return $head;
    } else {
        return (is_HTTPS() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . getbaseurl() . $head;
    }
}

function getweburl($controller, $action, $name = '', $value = '')
{
    if (Cache::has('site_config')) {
        $site_config = Cache::get('site_config');
    } else {
        $site_config = Db::name('system')->field('value')->where('name', 'site_config')->find();
        $site_config = unserialize($site_config['value']);
        Cache::set('site_config', $site_config);
    }

    if ($site_config['site_wjt'] == 1) {
        if ($name != '') {
            $arr = array($name => $value);
            $url = url($controller . "/" . $action, $arr);
        } else {
            $url = url($controller . "/" . $action);
        }

    } else {
        if ($name != '') {
            $arr = array($name => $value);
            $url = url($controller . "/" . $action, $arr);
        } else {
            $url = url($controller . "/" . $action);
        }
    }

    return $url;

}

//高级版查找某个数组是否存在
function inArray($item, $array)
{
    $str = implode(',', $array);
    $str = ',' . $str . ',';
    $item2 = ',' . $item . ',';
    return false !== strpos($str, $item2) ? true : false;
}

function sendmail($switch)
{
    ignore_user_abort(); //关闭浏览器后，继续执行php代码
    set_time_limit(0); //程序执行时间无限制
    $sleep_time = 5; //多长时间执行一次

    while ($switch) {

        $msg = date("Y-m-d H:i:s") . $switch;
        file_put_contents("log.log", $msg, FILE_APPEND); //记录日志
        sleep($sleep_time); //等待时间，进行下一次操作。
    }
    exit();

}

function getbaseurl()
{
    $baseUrl = str_replace('\\', '', dirname($_SERVER['SCRIPT_NAME']));
    $baseUrl = empty($baseUrl) ? '/' : '/' . trim($baseUrl, '/') . '/';
    return $baseUrl;
}

function asyn_sendmail($data)
{
    $query = http_build_query($data);
    $request = Request::instance();
    $domain = $_SERVER['HTTP_HOST'];
    $url = 'http://' . $domain . getbaseurl() . 'index/mail/send_mail' . '?' . $query;
    $par = time();
    $fp = fsockopen($domain, 80, $errno, $errstr, 10);
    $out = "POST " . $url . " HTTP/1.1\r\n";
    $out .= "Host: typecho.org\r\n";
    $out .= "Content-type: application/x-www-form-urlencoded\r\n";
    $out .= "Content-Length: " . strlen($par) . "\r\n";
    $out .= "Connection: close\r\n\r\n";
    $out .= $par . "\r\n\r\n";
    fputs($fp, $out);
    fclose($fp);
}

/**
 * 用常规方式发送邮件。
 */
function send_mail_local($to = '', $subject = '', $body = '', $from_name = '', $attachment = null, $reply_email = '', $reply_name = '')
{
    $site_config = Db::name('system')->field('value')->where('name', 'site_config')->find();
    $site_config = unserialize($site_config['value']);
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';

    // 服务器设置
    //$mail->SMTPDebug = 0; //开启Debug
    $mail->isSMTP(); // 使用SMTP

    $mail->Host = $site_config['smtp_server']; // SMTP 服务器
    $mail->Port = $site_config['smtp_port']; // SMTP服务器的端口号
    $mail->Username = $site_config['smtp_user']; // SMTP服务器用户名
    $mail->Password = $site_config['smtp_pass']; // SMTP服务器密码

    $mail->SMTPAuth = true; // 开启SMTP验证
    $mail->SMTPAutoTLS = false;
    $mail->SMTPSecure = '';
    //$mail->SMTPSecure = 'tls'; // 开启TLS 可选

    if ($to == '') {
        $to = $site_config['smtp_cs']; //邮件地址为空时，默认使用后台默认邮件测试地址
    }
    if ($from_name == '') {
        $from_name = $site_config['site_title'];
    }
    if ($subject == '') {
        $subject = $site_config['seo_title']; //邮件主题为空时，默认使用网站标题
    }
    if ($body == '') {
        $body = $site_config['seo_description']; //邮件内容为空时，默认使用网站描述
    }

    $from_email = $site_config['smtp_user'];

    $reply_email = '';
    $reply_name = '';

    $mail->SetFrom($from_email, $from_name);
    $replyEmail = $reply_email ? $reply_email : $from_email;
    $replyName = $reply_name ? $reply_name : $from_name;
    $mail->AddReplyTo($replyEmail, $replyName);
    $mail->Subject = $subject;
    $mail->MsgHTML($body);
    $mail->AddAddress($to, $from_name);
    /*if (is_array($attachment)) { // 添加附件
    foreach ($attachment as $file) {
    is_file($file) && $mail->AddAttachment($file);
    }
    } */
    // 附件
    //$mail->addAttachment('/var/tmp/file.tar.gz'); // 添加附件
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // 可以设定名字
    return $mail->Send() ? true : $mail->ErrorInfo; //返回错误信息
}

function iconurl($icon, $type)
{

    if ($icon != 0 && $icon != '') {

        if ($type == 2) {

            return "<i class='iconfont icon-" . $icon . "'></i>";
        } else {

            return "<img src='" . $icon . "' />";
        }
    } else {

        return "空";

    }
}

function getcommentbyid($id)
{

    $children = Db::name('comment')->where(['id' => $id])->find();
    //此时查询都是前台会员

    $content = getusernamebyid($children['uid']) . ':' . htmlspecialchars_decode($children['content']);

    return $content;

}

function getuserinfobyid($uid)
{
    if ($uid == 0) {
        return '所有人';
    } else {
        $children = Db::name('user')->where(['id' => $uid])->find();
        //此时查询都是前台会员

        return $children;

    }

}

function getusernamebyid($uid)
{
    if ($uid == 0) {
        return '所有人';
    } else {
        $children = Db::name('user')->where(['id' => $uid])->find();
        if (empty($children)) {

            $children = Db::name('admin_user')->where(['id' => $uid])->find();
            return $children['username'];
        } else {
            return $children['username'];
        }

    }

}

function getforumbyid($id)
{
    if ($id == 0) {
        return '无此帖';
    } else {
        $children = Db::name('forum')->where(['id' => $id])->find();
        if (empty($children)) {

            return '无此帖';
        } else {
            return $children['title'];
        }

    }

}

function getartbyid($id)
{
    if ($id == 0) {
        return '无此文章';
    } else {
        $children = Db::name('article')->where(['id' => $id])->find();
        if (empty($children)) {

            return '无此文章';
        } else {
            return $children['title'];
        }

    }

}

function friendlyDate($sTime, $type = 'normal', $alt = 'false')
{
    if (!$sTime) {
        return '';
    }

    //sTime=源时间，cTime=当前时间，dTime=时间差
    $cTime = time();
    $dTime = $cTime - $sTime;
    $dDay = intval(date("z", $cTime)) - intval(date("z", $sTime));
    //$dDay     =   intval($dTime/3600/24);
    $dYear = intval(date("Y", $cTime)) - intval(date("Y", $sTime));
    //normal：n秒前，n分钟前，n小时前，日期
    if ($type == 'normal') {
        if ($dTime < 60) {
            if ($dTime < 10) {
                return '刚刚'; //by yangjs
            } else {
                return intval(floor($dTime / 10) * 10) . "秒前";
            }
        } elseif ($dTime < 3600) {
            return intval($dTime / 60) . "分钟前";
            //今天的数据.年份相同.日期相同.
        } elseif ($dYear == 0 && $dDay == 0) {
            //return intval($dTime/3600)."小时前";
            return '今天' . date('H:i', $sTime);
        } elseif ($dYear == 0) {
            return date("m月d日 H:i", $sTime);
        } else {
            return date("Y-m-d", $sTime);
        }
    } elseif ($type == 'mohu') {
        if ($dTime < 60) {
            return $dTime . "秒前";
        } elseif ($dTime < 3600) {
            return intval($dTime / 60) . "分钟前";
        } elseif ($dTime >= 3600 && $dDay == 0) {
            return intval($dTime / 3600) . "小时前";
        } elseif ($dDay > 0 && $dDay <= 7) {
            return intval($dDay) . "天前";
        } elseif ($dDay > 7 && $dDay <= 30) {
            return intval($dDay / 7) . '周前';
        } elseif ($dDay > 30) {
            return intval($dDay / 30) . '个月前';
        }
        //full: Y-m-d , H:i:s
    } elseif ($type == 'full') {
        return date("Y-m-d , H:i:s", $sTime);
    } elseif ($type == 'ymd') {
        return date("Y-m-d", $sTime);
    } else {
        if ($dTime < 60) {
            return $dTime . "秒前";
        } elseif ($dTime < 3600) {
            return intval($dTime / 60) . "分钟前";
        } elseif ($dTime >= 3600 && $dDay == 0) {
            return intval($dTime / 3600) . "小时前";
        } elseif ($dYear == 0) {
            return date("Y-m-d H:i:s", $sTime);
        } else {
            return date("Y-m-d H:i:s", $sTime);
        }
    }
}

/*
 * 来判断导航链接内部外部从而生成新链接
 *
 *
 * */
function getnavlink($link, $sid)
{
    if ($sid == 1) {

        $arr = explode(',', $link);

        $url = $arr[0];

        array_shift($arr);
        if (empty($arr)) {

            $link = url($url);

        } else {
            $m = 1;
            $queue = array();
            foreach ($arr as $k => $v) {

                if ($m == 1) {
                    $n = $v;
                    $m = 2;

                } else {
                    $b = $v;
                    $queue[$n] = $b;
                    $m = 1;
                }
            }
            if (empty($queue)) {
                $link = url($url);
            } else {
                $link = url($url, $queue);
            }

        }

    }

    return $link;
}

function dir_create($path, $mode = 0777)
{
    if (is_dir($path)) {
        return true;
    }
    $ftp_enable = 0;
    //$path = dir_path($path);
    $path = str_replace("\\", '/', $path); //转换路径
    $temp = explode('/', $path);
    $cur_dir = '';
    $max = count($temp) - 1;
    for ($i = 0; $i < $max; $i++) {
        $cur_dir .= $temp[$i] . '/';
        if (@is_dir($cur_dir)) {
            continue;
        }
        @mkdir($cur_dir, 0777, true);
        @chmod($cur_dir, 0777);
    }
    return is_dir($path);
}

function format_bytes($size, $delimiter = '')
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
    for ($i = 0; $size >= 1024 && $i < 6; $i++) {
        $size /= 1024;
    }

    return round($size, 2) . $delimiter . $units[$i];
}

//判断是不是https
function is_HTTPS()
{
    if (!isset($_SERVER['HTTPS'])) {
        return false;
    }

    if ($_SERVER['HTTPS'] === 1) { //Apache
        return true;
    } elseif ($_SERVER['HTTPS'] === 'on') { //IIS
        return true;
    } elseif ($_SERVER['SERVER_PORT'] == 443) { //其他
        return true;
    }
    return false;
}

//用于生成用户密码的随机字符
function generate_password($length = 8)
{
    // 密码字符集，可任意添加你需要的字符
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        // 这里提供两种字符获取方式
        // 第一种是使用 substr 截取$chars中的任意一位字符；
        // 第二种是取字符数组 $chars 的任意元素
        // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
        $password .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $password;
}

/**
 * 获取分类所有子分类
 * @param int $cid 分类ID
 * @return array|bool
 */
function get_category_children($cid)
{
    if (empty($cid)) {
        return false;
    }

    $children = Db::name('category')->where(['path' => ['like', "%,{$cid},%"]])->select();

    return array2tree($children);
}

/**
 * 根据分类ID获取文章列表（包括子分类）
 * @param int $cid 分类ID
 * @param int $limit 显示条数
 * @param array $where 查询条件
 * @param array $order 排序
 * @param array $filed 查询字段
 * @return bool|false|PDOStatement|string|\think\Collection
 */
function get_articles_by_cid($cid, $limit = 10, $where = [], $order = [], $filed = [])
{
    if (empty($cid)) {
        return false;
    }

    $ids = Db::name('articlecate')->where(['tid' => $cid])->order('sort asc')->column('id');
    $ids = (!empty($ids) && is_array($ids)) ? implode(',', $ids) . ',' . $cid : $cid;

    $fileds = array_merge(['id', 'tid', 'title', 'description', 'coverpic', 'view', 'time'], (array)$filed);
    $map = array_merge(['tid' => ['IN', $ids], 'open' => 1, 'time' => ['<= time', date('Y-m-d H:i:s')]], (array)$where);
    $sort = array_merge(['settop' => 'DESC', 'time' => 'DESC'], (array)$order);

    $article_list = Db::name('article')->where($map)->field($fileds)->order($sort)->limit($limit)->select();

    return $article_list;
}

/**
 * 根据分类ID获取文章列表，带分页（包括子分类）
 * @param int $cid 分类ID
 * @param int $page_size 每页显示条数
 * @param array $where 查询条件
 * @param array $order 排序
 * @param array $filed 查询字段
 * @return bool|\think\paginator\Collection
 */
function get_articles_by_cid_paged($cid, $page_size = 15, $where = [], $order = [], $filed = [])
{
    if (empty($cid)) {
        return false;
    }

    $ids = Db::name('category')->where(['path' => ['like', "%,{$cid},%"]])->column('id');
    $ids = (!empty($ids) && is_array($ids)) ? implode(',', $ids) . ',' . $cid : $cid;

    $fileds = array_merge(['id', 'cid', 'title', 'introduction', 'thumb', 'reading', 'publish_time'], (array)$filed);
    $map = array_merge(['cid' => ['IN', $ids], 'status' => 1, 'publish_time' => ['<= time', date('Y-m-d H:i:s')]], (array)$where);
    $sort = array_merge(['is_top' => 'DESC', 'sort' => 'DESC', 'publish_time' => 'DESC'], (array)$order);

    $article_list = Db::name('article')->where($map)->field($fileds)->order($sort)->paginate($page_size);

    return $article_list;
}

/**
 * +----------------------------------------------------------
 * 获取上一项下一项
 * +----------------------------------------------------------
 */
function lift($table, $module, $id, $cat_id)
{
    $field = $this->field_exist($module, 'title') ? 'title' : 'name'; // 判断包含title字段还是name字段
    $screen = $cat_id ? " AND cat_id = $cat_id" : ''; // 判断是否有分类筛选

    // 上一项
    $lift['previous'] = $this->fetch_assoc($this->query("SELECT id, " . $field . " FROM " . $this->table($module) . " WHERE id > $id" . $screen . " and isallow =1 and handlestatus=1 ORDER BY id ASC"));
    if ($lift['previous']) {
        $lift['previous']['url'] = $this->rewrite_url($module, $lift['previous']['id']);
    }

    // 下一项
    $lift['next'] = $this->fetch_assoc($this->query("SELECT id, " . $field . " FROM " . $this->table($module) . " WHERE id < $id" . $screen . " and isallow =1 and handlestatus=1 ORDER BY id DESC"));
    if ($lift['next']) {
        $lift['next']['url'] = $this->url($module, array('id' => $lift['next']['id']));
    }

    return $lift;
}

/**
 * 数组层级缩进转换
 * @param array $array 源数组
 * @param int $pid
 * @param int $level
 * @return array
 */
function array2level($array, $pid = 0, $level = 1)
{
    static $list = [];

    foreach ($array as $v) {

        if ($v['pid'] == $pid) {

            $v['level'] = $level;
            $list[] = $v;

            array2level($array, $v['id'], $level + 1);
        }
    }

    return $list;
}

/**
 * 构建层级（树状）数组
 * @param array $array 要进行处理的一维数组，经过该函数处理后，该数组自动转为树状数组
 * @param string $pid_name 父级ID的字段名
 * @param string $child_key_name 子元素键名
 * @return array|bool
 */
function array2tree(&$array, $pid_name = 'pid', $child_key_name = 'children')
{
    $counter = array_children_count($array, $pid_name);
    if (!isset($counter[0]) || $counter[0] == 0) {
        return $array;
    }
    $tree = [];
    while (isset($counter[0]) && $counter[0] > 0) {
        $temp = array_shift($array);
        if (isset($counter[$temp['id']]) && $counter[$temp['id']] > 0) {
            array_push($array, $temp);
        } else {
            if ($temp[$pid_name] == 0) {
                $tree[] = $temp;
            } else {
                $array = array_child_append($array, $temp[$pid_name], $temp, $child_key_name);
            }
        }
        $counter = array_children_count($array, $pid_name);
    }

    return $tree;
}

/**
 * 子元素计数器
 * @param array $array
 * @param int $pid
 * @return array
 */
function array_children_count($array, $pid)
{
    $counter = [];
    foreach ($array as $item) {
        $count = isset($counter[$item[$pid]]) ? $counter[$item[$pid]] : 0;
        $count++;
        $counter[$item[$pid]] = $count;
    }

    return $counter;
}

/**
 * 把元素插入到对应的父元素$child_key_name字段
 * @param        $parent
 * @param        $pid
 * @param        $child
 * @param string $child_key_name 子元素键名
 * @return mixed
 */
function array_child_append($parent, $pid, $child, $child_key_name)
{
    foreach ($parent as &$item) {
        if ($item['id'] == $pid) {
            if (!isset($item[$child_key_name])) {
                $item[$child_key_name] = [];
            }

            $item[$child_key_name][] = $child;
        }
    }

    return $parent;
}

/**
 * 循环删除目录和文件
 * @param string $dir_name
 * @return bool
 */
function delete_dir_file($dir_name)
{
    $result = false;
    if (is_dir($dir_name)) {
        if ($handle = opendir($dir_name)) {
            while (false !== ($item = readdir($handle))) {
                if ($item != '.' && $item != '..') {
                    if (is_dir($dir_name . DS . $item)) {
                        delete_dir_file($dir_name . DS . $item);
                    } else {
                        unlink($dir_name . DS . $item);
                    }
                }
            }
            closedir($handle);
            if (rmdir($dir_name)) {
                $result = true;
            }
        }
    }

    return $result;
}

/**
 * 判断是否为手机访问
 * @return  boolean
 */
function is_mobile()
{
    static $is_mobile;

    if (isset($is_mobile)) {
        return $is_mobile;
    }

    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        $is_mobile = false;
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false
    ) {
        $is_mobile = true;
    } else {
        $is_mobile = false;
    }

    return $is_mobile;
}

/**
 * 手机号格式检查
 * @param string $mobile
 * @return bool
 */
function check_mobile_number($mobile)
{
    if (!is_numeric($mobile)) {
        return false;
    }
    $reg = '#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#';

    return preg_match($reg, $mobile) ? true : false;
}

/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true)
{

    if (function_exists("mb_substr")) {
        $slice = mb_substr($str, $start, $length, $charset);
    } elseif (function_exists('iconv_substr')) {
        $slice = iconv_substr($str, $start, $length, $charset);
        if (false === $slice) {
            $slice = '';
        }
    } else {
        $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("", array_slice($match[0], $start, $length));
    }
    //截取内容时去掉图片，仅保留文字

    return $suffix ? $slice . '...' : $slice;
}

function clearcontent($content)
{

    $content = htmlspecialchars_decode($content);

    $content = preg_replace("/&lt;/i", "<", $content);

    $content = preg_replace("/&gt;/i", ">", $content);

    $content = preg_replace("/&amp;/i", "&", $content);

    $content = strip_tags($content);
    return $content;
}

function clearHtml($content)
{
    $content = preg_replace("/<a[^>]*>/i", "", $content);
    $content = preg_replace("/<\/a>/i", "", $content);
    $content = preg_replace("/<p>/i", "", $content);
    $content = preg_replace("/<\/p>/i", "", $content);
    $content = preg_replace("/<div[^>]*>/i", "", $content);
    $content = preg_replace("/<\/div>/i", "", $content);
    $content = preg_replace("/<!--[^>]*-->/i", "", $content); //注释内容
    $content = preg_replace("/style=.+?['|\"]/i", '', $content); //去除样式
    $content = preg_replace("/class=.+?['|\"]/i", '', $content); //去除样式
    $content = preg_replace("/id=.+?['|\"]/i", '', $content); //去除样式
    $content = preg_replace("/lang=.+?['|\"]/i", '', $content); //去除样式
    $content = preg_replace("/width=.+?['|\"]/i", '', $content); //去除样式
    $content = preg_replace("/height=.+?['|\"]/i", '', $content); //去除样式
    $content = preg_replace("/border=.+?['|\"]/i", '', $content); //去除样式
    $content = preg_replace("/face=.+?['|\"]/i", '', $content); //去除样式
    $content = preg_replace("/face=.+?['|\"]/", '', $content); //去除样式 只允许小写 正则匹配没有带 i 参数
    return $content;
}

function cutstr_html($string, $length = 0, $ellipsis = '…')
{

    $string = strip_tags($string);
    $string = preg_replace("/\n/is", '', $string);
    $string = preg_replace("/\r\n/is", '', $string);

    $string = preg_replace('/ |　/is', '', $string);
    $string = preg_replace('/&nbsp;/is', '', $string);
    $string = preg_replace('/&emsp;/is', '', $string);

    if (mb_strlen($string, 'utf-8') <= $length) {
        $ellipsis = '';
    }
    preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $string);
    if (is_array($string) && !empty($string[0])) {
        if (is_numeric($length) && $length) {

            $string = join('', array_slice($string[0], 0, $length)) . $ellipsis;
        } else {
            $string = implode('', $string[0]);
        }
    } else {
        $string = '';
    }
    return $string;
}

if (!function_exists('dd')) {
  
    function dd($args)
    {
        echo "<pre>";
        print_r($args);
        die(1);
    }
}

if (!function_exists('lsql')) {
    function lsql()
    {
        echo Db::getLastSql();
        die(1);
    }
}

//低版本 array_column函数
if (!function_exists('array_column')) {
    function array_column($input, $columnKey, $indexKey = null)
    {
        $columnKeyIsNumber = (is_numeric($columnKey)) ? true : false;
        $indexKeyIsNull = (is_null($indexKey)) ? true : false;
        $indexKeyIsNumber = (is_numeric($indexKey)) ? true : false;
        $result = array();

        foreach ((array)$input as $key => $row) {
            if ($columnKeyIsNumber) {
                $tmp = array_slice($row, $columnKey, 1);
                $tmp = (is_array($tmp) && !empty($tmp)) ? current($tmp) : null;
            } else {
                $tmp = isset($row[$columnKey]) ? $row[$columnKey] : null;
            }
            if (!$indexKeyIsNull) {
                if ($indexKeyIsNumber) {
                    $key = array_slice($row, $indexKey, 1);
                    $key = (is_array($key) && !empty($key)) ? current($key) : null;
                    $key = is_null($key) ? 0 : $key;
                } else {
                    $key = isset($row[$indexKey]) ? $row[$indexKey] : 0;
                }
            }

            $result[$key] = $tmp;
        }

        return $result;
    }
}

if (!function_exists('unique_rand')) {
function unique_rand($min, $max, $num) {
    $count = 0;
    //建一个新数组
    $return = array();
    while ($count < $num) {
    //在一定范围内随机生成一个数放入数组中
    $return[] = mt_rand($min, $max);
    //去除数组中的重复值用了“翻翻法”，就是用array_flip()把数组的key和value交换两次。这种做法比用 array_unique() 快得多。
    $return = array_flip(array_flip($return));
    //将数组的数量存入变量count中
    $count = count($return);
    }
    //为数组赋予新的键名
    shuffle($return);
    return $return;
    }
}

/**
 * 获取第一张图为封面图
 */
if (!function_exists('get_coverpic')) {
function get_coverpic($content){
   preg_match_all('/<img[^>]*src=[\'"]?([^>\'"\s]*)[\'"]?[^>]*>/i', htmlspecialchars_decode($content), $match);
   if(count(@$match[1])){
    return $match[1][0];
    }
    else {
       return '';
    }
  }
}

 /**
     * +----------------------------------------------------------
     * 获取当前分类下所有子分类
     * +----------------------------------------------------------
     * $table 数据表名
     * $parent_id 父类ID
     * $child 子类ID临时存储器
     * +----------------------------------------------------------
     */
    function ls_child_id($table, $parent_id = '0', &$child_id = '') {
        $data = Db::name('articlecate')->order('sort asc,tid asc')->select();
        foreach ((array) $data as $value) {
            if ($value['tid'] == $parent_id) {
                $child_id .= ',' . $value['id'];
                ls_child_id($table, $value['id'], $child_id);
            }
        }

        return $child_id;
    }