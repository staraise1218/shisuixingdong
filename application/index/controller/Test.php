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
            $order_sn ='201808241424228183';
            $updatedata = array(
                'paystatus' => 1,
                'paytime' => time(),
                'payment_method' => '1',
                'expirytime' => strtotime('+1 year'),
            );
            // 更新订单表
            Db::name('donation')->where('order_sn', $order_sn)->update($updatedata);
            // 更新学生捐助状态,及捐助人，捐助订单id
            $donation = Db::name('donation')->where('order_sn', $order_sn)->find();

            $updateStudentData = array(
                'donation_status' => 2,
                'donor' => $donation['user_id'],
                'donation_id' => $donation['id'],
            );
            Db::name('student')->where('id', $donation['student_id'])->update($updateStudentData);
            // 添加善款追踪记录
            Db::name('track')->insert(array(
                'student_id'=>$donation['student_id'],
                'title' => '捐款提醒',
                'content' => '捐款成功，扣除260作为项目执行经费',
                'money' => 260,
                'donor' => $donation['user_id'],
                'donation_id' => $donation['id'],
                'createtime' => time(),
            ));

            // 生成证书
            $filepath = 'certificate/'.str_pad($donation['user_id'], 6, '0', STR_PAD_LEFT).'/';
            if( ! is_dir($filepath)){
                mkdir($filepath, 0777, true);
            }
            $filename = $filepath.md5(time()).'.jpg';
            $Image = Image::open('static/images/certificate_template.jpg');
            // 给原图左上角添加水印并保存water_image.png
            $Image->text($donation['fullname'], 'static/font/YaHei.ttf', 96, '#000000', Image::WATER_CENTER, array(0, -390))
            ->text(date('Y'), 'static/font/YaHei.ttf', 24, '#000000', Image::WATER_CENTER, array(-160, 925))
            ->text(date('m'), 'static/font/YaHei.ttf', 24, '#000000', Image::WATER_CENTER, array(-35, 925))
            ->text(date('d'), 'static/font/YaHei.ttf', 24, '#000000', Image::WATER_CENTER, array(70, 925))
                ->save($filename);
            Db::name('certificate')->insert(array(
                'user_id' => $donation['user_id'],
                'image' => '/'.$filename,
                'createtime' => time(),
            ));
    }

}
