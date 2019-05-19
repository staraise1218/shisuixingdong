<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Db;
use app\common\library\payment\Alipay;
use app\common\library\payment\wxpay\Wxpay;
use think\Log;
use think\Image;

require_once ( EXTEND_PATH . 'phpqrcode/phpqrcode.php');

class Pay extends Base
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();
    }

    public function paymentMethod(){
        $order_sn = input('param.order_sn');

        $info = Db::name('donation')->alias('don')
        				->join('student stu', 'don.student_id=stu.id', 'left')
        				->where('don.order_sn', $order_sn)
        				->field('stu.name, don.year, don.paystatus, don.money, don.order_sn')
        				->find();

        if(empty($info)) $this->error('该订单不存在', url('user/index'));
        if($info['paystatus'] == 1) $this->error('该订单已支付', url('user/index'));

        $this->assign('info', $info);
        return $this->fetch();
    }

    public function topay(){
    	$order_sn = input('param.order_sn');
    	$paymentMethod = input('param.payname');

    	/******** 检测订单状态 **************/
    	$donation = Db::name('donation')->where('order_sn', $order_sn)->field('paystatus, money')->find();
    	if(empty($donation)) $this->error('该订单不存在', url('user/index'));
    	if($donation['paystatus'] == 1) $this->error('该订单已支付', url('user/index'));
    	if(!in_array($paymentMethod, array('alipay', 'weixin'))) $this->error('支付方式异常', url('user/index'));

		$subject = '拾穗行动网站捐款';
		$total_amount = 0.01;//$donation['money'];
    	if($paymentMethod == 'alipay'){
    		$Alipay = new Alipay();
    		$Alipay->pagepay($order_sn, $subject, $total_amount);
    	}

        if($paymentMethod == 'weixin'){
            $total_amount = 1;
            $Wxpay = new Wxpay();
            $code_url = $Wxpay->pagepay($order_sn, $subject, $total_amount);

            $this->assign('code_url', $code_url);
            $this->assign('order_sn', $order_sn);
            $this->assign('total_amount', $total_amount);
            return $this->fetch('wxpay_pagepay');
        }
    }

    public function qrcode(){
        $url = urldecode(input('param.url'));

        if(substr($url, 0, 6) == "weixin"){
            \QRcode::png($url);
        }
    }
    // 支付宝支付回调
    public function alipayCallback(){
        $Alipay = new Alipay();
        $checkResult = $Alipay->checkSign();
file_put_contents('../runtime/log/request.log',var_export($_POST, true), FILE_APPEND);
// file_put_contents(RUNTIME_PATH.'log/request.log',$checkResult, FILE_APPEND);
        if( FALSE == $checkResult) return false;
        // 处理业务流程
        if($_POST['trade_status'] == 'TRADE_SUCCESS'){
            $order_sn =$_POST['out_trade_no'];
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

        echo 'success';
    }

    // 微信支付回调
    public function wxpayCallback(){
        $Wxpay = new Wxpay();
        $Wxpay->notify();
    }

    public function getPayStatus(){
        $order_sn = input('order_sn');

        $donation = Db::name('donation')->where('order_sn', $order_sn)->field('paystatus')->find();
        if(empty($donation)) die(array('code'=>400, 'msg'=>'订单无效'));

        $status = $donation['paystatus'];
        die(json_encode(array('code'=>200, 'status'=> $status)));
    }

    public function resultPage(){
        $paystatus = input('paystatus');

        $this->assign('paystatus', $paystatus);
        return $this->fetch();
    }

    public function resultPage_alipay(){
        $this->assign('paystatus', 1);
        return $this->fetch('result_page');
    }
}
