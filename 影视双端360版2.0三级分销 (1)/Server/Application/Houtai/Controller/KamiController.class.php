<?php
namespace Houtai\Controller;
use Think\Controller;
class KamiController extends YnController {
    public function index(){
$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);		
		$kami = M('kami');
	    $page = new \Think\Page($kami->count(),15);
	    $this->assign("kami",$kami->where("y=0")->order("ctime DESC")->limit($page->firstRow,$page->listRows)->select());
		$this->assign("pageinfo",$page->show());
		

        $this->display("index");
    }
	public function jilu(){
		$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
		$kami = M('kami');
	    $page = new \Think\Page($kami->count(),15);
	    $this->assign("kami",$kami->where("y=1")->order("ctime DESC")->limit($page->firstRow,$page->listRows)->select());
		$this->assign("pageinfo",$page->show());
        $this->display("jilu");
		
	}
	
	public function txt(){
		$kami = M('kami')->where("y=0")->order("id ASC")->select();
		 Header( "Content-type:   application/octet-stream ");
        Header( "Accept-Ranges:   bytes ");
        header( "Content-Disposition:   attachment;   filename=".date('Y-m-d H:i:s').".txt ");
        header( "Expires:   0 ");
        header( "Cache-Control:   must-revalidate,   post-check=0,   pre-check=0 ");
        header( "Pragma:   public ");
		
		 foreach ($kami as $value)
        { 
			
            echo $value['name'];
            echo '----';
            echo $value['dianka'];
            echo "\r\n";
        }
       
	}
	
	public function daotxt(){
		$type = $_POST['type'];
		
		$kami = M('kami')->where("y=0 and name='{$type}'")->order("id ASC")->select();
		 Header( "Content-type:   application/octet-stream ");
        Header( "Accept-Ranges:   bytes ");
        header( "Content-Disposition:   attachment;   filename=".date('Y-m-d H:i:s').".txt ");
        header( "Expires:   0 ");
        header( "Cache-Control:   must-revalidate,   post-check=0,   pre-check=0 ");
        header( "Pragma:   public ");
		
		 foreach ($kami as $value)
        { 
			
            echo $value['name'];
            echo '----';
            echo $value['dianka'];
            echo "\r\n";
        }
       
	}
	
	
	

	
	
	
	
	
	public function del1(){
		
		$id = $_GET['id'];
		
	
		
		$mod = M("kami")->delete($id);
      
		if($mod>0){
           die("y");
        }else{
            die("n");
        }
		
		
	}
	
	public function kami1(){
		$type=$_POST['type'];
		$fen=$_POST['fen'];
		 
                    $time  =   $type*60*60*24;
                    $name   =  $type.'天';
                  
			$dian   =   '';
				for ($i=0;$i<$fen;$i++){
				 $str='ABCDEFGHIJKLMNOPQRSTUVWXYZ';  
				 $randStr = str_shuffle($str);
				 $rands= md5(time().$randStr);
				 $ka = substr($rands,0,8);
                    $insert['uid']      =   1;
                    $insert['dianka']   =   $ka;
                    $insert['ctime']    =   time();
                    $insert['time']     =   $time;
                    $insert['type']     =   $type;
                    $insert['name']     =   $name;
					M('kami')->data($insert)->add();
					$dian.=   $ka."<br><hr>";
				  }
		echo json_encode(['code'=>1,'dian'=>$dian], JSON_UNESCAPED_UNICODE);
		
	}
	
	
	
	
	public function kami(){
		$type=$_POST['type'];
		$fen=$_POST['fen'];
		 switch ($type)
            {
                case 0.75;
                    $time  =   7*60*60*24;
                    $name   =   '七天';
                    break;
                case 1.5;
                    $time  =   30*60*60*24;
                    $name   =   '一个月';
                    break;
                case 4.5;
                    $time  =   90*60*60*24;
                    $name   =   '三个月';
                    break;
                case 9;
                    $time  =   180*60*60*24;
                    $name   =   '六个月';
                    break;
               case 18;
                    $time  =   365*60*60*24;
                    $name   =   '一年';
                    break;
                case 150;
                  
                    $time  =   9999*60*60*24;
                    $name   =   '永久';
                    break;
            }
			$dian   =   '';
				for ($i=0;$i<$fen;$i++){
				 $str='ABCDEFGHIJKLMNOPQRSTUVWXYZ';  
				 $randStr = str_shuffle($str);
				 $rands= md5(time().$randStr);
				 $ka = substr($rands,0,8);
                    $insert['uid']      =   1;
                    $insert['dianka']   =   $ka;
                    $insert['ctime']    =   time();
                    $insert['time']     =   $time;
                    $insert['type']     =   $type;
                    $insert['name']     =   $name;
					M('kami')->data($insert)->add();
					$dian.=   $ka."<br><hr>";
				  }
		echo json_encode(['code'=>1,'dian'=>$dian], JSON_UNESCAPED_UNICODE);
		
	}
	
	 public function xtxt()
    {
        $data   =   $_GET['content'];
        Header( "Content-type:   application/octet-stream ");
        Header( "Accept-Ranges:   bytes ");
        header( "Content-Disposition:   attachment;   filename=".date('Y-m-d H:i:s').".txt ");
        header( "Expires:   0 ");
        header( "Cache-Control:   must-revalidate,   post-check=0,   pre-check=0 ");
        header( "Pragma:   public ");
        echo str_replace('<br><hr>',"\r\n",$data);
    }

	public function xexcel()
    {
        $data   =    $_GET['content'];
        header( "Content-Type: application/vnd.ms-excel; name='excel'" );
        header( "Content-type: application/octet-stream" );
        header( "Content-Disposition: attachment; filename=".date('Y-m-d H:i:s').".xls" );
        header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
        header( "Pragma: no-cache" );
        header( "Expires: 0" );
        echo str_replace('<br><hr>',"\r\n",$data);
    }
	
	
	public function excel()
    {
       $kami = M('kami')->where("y=0")->order("id ASC")->select();
        header( "Content-Type: application/vnd.ms-excel; name='excel'" );
        header( "Content-type: application/octet-stream" );
        header( "Content-Disposition: attachment; filename=".date('Y-m-d H:i:s').".xls" );
        header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
        header( "Pragma: no-cache" );
        header( "Expires: 0" );
        // $list   =   db('dianka')->where($where)->paginate(20);
        echo "<table>";

        foreach ($kami as $value)
        {
            echo "<tr>";
            echo "<td>";
            echo $value['dianka'];
            echo "</td>";
            echo "<td>";
            echo $value['name'];
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }	
	
}