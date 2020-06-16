#关于修改过的TP5内核
  1、为了能够在后台识别插件的模板，更改了TP5中的一个文件thinkphp/library/think/view/driver/think.php
  2、为了能支持旧版的上传方法。在thinkphp/library/think 增加image扩展
  
  
3.0数据库修改记录
1、user表
grades字段默认设置为1；

2、usergrade表 新增字段
ALTER TABLE `ls_usergrade` ADD COLUMN `type` TINYINT(1) DEFAULT 1 NULL COMMENT '1 积分用户组 2自定义组' AFTER `id`; 


3、后台增加友情链接管理

    
2.52新增关键字
ls_artcomment  jubao/status
ls_comment  status
  
##0d
2019年6月8日
    新增水印,在system表中添加name：watermark的配置信息
   ```
a:9:{s:6:"switch";s:1:"1";s:9:"mark_type";s:1:"1";s:4:"font";s:2:"25";s:9:"font_path";s:11:"simfang.ttf";s:4:"code";s:7:"#66ccff";s:8:"position";s:1:"9";s:4:"text";s:6:"LaySNS";s:3:"img";s:23:"/public/images/logo.png";s:5:"token";s:1:"0";}
```
```
echo serialize([
    'switch'=> 1, #水印开关
    'mark_type'=>1, #水印类型,1文字2图片
    'font' => 25,#字体大小
    'font_path'=>'simfang.ttf', #字体文件(可以忽略,程序已有自带字体)
    'code'=>'#66ccff', #字体颜色
    'position'=>9,#字体位置
    'text'=>'测试水印', #字体内容
    'img'=>'/uploads/2019/06/08/logo.png' #图片水印文件,（已带有ROOT_PATH）
]);
```      
  
  
  
