<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\model\Upload as UploadModel;
use think\Cache;
use think\Db;
use org\Http;

/**
 * 系统配置
 * Class System
 * @package app\admin\controller
 */
class System extends AdminBase
{
    public function _initialize()
    {
        parent::_initialize();

    }

    /**
     * 站点配置
     */
    public function siteConfig()
    {
        $site_config = Db::name('system')->field('value')->where('name', 'site_config')->find();
        $site_config = unserialize($site_config['value']);
        return $this->fetch('site_config', ['site_config' => $site_config]);
    }

    /**
     * 更新配置
     */
    public function updateSiteConfig()
    {
        if ($this->request->isPost()) {
            $site_config = $this->request->post('site_config/a');
            $site_config['site_tongji'] = htmlspecialchars_decode($site_config['site_tongji']);
            $data['value'] = serialize($site_config);

            $path = 'application/config.php';
            $str = '<?php return [';
            if ($site_config['site_wjt'] == 1) {
                $str .= "'app_debug'           => true,'log' =>['level' => ['error']],'http_exception_template'=>[404 => APP_PATH.'404.html',401 =>APP_PATH.'401.html']";
            } else {
                $str .= "'app_debug'           => false,'log' =>['level' => ['error']],'http_exception_template'=>[404 => APP_PATH.'404.html',401 =>APP_PATH.'401.html']";
            }
            $str .= ']; ';
            file_put_contents($path, $str);

            //写入CMS/BBS开关
            $cbstr = "<?php return [" . "'cb_open'=>" . $site_config['cb_open'] . "]; ";
            file_put_contents('application/extra/cbopen.php', $cbstr);

            if (Db::name('system')->where('name', 'site_config')->update($data) !== false) {
                Cache::set('site_config', null);

                return json(array('code' => 200, 'msg' => '提交成功'));
            } else {
                return json(array('code' => 200, 'msg' => '提交失败'));
            }
        }
    }

  

    public function get_theme_info($tpl_name)
    {
        $theme_url = DS . 'template' . DS;
        $info=array();
        if(is_dir(ROOT_PATH . $theme_url . $tpl_name . DS)){
            $info = include ROOT_PATH . $theme_url . $tpl_name . DS . 'config.php';
            
            $info['image'] = WEB_URL . $theme_url . $tpl_name . DS . 'images' . DS . 'covershow.png';
            $info['tpl_name'] = $tpl_name;
            return $info;
        }
       
        
    }

    public function template()
    {
        //数据库获取
        $tpl_use = array('cms_tpl' => 'c_default', 'bbs_tpl' => 'b_default', 'user_tpl' => 'u_default');
        $res = Db::name('system')->where('name', 'template')->find();
        if ($res) {
            $tpl_use = unserialize($res['value']);
        } else {
            $data['name'] = 'template';
            $data['value'] = serialize($tpl_use);
            $reslut = Db::name('system')->insert($data);
        }
        $theme_list = array();
        $cms_tpl = $this->get_theme_info($tpl_use['cms_tpl']);
        $bbs_tpl = $this->get_theme_info($tpl_use['bbs_tpl']);
        $user_tpl = $this->get_theme_info($tpl_use['user_tpl']);
        $theme_array = get_subdirs(ROOT_PATH . 'template' . DS);
        foreach ($theme_array as $tpl_name) {
            
                if (in_array($tpl_name, $tpl_use)||strpos($tpl_name,'_') ===false||check_addon_ser($tpl_name)===false) {
                    continue;
                }

                $theme_list[] = $this->get_theme_info($tpl_name);
            
        }

        $this->assign('cms_tpl', $cms_tpl);
        $this->assign('bbs_tpl', $bbs_tpl);
        $this->assign('user_tpl', $user_tpl);
        $this->assign('theme_list', $theme_list);
        return view();
    }
    public function deltpl($tpl_name)
    {
        $theme_array =get_subdirs(ROOT_PATH . 'template' . DS);
        if (in_array($tpl_name, $theme_array)) { // 判断删除操作的模板是否真实存在
            delete_dir_file(ROOT_PATH . 'template' . DS . $tpl_name);
            return json(array('code' => 200, 'msg' => '模板文件删除成功'));
        } else {
            return json(array('code' => 0, 'msg' => '目录不存在'));
        }
    }
    public function usetpl($tpl_name)
    {
        $theme_array = get_subdirs(ROOT_PATH . 'template' . DS);
        if (in_array($tpl_name, $theme_array)) { // 判断删除操作的模板是否真实存在
            // 替换系统设置中模板值
            $res = Db::name('system')->where('name', 'template')->value('value');
            $tpl_use = unserialize($res);
            if (strpos($tpl_name, "_") !== false) {

                $arr = explode('_', $tpl_name);
                switch ($arr[0]) {
                    case 'c':
                        $tpl_use['cms_tpl'] = $tpl_name;
                        break;
                    case 'b':
                        $tpl_use['bbs_tpl'] = $tpl_name;
                        break;
                    case 'u':
                        $tpl_use['user_tpl'] = $tpl_name;
                        break;
                    default:
                        return json(array('code' => 0, 'msg' => '模板错误'));
                }

                $reslut = Db::name('system')->where('name', 'template')->update(['value' => serialize($tpl_use)]);
                if ($reslut) {
                    $config = array(
                        'C_TPL' => $tpl_use['cms_tpl'],
                        'B_TPL' => $tpl_use['bbs_tpl'],
                        'U_TPL' => $tpl_use['user_tpl'],
                    );

                    $path = 'application/extra/web.php';
                    $str = '<?php return [';

                    foreach ($config as $key => $value) {
                        $str .= '\'' . $key . '\'' . '=>' . '\'' . $value . '\'' . ',';
                    };
                    $str .= ']; ';

                    file_put_contents($path, $str);
                    return json(array('code' => 200, 'msg' => '模板启用成功'));

                } else {
                    return json(array('code' => 0, 'msg' => '失败'));
                }
            }
        }
    }
    public function temponline()
    {
        $info = $ota_info = '';
        $res = Db::name('system')->where('name', 'otaservice')->find();
        if ($res) {
            $ota_info = unserialize($res['value']);
        }

        if ($ota_info) {

            $htd = new Http();
            $addon_array = get_subdirs(ROOT_PATH . 'template' . DS);
            $url = $ota_info['updateurl'] . '?upkey=' . $ota_info['updatekey'] . '&type=tmplist';
            $data = $htd->get_curl($url);
            $arr = json_decode($data, true);
            if ($data) {
                if ($arr['code'] == 200) {
                    $info = $arr['info'];
                    foreach($info as $k=>$v){
                        $info[$k]['is_down']=0;
                      if (in_array($v['addonname'], $addon_array)) {
                        $info[$k]['is_down']=1;
                      }
                      $res=$this->get_theme_info($v['addonname']);
                     if($res){
                        if($res['version']<$v['version'])
                        {
                               $info[$k]['is_down']=2;
                        }
                     }    
                    }
                } else {
                    $info = $arr['msg'];
                }
            }
        }
        $this->assign('keyvalue', $ota_info['updatekey']);
        $this->assign('theme_list', $info);
        return view();
    }

    /**
     * 清除缓存
     */
    public function clear()
    {
        delete_dir_file(CACHE_PATH);
        array_map('unlink', glob(TEMP_PATH . '/*.php'));
        if (!file_exists(TEMP_PATH)) {
            return json(array('code' => 200, 'msg' => '暂无缓存'));
        } else {
            rmdir(TEMP_PATH);
            return json(array('code' => 200, 'msg' => '更新缓存成功'));
        }

    }
    public function doUploadPic()
    {
        $uploadmodel = new UploadModel();
        $info = $uploadmodel->upfile('images', 'FileName');
        echo $info['headpath'];
    }
    public function ajax_mail_test()
    {
        $data = $this->request->param();

        if (!$data['email']) {
            return json(array('code' => 0, 'msg' => '邮箱地址为空'));
        } else {

            $data['body'] = '测试邮件内容';
            $data['title'] = '测试邮件标题';

            $res = send_mail_local($data['email'], $data['title'], $data['body']);
            if ($res) {
                return json(array('code' => 1, 'msg' => '邮件已发送，请到邮箱进行查收'));
            } else {
                return json(array('code' => 0, 'msg' => '发送失败，请检查邮件服务器配置'));
            }

        }
    }

    public function signrule()
    {
        $rules = Db::name('user_signrule')->select();
        $this->assign('rules', $rules);
        return $this->fetch('signrule');
    }
    public function updatesignrule()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $daysarr = $data['days'];
            $scorearr = $data['score'];
            Db::name('user_signrule')->where('id', '>', 0)->delete();
            $arr = [];
            foreach ($daysarr as $i => $days) {
                $score = $scorearr[$i];
                $arr[$i] = ['days' => $days, 'score' => $score];
            }
            Db::name('user_signrule')->insertAll($arr);
            return json(array('code' => 200, 'msg' => '提交成功'));
        }
    }
    public function qqlogin()
    {
        $qqlogin_config = Db::name('system')->field('value')->where('name', 'qqlogin')->find();

        $qqlogin_config = unserialize($qqlogin_config['value']);
        $this->assign('qqlogin', $qqlogin_config);
        return $this->fetch('qqlogin');
    }
    public function ota()
    {
        $ota_info = '';
        $res = Db::name('system')->where('name', 'otaservice')->find();
        if ($res) {
            $ota_info = unserialize($res['value']);
        }
        $this->assign('ota_info', $ota_info);
        return $this->fetch();
    }
    public function updateota()
    {
        if ($this->request->isPost()) {
            $ota_config = $this->request->post();
            $data['value'] = serialize($ota_config);

            $reslut = 0;
            $res = Db::name('system')->where('name', 'otaservice')->find();
            if ($res) {
                $reslut = Db::name('system')->where('name', 'otaservice')->update($data);
            } else {
                $data['name'] = 'otaservice';
                $reslut = Db::name('system')->insert($data);
            }
            if ($reslut) {

                return json(array('code' => 200, 'msg' => '保存成功'));
            } else {
                return json(array('code' => 200, 'msg' => '提交失败'));
            }
        }
    }
    public function updateqqlogin()
    {
        if ($this->request->isPost()) {
            $site_config = $this->request->post('qqlogin/a');
            $data['value'] = serialize($site_config);

            if (Db::name('system')->where('name', 'qqlogin')->update($data) !== false) {
                //  Cache::set('site_config', null);
                session('qqconnect', null);
                return json(array('code' => 200, 'msg' => '提交成功'));
            } else {
                return json(array('code' => 200, 'msg' => '提交失败'));
            }
        }

    }
    public function qiniu()
    {
        $qiniu_config = Db::name('system')->field('value')->where('name', 'qiniu')->find();

        $qiniu_config = unserialize($qiniu_config['value']);
        $this->assign('qiniu', $qiniu_config);
        return $this->fetch('qiniu');
    }
    public function updateqiniu()
    {
        if ($this->request->isPost()) {
            $site_config = $this->request->post('qiniu/a');
            $data['value'] = serialize($site_config);

            if (Db::name('system')->where('name', 'qiniu')->update($data) !== false) {
                return json(array('code' => 200, 'msg' => '提交成功'));
            } else {
                return json(array('code' => 200, 'msg' => '提交失败'));
            }
        }

    }
    public function taoke()
    {
        $taoke_config = Db::name('system')->field('value')->where('name', 'taoke')->find();

        $taoke_config = unserialize($taoke_config['value']);
        $this->assign('taoke', $taoke_config);
        return $this->fetch('taoke');
    }
    public function updatetaoke()
    {
        if ($this->request->isPost()) {
            $taoke_config = $this->request->post('taoke/a');
            $data['value'] = serialize($taoke_config);

            $reslut = 0;
            $res = Db::name('system')->where('name', 'taoke')->find();
            if ($res) {
                $reslut = Db::name('system')->where('name', 'taoke')->update($data);
            } else {
                $data['name'] = 'taoke';
                $reslut = Db::name('system')->insert($data);
            }
            if ($reslut) {
                return json(array('code' => 200, 'msg' => '保存成功'));
            } else {
                return json(array('code' => 200, 'msg' => '提交失败'));
            }
        }

    }

    public function watermark()
    {
        $watermark_config = Db::name('system')->field('value')->where('name', 'watermark')->find();

        $watermark_config = unserialize($watermark_config['value']);
   
        $this->assign('watermark', $watermark_config);
        return $this->fetch('watermark');
    }
    public function updatewatermark()
    {
        if ($this->request->isPost()) {
            $ota_config = $this->request->post();
            $data['value'] = serialize($ota_config);

            $reslut = 0;
            $res = Db::name('system')->where('name', 'watermark')->find();
            if ($res) {
                $reslut = Db::name('system')->where('name', 'watermark')->update($data);
            } else {
                $data['name'] = 'watermark';
                $reslut = Db::name('system')->insert($data);
            }
            if ($reslut) {

                return json(array('code' => 200, 'msg' => '保存成功'));
            } else {
                return json(array('code' => 200, 'msg' => '提交失败'));
            }
        }
    }
    public function pay()
    {
        $pay_info = '';
        $res = Db::name('system')->where('name', 'payservice')->find();
        if ($res) {
            $pay_info = unserialize($res['value']);
        }
        $this->assign('pay_info', $pay_info);
        return $this->fetch();
    }
    public function updatepay()
    {
        if ($this->request->isPost()) {
            $ota_config = $this->request->post();
            $data['value'] = serialize($ota_config);

            $reslut = 0;
            $res = Db::name('system')->where('name', 'payservice')->find();
            if ($res) {
                $reslut = Db::name('system')->where('name', 'payservice')->update($data);
            } else {
                $data['name'] = 'payservice';
                $reslut = Db::name('system')->insert($data);
            }
            if ($reslut) {
                return json(array('code' => 200, 'msg' => '保存成功'));
            } else {
                return json(array('code' => 200, 'msg' => '提交失败'));
            }
        }
    }
    public function sms()
    {
        $sms_config = Db::name('system')->field('value')->where('name', 'sms')->find();

        $sms_config = unserialize($sms_config['value']);
        $this->assign('sms', $sms_config);
        return $this->fetch('sms');
    }
	public function updatesms()
    {
        if ($this->request->isPost()) {
            $site_config = $this->request->post('sms/a');
            $data['value'] = serialize($site_config);

            $reslut = 0;
            $res = Db::name('system')->where('name', 'sms')->find();
            if ($res) {
                $reslut = Db::name('system')->where('name', 'sms')->update($data);
            } else {
                $data['name'] = 'sms';
                $reslut = Db::name('system')->insert($data);
            }
            if ($reslut) {
                return json(array('code' => 200, 'msg' => '保存成功'));
            } else {
                return json(array('code' => 200, 'msg' => '提交失败'));
            }
        }

    }
}
