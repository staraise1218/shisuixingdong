<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Db;
use think\Image;

class Test extends Base
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function _initialize()
    {
        parent::_initialize();
    }

    public function index(){
        $user_id = 1;
        $filepath = 'certificate/'.str_pad($user_id, 6, '0', STR_PAD_LEFT).'/';
        if( ! is_dir($filepath)){
            mkdir($filepath, 0777, true);
        }
        $filename = $filepath.md5(time()).'.jpg';
        $Image = Image::open('static/images/certificate_template.jpg');
        // 给原图左上角添加水印并保存water_image.png
        $Image->text('王胜利', 'static/font/YaHei.ttf', 96, '#000000', Image::WATER_CENTER, array(0, -390))
        ->text('2019', 'static/font/YaHei.ttf', 24, '#000000', Image::WATER_CENTER, array(-160, 925))
        ->text('05', 'static/font/YaHei.ttf', 24, '#000000', Image::WATER_CENTER, array(-35, 925))
        ->text('20', 'static/font/YaHei.ttf', 24, '#000000', Image::WATER_CENTER, array(70, 925))
            ->save($filename);
    }

}
