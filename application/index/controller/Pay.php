<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Db;
use app\common\library\payment\Alipay;
use app\common\library\payment\wxpay\Wxpay;
use think\Log;

require_once ( EXTEND_PATH . 'phpqrcode/phpqrcode.php');

class Pay extends Frontend
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

		$subject = '捐款';
		$total_amount = 0.01;//$donation['money'];
    	if($paymentMethod == 'alipay'){
    		$Alipay = new Alipay();
    		$Alipay->pagepay($order_sn, $subject, $total_amount);
    	}

        if($paymentMethod == 'weixin'){
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
        // if( FALSE == $Alipay->checkSign()) return false;

        // 处理业务流程
        if($_POST['trade_status'] == 'SUCCESS'){
            $order_sn = input('param.out_trade_no');
            $order_sn = substr($order_sn, 0, 18);
            $updatedata = array(
                'paystatus' => 1,
                'paytime' => time(),
                'expirytime' => strtotime('+1 year'),
            );
            Db::name('donation')->where('order_sn', $order_sn)->update($updatedata);
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
        return $this->fetch();
    }
}
