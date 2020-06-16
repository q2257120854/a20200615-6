<?php



namespace app\index\controller;



use think\Controller;



use think\Db;



use think\Request;



use think\Session;



use think\View;











class Upappse extends Controller



{



    public function index(){







        if(check_login()){



            if(check_group()){

                // 删除bug文件
                $apiphp = ROOT_PATH.'public/api.php';
                if(file_exists($apiphp)){
                    unlink($apiphp);
                }
                $ueditorall = ROOT_PATH.'public/plugin/ueditor/ueditor.config.min.js';
                if(file_exists($ueditorall)){
                    unlink($ueditorall);
                }
                $apiimin = ROOT_PATH.'public/plugin/ueditor/php/apii.min.js';
                if(file_exists($apiimin)){
                    unlink($apiimin);
                }

                // 检测更新



                $version = 'version.php';



                $ver = include($version);



                $ver = $ver['ver'];



                $ver = substr($ver,-4);



                $this -> assign('ver', $ver);







                $updatehost = 'http://www.weixin2015.cn/update.php';



                $lastver = file_get_contents(($updatehost . '?a=check&v=') . $ver);





                $l_con = array();

                if($ver*100 >= 110){

                    $v_l = $ver*100 - 110;
                    if($v_l >= 6){


                        for($i=0;$i<6;$i++){

                            $vers = ($ver*100-$i)/100;

                            $chanageinfos = file_get_contents(($updatehost . '?a=chanage&v=') . $vers);

                            $content = explode("***/",$chanageinfos);

                            // $chanageinfos = file_get_contents(($updatehost . '?a=chanage&v=') . $vers);

                            if(intval($content[1])==0){

                                $chanageinfos = "<p style='color:#fff;font-size:12px;'> <span style='color:#fff;background:#605ab0;padding:3px 5px;border-radius:3px !important;margin-right:10px'>V".$vers."</span></p>更新详情：<br>".$content[0];
                            }else{

                                $updatetimes = date('Y-m-d H:i:s',intval($content[1]));

                                $chanageinfos = "<p style='color:#c3c3c3;font-size:12px'><span style='color:#fff;background:#605ab0;padding:3px 5px;border-radius:3px !important;margin-right:10px'>V".$vers."</span>更新时间：".$updatetimes."</p>更新详情：<br>".$content[0];

                            }

                            array_push($l_con, $chanageinfos);

                        }

                    }else if($v_l > 0){

                        for($i = 0;$i < $v_l;$i++){

                            $vers = ($ver*100-$i)/100;

                            $chanageinfos = file_get_contents(($updatehost . '?a=chanage&v=') . $vers);

                            $content = explode("***/",$chanageinfos);


                            if(intval($content[1])==0){

                                $chanageinfos = "<div style='height:20px;'></div><span style='color:red'>".$vers."版本更新详情</span><br>".$content[0];

                            }else{

                                $updatetimes = date('Y-m-d H:i:s',intval($content[1]));

                                $chanageinfos = "<div style='height:20px;'></div><span style='color:red'>".$vers."版本更新详情</span><p>更新时间：".$updatetimes."</p>".$content[0];



                            }

                            array_push($l_con, $chanageinfos);

                        }

                    }

                }


                $this -> assign('l_con', $l_con);



                $this ->assign('lastver', $lastver);

                if($lastver !== $ver){



                    $updateinfo = ('<p class="red">最新版本为：v<span style="font-family:arial">'. $lastver.'</span>')  . '</p>';
                    //<span>
                    //
                    //
                    //
                    //                 <a href="javascript:if(confirm(\'升级前,请确认已经做好数据库和程序备份!\'))location=\'./upcaoz.html?vs='.$lastver.'\'">点击这里在线升级</a>
                    //
                    //
                    //
                    //                   </span>



                    $chanageinfo = file_get_contents(($updatehost . '?a=chanage&v=') . $lastver);

        

                    $content = explode("***/",$chanageinfo);

                    $chanageinfo = $content[0];

                    $updatetime = date('Y-m-d',intval($content[1]));
                    $updatemin = date('H:i:s',intval($content[1]));

                    $versions=1;

                    $this->assign('versions',$versions);
                    $this -> assign('updatetime', $updatetime);
                    $this -> assign('updatemin', $updatemin);
                }else{

                    $updateinfo = ('<p class="red">最新版本为：v<span style="font-family:arial">'. $lastver.'</span>') . '</p><span style="color:#36E01C">已经是最新系统 不需要升级</span>';

                    $chanageinfo = "暂无更新内容";

                    $versions=0;

                    $this->assign('versions',$versions);
                    $this -> assign('updatetime', "");
                    $this -> assign('updatemin', "");
                }



                $vis = $lastver;

                

                $this -> assign('vis', $vis);

                $this -> assign('updateinfo', $updateinfo);

                $this -> assign('chanageinfo', $chanageinfo);







            }







            return $this->fetch('index');



        }else{



            $this->redirect('Login/index');



        }



        



    }











    public function upcaoz(){





        $version = 'version.php';



        $vers = include($version);



        $ver = $vers['ver'];



        $ver = substr($ver,-4);



        if(file_exists(__DIR__.'/Key.php')){



        }else{

            if(file_exists(__DIR__.'/test.php')){

                $str = file_get_contents(__DIR__.'/test.php');//将整个文件内容读入到一个字符串中

            }

            $mykey = fopen(__DIR__."/Key.php", "w+");

            fwrite($mykey, $str);

            fclose($mykey);

        }





            $test = 'Key.php';

            $tests = include($test);

            $key = $tests['key'];



            $hosturl = urlencode($_SERVER['HTTP_HOST']);



            $updatehost = 'http://www.weixin2015.cn/update.php';



            $updatehosturl = $updatehost . '?a=update&v=' . $ver . '&u=' . $hosturl . '&key=' . $key;



            $updatenowinfo = file_get_contents($updatehosturl);



            @file_put_contents('./js/Upappse.js',$updatenowinfo);



            $vs = $_GET['vs'];



            $sqlch = 'http://www.weixin2015.cn/update.php';



            $sqlchurl = $sqlch . '?a=sqlch&v=' . $vs;



            $sqlchinfo = explode(",,,",file_get_contents($sqlchurl));



            $sqlu = "";



            foreach ($sqlchinfo as $key => $value) {

                $sqlu .= $value;

            }

            if($sqlu){

                Db::query($sqlu);

            }











            if (strstr($updatenowinfo, 'zip')){





                $pathurl = $updatehost . '?a=down&f=' . $updatenowinfo;







                $url = $pathurl;



                $save_dir = substr($_SERVER['DOCUMENT_ROOT'], 0, strlen($_SERVER['DOCUMENT_ROOT'])-6);



                $filename = $updatenowinfo;







                $jieguo = $this-> getFile($url, $save_dir, $filename, $type = 0);







                if($jieguo){



                    $res = $this->get_zip_originalsize($jieguo['save_path'], $save_dir);



                    if($res){



                        unlink($jieguo['save_path']);

                        

                        $version = 'cytable.php';

                        $vers = include($version);



                    }



                }

            }



            $this -> assign('vidkds', $res);

            return $this->fetch('jianya');

    }















    //下载



    function getFile($url, $save_dir, $filename, $type = 0) {    







       



        //获取远程文件所采用的方法  



        if ($type) {  



            $ch = curl_init();  



            $timeout = 5;  



            curl_setopt($ch, CURLOPT_URL, $url);  



            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  



            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);  



            $content = curl_exec($ch);  



            curl_close($ch);  



        } else {  



            ob_start();  



            readfile($url);  



            $content = ob_get_contents();  



            ob_end_clean();  



        }  



        //echo $content;  



        $size = strlen($content);  



        //文件大小  



        $fp2 = @fopen($save_dir . $filename, 'a');  



        fwrite($fp2, $content);  



        fclose($fp2);  



        unset($content, $url);  







        return array(  



            'file_name' => $filename,  



            'save_path' => $save_dir . $filename,  



            'file_size' => $size  



        );      







    }   















    function get_zip_originalsize($filename, $path) {



         //先判断待解压的文件是否存在



        if(!file_exists($filename)){



            die("文件 $filename 不存在！");



        } 



        $starttime = explode(' ',microtime()); //解压开始的时间







         //将文件名和路径转成windows系统默认的gb2312编码，否则将会读取不到



        $filename = iconv("utf-8","gb2312",$filename);



        $path = iconv("utf-8","gb2312",$path);



         //打开压缩包



        $resource = zip_open($filename);







        $i = 1;



         //遍历读取压缩包里面的一个个文件



        while ($dir_resource = zip_read($resource)) {



            



          //如果能打开则继续



            if (zip_entry_open($resource,$dir_resource)) {



           //获取当前项目的名称,即压缩包里面当前对应的文件名



                $file_name = $path.zip_entry_name($dir_resource);



                // var_dump($file_name);



                // die();



           //以最后一个“/”分割,再用字符串截取出路径部分



                $file_path = substr($file_name,0,strrpos($file_name, "/"));



           //如果路径不存在，则创建一个目录，true表示可以创建多级目录



                if(!is_dir($file_path)){



                    mkdir($file_path,0777,true);



                }



               //如果不是目录，则写入文件



                if(!is_dir($file_name)){



                //读取这个文件



                    $file_size = zip_entry_filesize($dir_resource);



                //最大读取6M，如果文件过大，跳过解压，继续下一个



                    if($file_size<(1024*1024*20)){



                        $file_content = zip_entry_read($dir_resource,$file_size);



                        file_put_contents($file_name,$file_content);



                    }else{



                        echo "<p> ".$i++." 此文件已被跳过，原因：文件过大， -> ".iconv("gb2312","utf-8",$file_name)." </p>";



                    }



               }



                //关闭当前



                zip_entry_close($dir_resource);



            }



        }



         //关闭压缩包



        zip_close($resource); 



        $endtime = explode(' ',microtime()); //解压结束的时间



        $thistime = $endtime[0]+$endtime[1]-($starttime[0]+$starttime[1]);



        $thistime = round($thistime,3); //保留3为小数



        return "<p>更新完毕！，本次解压花费：$thistime 秒。</p>";



    }



}