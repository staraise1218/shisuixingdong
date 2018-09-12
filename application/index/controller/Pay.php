<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Db;
use app\common\library\payment\Alipay;
use app\common\library\payment\wxpay\Wxpay;
use app\common\library\phpqrcode;

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
		$total_amount = $donation['money'];
    	if($paymentMethod == 'alipay'){
    		$Alipay = new Alipay();
    		$Alipay->pagepay($order_sn, $subject, $total_amount);
    	}

        if($paymentMethod == 'weixin'){
            $Wxpay = new Wxpay();
            $code_url = $Wxpay->pagepay($order_sn, $subject, $total_amount);

            $this->assign('code_url', $code_url);
            return $this->fetch('wxpay_pagepay');
        }
    }

    public function qrcode(){
        $url = urldecode(input('param.url'));


        if(substr($url, 0, 6) == "weixin"){
            phpqrcode::png($url);
        }
    }

    public function alipay(){

    }


    public function returnUrl(){
    	echo 'returnrul';
    }
    public function notifyUrl(){
    	echo 'notifyUrl';
    }



}
