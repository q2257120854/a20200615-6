<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace org;

/**
 * Http 工具类
 * 提供一系列的Http方法
 * @category   ORG
 * @package  ORG
 * @subpackage  Net
 * @author    liu21st <liu21st@gmail.com>
 */
class Http
{

    /**
     * 采集远程文件
     * @access public
     * @param string $url 远程文件名
     * @param string $filename 本地保存文件名
     * @return mixed
     */
    public function http_down($url, $filename = "", $timeout = 60)
    {
        if (empty($filename)) {
            $filename = TEMP_PATH . pathinfo($url, PATHINFO_BASENAME);
        }
        $path = dirname($filename);
        if (!is_dir($path) && !mkdir($path, 0755, true)) {
            return false;
        }
        $url = str_replace(" ", "%20", $url);
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            if(strtolower(@parse_url($url)['scheme']) === 'https'){
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            }
            $temp = curl_exec($ch);
            if (file_put_contents($filename, $temp) && !curl_error($ch)) {
                return $filename;
            } else {
                return false;
            }
        } else {
            $opts = [
                "http" => [
                    "method"  => "GET",
                    "header"  => "",
                    "timeout" => $timeout,
                ],
            ];
            $context = stream_context_create($opts);
            if (@copy($url, $filename, $context)) {
                return $filename;
            } else {
                return false;
            }
        }
    }

    public function get_curl($url, $post = 0, $referer = 0, $cookie = 0, $header = 0, $ua = 0, $nobaody = 0, $returnCookie = 0)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        if ($header) {
            curl_setopt($ch, CURLOPT_HEADER, true);
        }
        if ($cookie) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }

        if ($referer) {
            curl_setopt($ch, CURLOPT_REFERER, $referer);
        } else {
            curl_setopt($ch, CURLOPT_REFERER, @$_SERVER['HTTP_REFERER']);
        }
        if ($ua) {
            curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        } else {
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
        }
        if ($nobaody) {
            curl_setopt($ch, CURLOPT_NOBODY, 1);
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        if ($returnCookie) {
            list($header, $body) = explode("\r\n\r\n", $data, 2);
            preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
            $info['cookie']  = substr($matches[1][0], 1);
            $info['content'] = $body;
            return $info;
        } else {
            return $data;
        }
    }

    /**
     * 下载文件
     * 可以指定下载显示的文件名，并自动发送相应的Header信息
     * 如果指定了content参数，则下载该参数的内容
     * @static
     * @access public
     * @param string $filename 下载文件名
     * @param string $showname 下载显示的文件名
     * @param string $content  下载的内容
     * @param integer $expire  下载内容浏览器缓存时间
     * @return void
     */
    public static function download($filename, $showname = '', $content = '', $expire = 180)
    {
        if (is_file($filename)) {
            $length = filesize($filename);
        } elseif ($content != '') {
            $length = strlen($content);
        } else {
            throw_exception($filename . L('下载文件不存在！'));
        }
        if (empty($showname)) {
            $showname = $filename;
        }
        // $showname = basename($showname);
        if (!empty($filename)) {
            $type = mime_content_type($filename);
        } else {
            $type = "application/octet-stream";
        }
        header("Pragma: public");
        header("Cache-control: max-age=" . $expire);
        header("Expires: " . gmdate("D, d M Y H:i:s", time() + $expire) . "GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s", time()) . "GMT");
        header("Content-Disposition: attachment; filename=" . $showname);
        // if (preg_match("/MSIE/", $ua)) {
        //     header('Content-Disposition: attachment; filename="' . $showname . '"');
        // } else if (preg_match("/Firefox/", $ua)) {
        //     header('Content-Disposition: attachment; filename="' . $showname . '"');
        // } else {
        //     header('Content-Disposition: attachment; filename="' . $showname . '"');
        // }

        header("Content-Length: " . $length);
        header("Content-type: " . $type);
        header('Content-Encoding: none');
        header("Content-Transfer-Encoding: binary");
        if ($content == '') {
            readfile($filename);
        } else {
            echo ($content);
        }
        exit();
    }

    /**
     * 显示HTTP Header 信息
     * @return string
     */
    public static function getHeaderInfo($header = '', $echo = true)
    {
        ob_start();
        $headers = getallheaders();
        if (!empty($header)) {
            $info = $headers[$header];
            echo ($header . ':' . $info . "\n");
        } else {
            foreach ($headers as $key => $val) {
                echo ("$key:$val\n");
            }
        }
        $output = ob_get_clean();
        if ($echo) {
            echo (nl2br($output));
        } else {
            return $output;
        }

    }
    /**
     * 获取远程图片hash
     */
    public function getHash($uri, $user = '', $pw = '')
    {
        ob_start();
        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_NOBODY, 1); //nobody是关键
        if (!empty($user) && !empty($pw)) {
            $headers = array('Authorization: Basic ' . base64_encode($user . ':' . $pw));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        $okay = curl_exec($ch);
        curl_close($ch);
        $head = ob_get_contents();
        ob_end_clean();
        $regex = '/ETag: \"(.*)\"/i';
        preg_match($regex, $head, $matches);
        return $matches[1];
    }
    /**
     * HTTP Protocol defined status codes
     * @param int $num
     */
    public static function sendHttpStatus($code)
    {
        static $_status = array(
            // Informational 1xx
            100 => 'Continue',
            101 => 'Switching Protocols',

            // Success 2xx
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',

            // Redirection 3xx
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found', // 1.1
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            // 306 is deprecated but reserved
            307 => 'Temporary Redirect',

            // Client Error 4xx
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',

            // Server Error 5xx
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            509 => 'Bandwidth Limit Exceeded',
        );
        if (isset($_status[$code])) {
            header('HTTP/1.1 ' . $code . ' ' . $_status[$code]);
        }
    }
} //类定义结束
if (!function_exists('mime_content_type')) {
    /**
     * 获取文件的mime_content类型
     * @return string
     */
    function mime_content_type($filename)
    {
        static $contentType = array(
            'ai'      => 'application/postscript',
            'aif'     => 'audio/x-aiff',
            'aifc'    => 'audio/x-aiff',
            'aiff'    => 'audio/x-aiff',
            'asc'     => 'application/pgp', //changed by skwashd - was text/plain
            'asf'     => 'video/x-ms-asf',
            'asx'     => 'video/x-ms-asf',
            'au'      => 'audio/basic',
            'avi'     => 'video/x-msvideo',
            'bcpio'   => 'application/x-bcpio',
            'bin'     => 'application/octet-stream',
            'bmp'     => 'image/bmp',
            'c'       => 'text/plain', // or 'text/x-csrc', //added by skwashd
            'cc'      => 'text/plain', // or 'text/x-c++src', //added by skwashd
            'cs'      => 'text/plain', //added by skwashd - for C# src
            'cpp'     => 'text/x-c++src', //added by skwashd
            'cxx'     => 'text/x-c++src', //added by skwashd
            'cdf'     => 'application/x-netcdf',
            'class'   => 'application/octet-stream', //secure but application/java-class is correct
            'com'     => 'application/octet-stream', //added by skwashd
            'cpio'    => 'application/x-cpio',
            'cpt'     => 'application/mac-compactpro',
            'csh'     => 'application/x-csh',
            'css'     => 'text/css',
            'csv'     => 'text/comma-separated-values', //added by skwashd
            'dcr'     => 'application/x-director',
            'diff'    => 'text/diff',
            'dir'     => 'application/x-director',
            'dll'     => 'application/octet-stream',
            'dms'     => 'application/octet-stream',
            'doc'     => 'application/msword',
            'dot'     => 'application/msword', //added by skwashd
            'dvi'     => 'application/x-dvi',
            'dxr'     => 'application/x-director',
            'eps'     => 'application/postscript',
            'etx'     => 'text/x-setext',
            'exe'     => 'application/octet-stream',
            'ez'      => 'application/andrew-inset',
            'gif'     => 'image/gif',
            'gtar'    => 'application/x-gtar',
            'gz'      => 'application/x-gzip',
            'h'       => 'text/plain', // or 'text/x-chdr',//added by skwashd
            'h++'     => 'text/plain', // or 'text/x-c++hdr', //added by skwashd
            'hh'      => 'text/plain', // or 'text/x-c++hdr', //added by skwashd
            'hpp'     => 'text/plain', // or 'text/x-c++hdr', //added by skwashd
            'hxx'     => 'text/plain', // or 'text/x-c++hdr', //added by skwashd
            'hdf'     => 'application/x-hdf',
            'hqx'     => 'application/mac-binhex40',
            'htm'     => 'text/html',
            'html'    => 'text/html',
            'ice'     => 'x-conference/x-cooltalk',
            'ics'     => 'text/calendar',
            'ief'     => 'image/ief',
            'ifb'     => 'text/calendar',
            'iges'    => 'model/iges',
            'igs'     => 'model/iges',
            'jar'     => 'application/x-jar', //added by skwashd - alternative mime type
            'java'    => 'text/x-java-source', //added by skwashd
            'jpe'     => 'image/jpeg',
            'jpeg'    => 'image/jpeg',
            'jpg'     => 'image/jpeg',
            'js'      => 'application/x-javascript',
            'kar'     => 'audio/midi',
            'latex'   => 'application/x-latex',
            'lha'     => 'application/octet-stream',
            'log'     => 'text/plain',
            'lzh'     => 'application/octet-stream',
            'm3u'     => 'audio/x-mpegurl',
            'man'     => 'application/x-troff-man',
            'me'      => 'application/x-troff-me',
            'mesh'    => 'model/mesh',
            'mid'     => 'audio/midi',
            'midi'    => 'audio/midi',
            'mif'     => 'application/vnd.mif',
            'mov'     => 'video/quicktime',
            'movie'   => 'video/x-sgi-movie',
            'mp2'     => 'audio/mpeg',
            'mp3'     => 'audio/mpeg',
            'mpe'     => 'video/mpeg',
            'mpeg'    => 'video/mpeg',
            'mpg'     => 'video/mpeg',
            'mpga'    => 'audio/mpeg',
            'ms'      => 'application/x-troff-ms',
            'msh'     => 'model/mesh',
            'mxu'     => 'video/vnd.mpegurl',
            'nc'      => 'application/x-netcdf',
            'oda'     => 'application/oda',
            'patch'   => 'text/diff',
            'pbm'     => 'image/x-portable-bitmap',
            'pdb'     => 'chemical/x-pdb',
            'pdf'     => 'application/pdf',
            'pgm'     => 'image/x-portable-graymap',
            'pgn'     => 'application/x-chess-pgn',
            'pgp'     => 'application/pgp', //added by skwashd
            'php'     => 'application/x-httpd-php',
            'php3'    => 'application/x-httpd-php3',
            'pl'      => 'application/x-perl',
            'pm'      => 'application/x-perl',
            'png'     => 'image/png',
            'pnm'     => 'image/x-portable-anymap',
            'po'      => 'text/plain',
            'ppm'     => 'image/x-portable-pixmap',
            'ppt'     => 'application/vnd.ms-powerpoint',
            'ps'      => 'application/postscript',
            'qt'      => 'video/quicktime',
            'ra'      => 'audio/x-realaudio',
            'rar'     => 'application/octet-stream',
            'ram'     => 'audio/x-pn-realaudio',
            'ras'     => 'image/x-cmu-raster',
            'rgb'     => 'image/x-rgb',
            'rm'      => 'audio/x-pn-realaudio',
            'roff'    => 'application/x-troff',
            'rpm'     => 'audio/x-pn-realaudio-plugin',
            'rtf'     => 'text/rtf',
            'rtx'     => 'text/richtext',
            'sgm'     => 'text/sgml',
            'sgml'    => 'text/sgml',
            'sh'      => 'application/x-sh',
            'shar'    => 'application/x-shar',
            'shtml'   => 'text/html',
            'silo'    => 'model/mesh',
            'sit'     => 'application/x-stuffit',
            'skd'     => 'application/x-koan',
            'skm'     => 'application/x-koan',
            'skp'     => 'application/x-koan',
            'skt'     => 'application/x-koan',
            'smi'     => 'application/smil',
            'smil'    => 'application/smil',
            'snd'     => 'audio/basic',
            'so'      => 'application/octet-stream',
            'spl'     => 'application/x-futuresplash',
            'src'     => 'application/x-wais-source',
            'stc'     => 'application/vnd.sun.xml.calc.template',
            'std'     => 'application/vnd.sun.xml.draw.template',
            'sti'     => 'application/vnd.sun.xml.impress.template',
            'stw'     => 'application/vnd.sun.xml.writer.template',
            'sv4cpio' => 'application/x-sv4cpio',
            'sv4crc'  => 'application/x-sv4crc',
            'swf'     => 'application/x-shockwave-flash',
            'sxc'     => 'application/vnd.sun.xml.calc',
            'sxd'     => 'application/vnd.sun.xml.draw',
            'sxg'     => 'application/vnd.sun.xml.writer.global',
            'sxi'     => 'application/vnd.sun.xml.impress',
            'sxm'     => 'application/vnd.sun.xml.math',
            'sxw'     => 'application/vnd.sun.xml.writer',
            't'       => 'application/x-troff',
            'tar'     => 'application/x-tar',
            'tcl'     => 'application/x-tcl',
            'tex'     => 'application/x-tex',
            'texi'    => 'application/x-texinfo',
            'texinfo' => 'application/x-texinfo',
            'tgz'     => 'application/x-gtar',
            'tif'     => 'image/tiff',
            'tiff'    => 'image/tiff',
            'tr'      => 'application/x-troff',
            'tsv'     => 'text/tab-separated-values',
            'txt'     => 'text/plain',
            'ustar'   => 'application/x-ustar',
            'vbs'     => 'text/plain', //added by skwashd - for obvious reasons
            'vcd'     => 'application/x-cdlink',
            'vcf'     => 'text/x-vcard',
            'vcs'     => 'text/calendar',
            'vfb'     => 'text/calendar',
            'vrml'    => 'model/vrml',
            'vsd'     => 'application/vnd.visio',
            'wav'     => 'audio/x-wav',
            'wax'     => 'audio/x-ms-wax',
            'wbmp'    => 'image/vnd.wap.wbmp',
            'wbxml'   => 'application/vnd.wap.wbxml',
            'wm'      => 'video/x-ms-wm',
            'wma'     => 'audio/x-ms-wma',
            'wmd'     => 'application/x-ms-wmd',
            'wml'     => 'text/vnd.wap.wml',
            'wmlc'    => 'application/vnd.wap.wmlc',
            'wmls'    => 'text/vnd.wap.wmlscript',
            'wmlsc'   => 'application/vnd.wap.wmlscriptc',
            'wmv'     => 'video/x-ms-wmv',
            'wmx'     => 'video/x-ms-wmx',
            'wmz'     => 'application/x-ms-wmz',
            'wrl'     => 'model/vrml',
            'wvx'     => 'video/x-ms-wvx',
            'xbm'     => 'image/x-xbitmap',
            'xht'     => 'application/xhtml+xml',
            'xhtml'   => 'application/xhtml+xml',
            'xls'     => 'application/vnd.ms-excel',
            'xlt'     => 'application/vnd.ms-excel',
            'xml'     => 'application/xml',
            'xpm'     => 'image/x-xpixmap',
            'xsl'     => 'text/xml',
            'xwd'     => 'image/x-xwindowdump',
            'xyz'     => 'chemical/x-xyz',
            'z'       => 'application/x-compress',
            'zip'     => 'application/zip',
        );
        $type = strtolower(substr(strrchr($filename, '.'), 1));
        if (isset($contentType[$type])) {
            $mime = $contentType[$type];
        } else {
            $mime = 'application/octet-stream';
        }
        return $mime;
    }
}

if (!function_exists('image_type_to_extension')) {
    function image_type_to_extension($imagetype)
    {
        if (empty($imagetype)) {
            return false;
        }

        switch ($imagetype) {
            case IMAGETYPE_GIF:return '.gif';
            case IMAGETYPE_JPEG:return '.jpg';
            case IMAGETYPE_PNG:return '.png';
            case IMAGETYPE_SWF:return '.swf';
            case IMAGETYPE_PSD:return '.psd';
            case IMAGETYPE_BMP:return '.bmp';
            case IMAGETYPE_TIFF_II:return '.tiff';
            case IMAGETYPE_TIFF_MM:return '.tiff';
            case IMAGETYPE_JPC:return '.jpc';
            case IMAGETYPE_JP2:return '.jp2';
            case IMAGETYPE_JPX:return '.jpf';
            case IMAGETYPE_JB2:return '.jb2';
            case IMAGETYPE_SWC:return '.swc';
            case IMAGETYPE_IFF:return '.aiff';
            case IMAGETYPE_WBMP:return '.wbmp';
            case IMAGETYPE_XBM:return '.xbm';
            default:return false;
        }
    }

}
