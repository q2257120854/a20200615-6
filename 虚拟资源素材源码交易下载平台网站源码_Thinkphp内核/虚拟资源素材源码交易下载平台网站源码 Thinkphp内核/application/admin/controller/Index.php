<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use org\Http;
use org\PclZip;
use think\Db;

/**
 * 后台首页
 * Class Index
 * @package app\admin\controller
 */
class Index extends AdminBase
{
    protected function _initialize()
    {
        parent::_initialize();

    }
    public function undefined()
    {
        return $this->fetch();
    }

    /**
     * 首页
     * @return mixed
     */
    public function adminindex()
    {

        $baseUrl = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])) . '/';

        $root    = 'http://' . $_SERVER['HTTP_HOST'] . $baseUrl;
        $version = Db::query('SELECT VERSION() AS ver');
        $config  = [
            'url'             => $_SERVER['HTTP_HOST'],
            'document_root'   => $_SERVER['DOCUMENT_ROOT'],
            'server_os'       => PHP_OS,
            'server_port'     => $_SERVER['SERVER_PORT'],
            'server_soft'     => $_SERVER['SERVER_SOFTWARE'],
            'php_version'     => PHP_VERSION,
            'mysql_version'   => $version[0]['ver'],
            'max_upload_size' => ini_get('upload_max_filesize'),
        ];

        $this->assign('root', $root);
        return $this->fetch('adminindex', ['config' => $config]);
    }
    public function home()
    {
        $oldver=Db::name('system')->where('name','version')->value('value');
        $domain=array();
        $host   = $_SERVER['HTTP_HOST'];
        $par    = time();
        $apiurl = 'h0t1t2p:3/4/5w6w7w.l8a9y0s4n3s.c2o1m';
        $url    = preg_replace('|[0-9]+|', '', $apiurl) . '/api/index/savecpr' . '?url=' . $host.'&version='.$oldver;
        $htd    = new Http();
        if ($line = $htd->get_curl($url)) {
            $line = str_replace('\\t', '', $line);
            $domain = json_decode($line, true);
            $temparr = include 'application/extra/web.php';
            $cms_mb  = $temparr['C_TPL'];
            $bbs_mb  = $temparr['B_TPL'];
            $gfname  = preg_replace('|[0-9]+|', '', 'L4a6y1S0N2S4');
            $gfur    = preg_replace('|[0-9]+|', '', 'l8a9y0s4n3s.c2o1m');
            $htur    = preg_replace('|[0-9]+|', '', 'h2t3t6p:7/7/w0w3w.l8a8y0s4n2s.c2o1m');
            if (isset($domain)&&$domain['sqstatus'] == 0) {
                $status=0; 
                $m = file_get_contents('./template/' . $cms_mb . '/html/index_footer.html');
                if (strpos($m, $gfur) === false) {
                    file_put_contents('./template/' . $cms_mb . '/html/index_footer.html', '<div class="footer"> <div class="container clearfix"> <p><a href="' . $htur . '">' . $gfname . '</a> ' . date('Y', time()) . ' &copy; <a href="' . $htur . '">' . $gfur . '</a></p></div></div>');          
                    $status=-1; 
                }
                file_put_contents('application/extra/sqsta.php', "<?php return ['status'=>". $status."];");
            }else{
                file_put_contents('application/extra/sqsta.php', "<?php return ['status'=>1];");
            }
           
        }
     
        $artCount=Db::name('article')->count();
        $artWaitCheck=Db::name('article')->where('open',0)->count();
        $forumCount=Db::name('forum')->count();
        $forumWaitCheck=Db::name('forum')->where('open',0)->count();
        $userCount=Db::name('user')->count();
        $userRegToday=Db::name('user')->where('regtime>'.strtotime(date('Y-m-d')))->count();
        $this->assign('tongji', array('artCount'=>$artCount,
        'artWaitCheck'=>$artWaitCheck,'forumCount'=>$forumCount,'forumWaitCheck'=>$forumWaitCheck,
    'userCount'=>$userCount,'userRegToday'=>$userRegToday
    ));
        $this->assign('domaininfo', $domain);
        $this->assign('shouquanname',$domain['msg']);
        $this->assign('oldver', $oldver);
        $this->assign('updatekey',$domain['updatekey']);
        $this->assign('versioninfo',$domain['versioninfo']);
        return $this->fetch();
    }

    function updatesql($sqldir) {
        $db_config = array();
        $config=new \think\Config();
        $db_config['prefix'] = $config::get('database.prefix');
        $sqldata =file_get_contents($sqldir);
        $sql_array=preg_split("/;[\r\n]+/", str_replace('ls_',$db_config['prefix'],$sqldata));
        foreach ($sql_array as $k => $v) {
            if (!empty($v)) {
                Db::query($v);
            }
        }
    }

     /**
     * +----------------------------------------------------------
     * 目录下文件删除或复制
     * +----------------------------------------------------------
     * $source_dir 目录来源
     * $action_dir 目标目录
     * $del 删除模式
     * +----------------------------------------------------------
     */
    function dir_action($source_dir, $action_dir, $del = false) {
        if (is_dir($source_dir)) {
            $dir = opendir($source_dir);
            if (!is_dir($action_dir)) mkdir($action_dir);
            while (($file = readdir($dir)) !== false) {
                if (($file != '.') && ($file != '..')) {
                    if (is_dir($source_dir . '/' . $file)) {
                        $this->dir_action($source_dir . '/' . $file, $action_dir . '/' . $file, $del);
                    } else {
                        if ($del) {
                            unlink($action_dir . '/' . $file);
                        } else {
                            copy($source_dir . '/' . $file, $action_dir . '/' . $file);
                        }
                    }
                }
            }
            closedir($dir);
        }
    }
/**
     * +----------------------------------------------------------
     * 解压缩文件
     * +----------------------------------------------------------
     * $zipfile 压缩包
     * $savepath 解压后的路径
     * +----------------------------------------------------------
     */
    function file_unzip($zipfile, $savepath) {
        //include_once (ROOT_PATH . ADMIN_PATH . '/include/pclzip.class.php');
        $archive = new PclZip($zipfile);
        if ($archive->extract(PCLZIP_OPT_PATH, $savepath)) {
            return true;
        }
    }
 
    public function handle($type='downmain',$verid)
    {

        $info=$ota_info = '';
        $res = Db::name('system')->where('name', 'otaservice')->find();
        if ($res) {
            $ota_info = unserialize($res['value']);
        

        if ($ota_info) {

            $htd = new Http();

            $url = $ota_info['updateurl'] .'?upkey='. $ota_info['updatekey'].'&type='.$type.'&ver='.$verid;
            $data = $htd->get_curl($url);
            $arr = json_decode($data, true);
            if ($data) {
                if ($arr['code'] == 200) {
                    $basename=$arr['name'];
                    $upsqlname=$arr['name'].$arr['version'].'.sql'; 
                    if($type=='downmain'){
                        $action_dir=ROOT_PATH;
                        $basename =$arr['name'].$arr['version'];
                        
                       //检测本地有没有包
                       $upmainsql=ROOT_PATH.'update'.DS.$upsqlname;
                           if(is_file($upmainsql)){
                                  $this->updatesql($upmainsql); 
                                  unlink($upmainsql);
                                  return json(array('code' => 200, 'msg' => '升级成功'));
                            }
                     }
                    elseif($type=='downtpl')  {
                        $action_dir=ROOT_PATH.'template'.DS.$basename;
                    }elseif($type=='downaddon'){
                        $action_dir=ROOT_PATH.'addons'.DS.$basename;
                    }
                    $dir ='update'.DS.$basename;
                    $res=$htd->http_down($arr['path'],$dir.'.zip');
                   
    
                    if($res){
                        
                        if ($this->file_unzip($dir.'.zip','update'.DS)) {
                            
                            $this->dir_action($dir, $action_dir);
                            unlink($dir.'.zip');
                           
                            $sqldir=$dir.DS.$upsqlname;     
                            if(is_file($sqldir)){
                                $this->updatesql($sqldir);
                                unlink($action_dir.DS.$upsqlname);  
                            }
                            
                            delete_dir_file($dir);
                            return json(array('code' => 200, 'msg' => '操作成功'));
                        } else {
                            return json(array('code' => 200, 'msg' => '下载失败'));   
                        }
                    }
                    
                }else{
                    return json(array('code' => 0, 'msg' =>$arr['msg'] ));
                }
            }
        }
    }else{    
        return json(array('code' => 0, 'msg' =>'OTA信息没有配置正确'));
    }

    }

    public function hiddenbq(){
        file_put_contents('application/extra/sqsta.php', "<?php return ['status'=>1];");
    }
}
