<?php
class ShaiAction extends CommonAction {

    public function gonggao(){

        $config = include './App/Conf/system.php';
        $this->assign('config',$config);
        $this->display();
    }


    public function gonggaoxg(){
        $path = './App/Conf/system.php';
        $config = include $path;

        $config['yxgg']      = I('post.yxgg','','trim');
        $data = "<?php\r\nreturn " . var_export($config, true) . ";\r\n?>";
        if (file_put_contents($path, $data)) {
            $this->success('修改成功', U(GROUP_NAME.'/Shai/gonggao'));
        } else {
            $this->error('修改失败， 请修改' . $path . '的写入权限');
        }
    }
    public function kaijiang(){
        $Data = M('kailog'); // 实例化Data数据对象
        import("@.ORG.Util.Page");// 导入分页类
        $map = array();

        if (isset($_POST['starttime']) && $_POST['starttime']!='') {
            $map['starttime'] = array("egt",strtotime($_POST['starttime']));
        }
        if (isset($_POST['endtime']) && $_POST['endtime']!='') {
            $map['starttime'] = array("elt",strtotime($_POST['endtime']));
        }

        $count      = $Data->where($map)->count();// 查询满足要求的总记录数
        $Page       = new Page($count,50);// 实例化分页类 传入总记录数


        $list = $Data->where($map)->order('starttime desc')->limit($Page ->firstRow.','.$Page -> listRows)->select();
        $show       = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('list',$list);// 赋值数据集
        $this->display(); // 输出模板
    }


    public function kong(){
        $kid = $_POST['kid'];
        $id = $_POST['id'];
        $info = M('kailog')->where(array('id'=>$kid))->find();
        if($info){
            if($info['status']==2){
                $data['info'] = '这期已结束';
            }else{
                M('kailog')->where(array('id'=>$kid))->save(array('kongid'=>$id));
                $data['status'] = '1';
                $data['id'] = $id;


            }
        }else{
            $data['info'] = '没有这期';
        }
        echo json_encode($data);
    }
    public function goumai(){
        $Data = M('buylog'); // 实例化Data数据对象
        import("@.ORG.Util.Page");// 导入分页类
        $map = array();
        if (isset($_POST['id']) && $_POST['id']!='') {
            $map['uid'] = array("eq",$_POST['id']);
        }
        if (isset($_POST['starttime']) && $_POST['starttime']!='') {
            $map['starttime'] = array("egt",strtotime($_POST['starttime']));
        }
        if (isset($_POST['endtime']) && $_POST['endtime']!='') {
            $map['starttime'] = array("elt",strtotime($_POST['endtime']));
        }

        $count      = $Data->where($map)->count();// 查询满足要求的总记录数
        $Page       = new Page($count,50);// 实例化分页类 传入总记录数


        $list = $Data->where($map)->order('starttime desc')->limit($Page ->firstRow.','.$Page -> listRows)->select();
        foreach($list as $k=>$v){

            $list[$k]['username'] = M('member')->where("id ={$v['uid']}")->getField('username');

        }
		$zgoumai = $Data ->sum('money');
		$zyingmoney = $Data ->sum('yingmoney');
		$yixiaochu=$zgoumai - $zyingmoney;
        $show       = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('zgoumai',$zgoumai);
        $this->assign('zyingmoney',$zyingmoney);
        $this->assign('yixiaochu',$yixiaochu);
        $this->assign('list',$list);// 赋值数据集
        $this->display(); // 输出模板

    }


}