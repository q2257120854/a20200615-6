<?php
namespace app\user\controller;

use app\common\controller\HomeBase;
use app\common\model\User as UserModel;
use think\Cache;
use think\Db;

class Login extends HomeBase
{
    protected $site_config;
    protected $yzmarr;
    protected $openSms;
    public function _initialize()
    {
        parent::_initialize();
        $this->site_config = Cache::get('site_config');

        $this->yzmarr = explode(',', $this->site_config['site_yzm']);
        $this->openSms = @$this->site_config['open_sms'];
        if (in_array(1, $this->yzmarr)||$this->openSms) {
            $regyzm = 1;
        } else {
            $regyzm = 0;
        }
        if (in_array(2, $this->yzmarr)) {
            $loginyzm = 1;
        } else {
            $loginyzm = 0;
        }
        if (in_array(3, $this->yzmarr)) {
            $forgetyzm = 1;
        } else {
            $forgetyzm = 0;
        }
        $qq_login= $this->site_config['open_qqlogin'];
        $this->assign('regyzm', $regyzm);
        $this->assign('loginyzm', $loginyzm);
        $this->assign('forgetyzm', $forgetyzm);
        $this->assign('sendsms', $this->openSms);
        $this->assign('qq_login', $qq_login);
    }
    public function index()
    {
		session('callbackurl', isset($_SERVER['HTTP_REFERER'])?@$_SERVER['HTTP_REFERER']:url('index/index/index'));
        if(session('userid')!=''){
            $this->error('你已登录',url('index/index/index'));
        }
       
        $site_config = Cache::get('site_config');
        $yzmarr = explode(',', $site_config['site_yzm']);

        if (in_array(2, $yzmarr)) {
            $loginyzm = 1;
        } else {
            $loginyzm = 0;
        }

        $this->assign('loginyzm', $loginyzm);
        $member = new UserModel();
        if (request()->isPost()) {

            if (in_array(2, $yzmarr)) {
                if (!captcha_check(input('code'))) {

                    return json(array('code' => 0, 'msg' => '验证码错误'));

                }

            }
            $data = input('post.');
            $status['status'] = array('gt', 0);
            $userstr = $data['username'];
            //用户名、邮箱、手机号均可登陆
            if (preg_match("/^1[34578]\d{9}$/", $userstr)) {
                $map['mobile'] = $userstr;
            } else {
                $map['username|usermail'] = $userstr;
            }
            $user = $member->where($status)->where($map)->find();

            if ($user) {

                $user = updategrade($user);
                if ($user['password'] == md5($data['pass'] . $user['salt'])) {

                    if ($user['userhead'] == '') {
                        $user['userhead'] = '/public/images/default.png';
                    }
                    session('userstatus', $user['status']);
                    session('grades', $user['grades']);
                    session('userhead', $user['userhead']);
                    session('username', $user['username']);
                    session('userid', $user['id']);
                    session('point', $user['point']);
                    session('developer', $user['developer']);
                    $cook = array('id' => $user['id'], 'status' => $user['status'], 'point' => $user['point'], 'username' => $user['username'], 'userhead' => $user['userhead'], 'grades' => $user['grades']);

                    //获取消息
                   
                       // $result = action('user/message/getUnreadMsg');

                    systemSetKey($cook);

                    $member->update(
                        [
                            'last_login_time' => time(),
                            'last_login_ip' => $this->request->ip(),
                            'id' => $user['id'],
                        ]
                    );
                    point_note($site_config['jifen_login'], session('userid'), 'login');

                    return json(array('code' => 200, 'msg' => '登录成功'));
                } else {
                    return json(array('code' => 0, 'msg' => '密码错误'));
                }
            } else {
                return json(array('code' => 0, 'msg' => '账号错误或已禁用'));
            }
        }
        return view();
    }

    public function reg()
    {
		session('callbackurl', url('index/index/index'));
        if(session('userid')!=''){
            $this->error('必须是未登录状态才可以注册',url('index/index/index'));
        }
        $regswitch = Cache::get('site_config');
        if (!$regswitch['user_reg']) {
            $this->error('网站已关闭会员注册功能', url('index/index'));
        }
        $member = new UserModel();
        if (request()->isPost()) {

            if (!$regswitch['user_reg']) {
                return json(array('code' => 0, 'msg' => '网站已关闭会员注册功能'));
            }
            $data = $this->request->post();
            $arr = include 'application/extra/reserved.php';
                foreach ($arr as $k => $v) {
                   if (strpos($data['username'], $v) !== false) {
                        return json(array('code' => 0, 'msg' => '你的用户名被禁止注册'));
                    }
                }
            $password = input('password');
            if (in_array(1, $this->yzmarr)) {
                if (!captcha_check(input('code'))) {
                    return json(array('code' => 0, 'msg' => '图形码错误'));

                }

            }
            $sendSmsId=0;
            if ($this->openSms) {
                $sendSmsId=sms_code_check(input('sms_code'),input('mobile'),'REG');
                if (!$sendSmsId) {
                    return json(array('code' => 0, 'msg' => '验证码错误'));
                }
            }

            $validate_result = $this->validate($data, 'User');

            if ($validate_result !== true) {
                // $this->error($validate_result);
                return json(array('code' => 0, 'msg' => $validate_result));
            } else {

                $_data['salt'] = generate_password(18);
                $_data['regtime'] = time();
                $_data['username'] = remove_xss($data['username']);
                if(is_numeric($data['username'])||is_numeric(substr($data['username'],0,1))||mb_strwidth($data['username'])<4){
                    return json(array('code' => 0, 'msg' => '不能是纯数字或数字开头，一个汉字算2个字符')); 
                }
                $_data['grades'] = 1;//这里应该是1,修复注册后后台查看用户崩溃
                $_data['status'] = 1; //config('web.WEB_REG');
                $_data['point'] = $this->site_config['jifen_reg']; //config('point.REG_POINT');
                $_data['userhead'] = '/public/images/default.png';
                $_data['userip'] = $_SERVER['REMOTE_ADDR'];
                $_data['password'] = md5($password . $_data['salt']);
              
                if ($member->allowField(true)->save($_data)) {

                    point_note($regswitch['jifen_reg'], $member->id, 'reg');

                    if($sendSmsId){
                        Db::name('sms')->where('id',$sendSmsId)->setField(['status'=>10]);
                    }
                    return json(array('code' => 200, 'msg' => '注册成功'));
                } else {

                    return json(array('code' => 0, 'msg' => '注册失败'));
                }

            }
        }

        //  $data = input('post.');

        return view();
    }

    public function resetpass()
    {

        $input = $this->request->param();
        $token=remove_xss($input['token']);
        if(!$token){
            return json(array('code' => 0, 'msg' => '非法操作'));
        }

        if (in_array(3, $this->yzmarr)) {
            if (!captcha_check(input('code'))) {

                return json(array('code' => 0, 'msg' => '验证码错误'));

            }

        }

        if ($input['pass'] != $input['repass']) {
            return json(array('code' => 0, 'msg' => '两次密码输入不一致'));
        } else {

            $n = Db::name('user')->where(['forget_passwd_token'=> $input['token']])->find();
            if(!$n||@$n['forget_passwd_endtime']<time()){
                return json(array('code' => 0, 'msg' => '链接失效无效（可能超过10分钟），请重新操作'));
            }
            $setData['password']=md5($input['pass'] . $n['salt']);
            $setData['forget_passwd_token']='';
            $setData['forget_passwd_endtime']=0;
            Db::name('user')->where('id', $n['id'])->setField($setData);
            return json(array('code' => 200, 'msg' => '密码修改成功，请重新登录'));

        }

    }

    public function resetmima()
    {
        $input = $this->request->param();

        //查询token
        $mod=is_number($input['mod'])?$input['mod']:0;

        if(!$mod){
            $this->error('非法操作', url('user/login/forget'));
        }

        $n = Db::name('user')->where('id', $mod)->find();
        if (md5($n['salt'] . $n['id'] . $n['usermail']) == remove_xss($input['id'])&&$n['forget_passwd_endtime']>=time()) {

            $this->assign('token', $n['forget_passwd_token']);
            $this->assign('username', $n['username']);
            return view();
        } else {
            $this->error('激活链接无效（或已超过有效期10分钟），请重新操作', url('user/login/forget'));
        }

    }

    public function forget()
    {

        if (request()->isPost()) {

            $datan = $this->request->param();

            if (in_array(3, $this->yzmarr)) {
                if (!captcha_check(input('code'))) {

                    return json(array('code' => 0, 'msg' => '验证码错误'));

                }

            }

            $n = Db::name('user')->where('usermail', $datan['usermail'])->find();

            if (empty($n) || ($n['status'] != 2 && $n['status'] != 5)) {
                return json(array('code' => 0, 'msg' => '邮箱未激活或邮箱未注册'));
            } else {

                $data['email'] = $n['usermail'];

                $data['title'] = '找回密码';
                $str = md5($n['salt'] . $n['id'] . $n['usermail']);
                $http=is_HTTPS()?'https://':'http://';
                $url = $http.$_SERVER['HTTP_HOST'].url('user/login/resetmima') . '?mod=' . $n['id'] . '&id=' . $str;
                //邮件模板替换
                $data['body'] = str_replace(['{username}', '{site_title}', '{url}'], [$n['username'], $this->site_config['site_title'], $url], $this->site_config['mail_tpl_resetpwd']);
                $res = send_mail_local($data['email'], $data['title'], $data['body']);
                if ($res) {
                    $save['forget_passwd_token']=$str;
                    $save['forget_passwd_endtime']=time()+600;
                    Db::name('user')->where('id',$n['id'])->update($save);
                    return json(array('code' => 1, 'msg' => '邮件已发送，请到邮箱进行查收。激活邮件10分钟内有效'));
                } else {
                    return json(array('code' => 0, 'msg' => '发送失败，请通知管理员检查邮件服务器配置'));
                }
            }

        } else {
            return view();
        }

    }
    public function logout()
    {
        
        cookie('sys_key', null);
        session(null);
        return json(array('code' => 200, 'msg' => '退出成功'));
        //  return NULL;
    }
}
