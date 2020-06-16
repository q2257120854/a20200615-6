<?php
namespace app\common\model;

class Watermark{
    private $config = [];
    private $mark_type;
    private $font;
    private $font_path;
    private $code;
    private $error = '';
    private $position = 9;

    function __construct($config){
        /**
         *
         *position->1：顶部居左 2：顶部居中 3：顶部居右 4：左边居中
         *          5：图片中心 6：右边居中 7：底部居左 8：底部居中 9：底部居右
         *
         */
        $default = [
            'mark_type'=> 1,//1文字/2图片
            'font' => 15, //字体大小
            'font_path' => '/extend/Captcha/assets/zhttfs/1.ttf', //文字水印字体文件
            'code' => '#66ccff', //默认颜色代码
            'position'=> 9//水印位置
        ];
        $conf = array_merge($default,$config);

        $this->mark_type = $conf['mark_type'];
        $this->font = $conf['font'];
        $this->font_path = $conf['font_path'];
        $this->code = $conf['code'];
        $this->position = $conf['position'];
    }

    /**
     * 添加水印
     * @param $img
     * @param string $mark
     * @return bool
     */
    public function add($img, $mark = 'logo.png'){
        if(!file_exists($img) || empty($img)){
            $this->error = '文件不存在';
            return false;
        }
        $src_info = getimagesize($img);
        if(!$src_info){
            $this->error = '获取图片信息错误';
            return false;
        }
        //文件扩展名
        $extension = image_type_to_extension($src_info[2],false);

        //创建源文件图形资源
        switch ($src_info[2]){
            case 1:{//GIF会变一帧,此方法无效
                return true;
                $resource = imagecreatefromgif($img);
                break;
            }
            case 2:{
                $resource = imagecreatefromjpeg($img);
                break;
            }
            case 3:{
                $resource = imagecreatefrompng($img);
                break;
            }
            default:{
                $this->error = '不支持这种格式的图形文件';
                return false;
            }
        }
        if(!$resource){
            $this->error = '创建图象失败';
            return false;
        }

        //设置水印
        if($this->mark_type == 1){ //文字水印
            //计算区域大小
            $box = @imagettfbbox($this->font,0, $this->font_path, $mark);
            $area_w = max($box[2], $box[4]) - min($box[0], $box[6]);
            $area_h = max($box[1], $box[3]) - min($box[5], $box[7]);
        }elseif($this->mark_type == 2){//图片水印
            if(!file_exists($mark) || empty($mark)){
                $this->error = '水印文件不存在';
                return false;
            }
            //获取水印图片信息
            $mark_info = getimagesize($mark);
            if($mark_info[2] !== 3){
                $this->error = '仅支持PNG格式的水印文件';
                return false;
            }
            //对比原图是否小于水印图
            if($src_info[0] < $mark_info[0] || $src_info[1] < $mark_info[1]){
                $this->error = '原图小于水印图';
                return false;
            }
            $resource_mark =imagecreatefrompng($mark);
            if(!$resource_mark){
                $this->error = '创建水印图象失败';
                return false;
            }
            //水印区域大小
            $area_w = $mark_info[0];
            $area_h = $mark_info[1];

        }else{
            $this->error = '水印类型错误';
            return false;
        }
        //水印位置
        switch($this->position) {
            case 1:
                $x = +5;
                $y = +5;
                break;
            case 2:
                $x = ($src_info[0] - $area_w) / 2;
                $y = +5;
                break;
            case 3:
                $x = $src_info[0] - $area_w - 5;
                $y = +15;
                break;
            case 4:
                $x = +5;
                $y = ($src_info[1] - $area_h) / 2;
                break;
            case 5:
                $x = ($src_info[0] - $area_w) / 2;
                $y = ($src_info[1] - $area_h) / 2;
                break;
            case 6:
                $x = $src_info[0] - $area_w - 5;
                $y = ($src_info[1] - $area_h) / 2;
                break;
            case 7:
                $x = +5;
                $y = $src_info[1] - $area_h - 5;
                break;
            case 8:
                $x = ($src_info[0] - $area_w) / 2;
                $y = $src_info[1] - $area_h - 5;
                break;
            case 9:
                $x = $src_info[0] - $area_w - 5;
                $y = $src_info[1] - $area_h -5;
                break;
            default:
                $this->error = '水印位置不受支持';
                return false;
        }

        //创建画布
        $dst_img = imagecreatetruecolor($src_info[0], $src_info[1]);
        if(!$dst_img){
            $this->error = '画布创建失败';
        }
        imagecopy ( $dst_img, $resource, 0, 0, 0, 0, $src_info[0], $src_info[1]);
        //渲染文字水印
        if($this->mark_type == 1){
            $rgb = $this->hex2rgb($this->code);
            $color = imagecolorallocate($dst_img, $rgb['r'], $rgb['g'], $rgb['b']);
            imagettftext($dst_img, $this->font, 0, $x, $y, $color, $this->font_path, $mark);
        }
        if($this->mark_type == 2){
            imagecopy($dst_img, $resource_mark, $x, $y, 0, 0, $area_w, $area_w);
            imagedestroy($resource_mark);
        }
        //输出文件
        switch ($src_info[2]){
//            case 1:
//                imagegif($dst_img, $img);
//                break;
            case 2:
                imagejpeg($dst_img, $img);
                break;
            case 3:
                imagepng($dst_img, $img);
                break;
        }
        imagedestroy($dst_img);
        imagedestroy($resource);
        return true;
    }
    public function getError(){
        return $this->error;
    }
    private function hex2rgb($code){
        if($code[0] == '#'){
            $code = substr($code, 1);
        }
        if(strlen($code) == 6){
            list($r, $g, $b) = [
                hexdec($code[0].$code[1]),
                hexdec($code[2].$code[3]),
                hexdec($code[4].$code[5])
            ];
            return ['r' => $r, 'g' => $g, 'b' => $b];
        }
        return ['r' => 0, 'g' => 0, 'b' => 0];
    }

}