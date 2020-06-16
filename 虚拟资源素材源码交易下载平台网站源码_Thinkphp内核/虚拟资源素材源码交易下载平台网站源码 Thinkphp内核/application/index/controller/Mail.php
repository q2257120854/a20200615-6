<?php
namespace app\index\controller;

use app\common\controller\HomeBase;
use think\Cache;
use think\Db;

class Mail extends HomeBase
{
    protected $site_config;
    public function _initialize()
    {
        parent::_initialize();
        $this->site_config = Cache::get('site_config');
    }

    public function send_mail($mail)
    {

        $res = send_mail_local($mail['email'], $mail['title'], $mail['body']);
        if ($res) {
            return json(array('code' => 1, 'msg' => '邮件已发送，请到邮箱进行查收'));
        } else {
            return json(array('code' => 0, 'msg' => '发送失败，请通知管理员检查邮件服务器配置'));
        }
    }
    public function yzemail()
    {
        $mail = $this->request->param();
        $uid = session('userid');

        $user = db('user')->where(array('id' => $uid))->find();
        $mailarr = db('user')->column('usermail');
        if (in_array($mail['email'], $mailarr) && $user['usermail'] != $mail['email']) {
            return json(array('code' => 0, 'msg' => '该邮箱已经被其他账号注册'));
        } else {
            $n['usermail'] = $mail['email'];
            db('user')->where(array('id' => $uid))->update($n);
            $data['email'] = $mail['email'];
            $data['title'] = '邮箱验证';
            $str = md5($user['salt'] . $uid . $data['email']);
            $url = (is_HTTPS()?'https://':'http://').$_SERVER['HTTP_HOST'].url('user/index/yzemail') . '?id=' . $str;
             //邮件模板替换
            $data['body'] = htmlspecialchars_decode(str_replace(['{username}', '{site_title}', '{url}'], [$user['username'], $this->site_config['site_title'], $url], $this->site_config['mail_tpl_active']));
            return $this->send_mail($data);
        }

    }
    public function reyzemail()
    {
        $mail = $this->request->param();
        $uid = session('userid');
        $user = db('user')->where(array('id' => $uid))->find();
        $mailarr = db('user')->column('usermail');
        if (in_array($mail['email'], $mailarr) && $user['usermail'] != $mail['email']) {
            return json(array('code' => 0, 'msg' => '该邮箱已经被其他账号注册'));
        } else {
            $n['usermail'] = $mail['email'];
            if ($user['status'] == 2) {
                $n['status'] = 1;
            } else {
                $n['status'] = 3;
            }
            db('user')->where(array('id' => $uid))->update($n);
            $data['email'] = $mail['email'];
            $data['title'] = '邮箱验证';
            $str = md5($user['salt'] . $uid . $data['email']);
            $url = (is_HTTPS()?'https://':'http://').$_SERVER['HTTP_HOST'].url('user/index/yzemail') . '?id=' . $str;
            //邮件模板替换
            $data['body'] = htmlspecialchars_decode(str_replace(['{username}', '{site_title}', '{url}'], [$user['username'], $this->site_config['site_title'], $url], $this->site_config['mail_tpl_active']));
            return $this->send_mail($data);
        }
    }

}
