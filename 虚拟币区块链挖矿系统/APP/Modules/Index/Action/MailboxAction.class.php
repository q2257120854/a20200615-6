<?php
Class MailboxAction extends CommonAction{
    //私人信息
    public function index() {
        $this->checkUserSecondLogin();
        $list = M('mailbox')->where(array('member'=> session('username')))->select();
        $this->assign('list',$list);
        $this->display();
    }
    
    //查看信息
    public function viewMail(){
        $this->checkUserSecondLogin();
        $id = I('get.id',0,'strval');
        $mail = M('mailbox')->where(array('id'=>$id))->find();
        $this->assign('mail',$mail);
        $this->display();
    }
    
    //删除信息
    public function deleteMail(){
        $id = I('get.id',0,'strval');
        if (M('mailbox')->where(array('id'=>$id))->delete()) {
            alert('操作成功！',U('Index/Mailbox/index'));
        }else{
            alert('操作失败！',U('Index/Mailbox/index'));
        }
    }
    
    
}
