<?php
namespace app\admin\controller;
use Captcha\Captcha;
use think\Config;
use think\Controller;
use think\Db;
use think\Session;

/**
 * 后台登录
 * Class Login
 * @package app\admin\controller
 */
class Login extends Controller
{
    public function captcha()
    {
        $m = new Captcha(Config::get('captcha'));

        $img = $m->entry();
        return $img;
    }
    /**
     * 后台登录
     * @return mixed
     */
    public function index()
    {
     
        $site_config = Db::name('system')->field('value')->where('name', 'site_config')->find();
        $site_config = unserialize($site_config['value']);
        $yzmarr = explode(',', $site_config['site_yzm']);
        //设置后台登录的参数
       
        if(isset($site_config['safe_dir'])&&$site_config['safe_dir']!=input('v')){
            die('非法登录');
        }
       
        $code =  isset($site_config['security_code'])?$site_config['security_code']:0;
        if (in_array(4, $yzmarr)||$code) {
            $yzm = 1;
        } else {
            $yzm = 0;
        }
        $this->assign('yzm', $yzm);
        $this->assign('code', $code);
        return $this->fetch('index');
    }

    /**
     * 登录验证
     * @return string
     */
    public function login()
    {

        $site_config = Db::name('system')->field('value')->where('name', 'site_config')->find();
        $site_config = unserialize($site_config['value']);
        $yzmarr = explode(',', $site_config['site_yzm']);
        $code =  isset($site_config['security_code'])?$site_config['security_code']:0;
        if (in_array(4, $yzmarr)) {
            $yzm = 1;
        } else {
            $yzm = 0;
        }
          

        if ($this->request->isPost()) {
            $data = $this->request->only(['username', 'password', 'verify']);
            
            if ($yzm == 1||$code) {

                $flag=1;
                if($code){
                    $securityCode = Db::name('admin_user')->where(array('username' => $data['username']))->value('security_code');
                    if($securityCode!=$data['verify']){
                        $flag=0;
                    }
                }else if(!captcha_check($data['verify'])){
                        $flag=0;    
                }
              
                if (!$flag) {
                    return json(array('code' => 0, 'msg' => '验证码错误'));
                }
            }
            $salt = Db::name('admin_user')->where(array('username' => $data['username']))->value('salt');
            $where['username'] = $data['username'];
            $where['password'] = md5($data['password'] . $salt);
            $admin_user = Db::name('admin_user')->field('id,username,status')->where($where)->find();
            if (!empty($admin_user)) {
                if ($admin_user['status'] != 1) {
                    return json(array('code' => 0, 'msg' => '当前用户已禁用'));
                } else {
                    Session::set('admin_id', $admin_user['id']);
                    Session::set('admin_name', $admin_user['username']);
                    Db::name('admin_user')->update(
                        [
                            'last_login_time' => time(),
                            'last_login_ip' => $this->request->ip(),
                            'id' => $admin_user['id'],
                        ]
                    );
                    return json(array('code' => 200, 'msg' => '登录成功'));
                }
            } else {
                return json(array('code' => 0, 'msg' => '用户名或密码错误'));
            }

        }
    }
   
    /**
     * 退出登录
     */
    public function logout()
    {
        Session::delete('admin_id');
        Session::delete('admin_name');
        return json(array('code' => 200, 'msg' => '退出成功'));
    }
}
