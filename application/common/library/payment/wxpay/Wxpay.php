<?php

namespace app\common\library\payment\wxpay;

require_once ( EXTEND_PATH . 'wxpay/WxPay.Api.php');


class Wxpay {
	public function pagepay($order_sn, $subject, $total_amount){
		//模式二
		/**
		 * 流程：
		 * 1、调用统一下单，取得code_url，生成二维码
		 * 2、用户扫描二维码，进行支付
		 * 3、支付完成之后，微信服务器会通知支付成功
		 * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
		 */
		$input = new \WxPayUnifiedOrder();
		$input->SetBody($subject);
		$input->SetAttach("test");
		$input->SetOut_trade_no($order_sn.date("YmdHis"));
		$input->SetTotal_fee("1");
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag("test");
		$input->SetNotify_url("http://paysdk.weixin.qq.com/notify.php");
		$input->SetTrade_type("NATIVE");
		$input->SetProduct_id("123456789");

		$result = $this->GetPayUrl($input);
		$url2 = $result["code_url"];
		echo $url2;
	}

	/**
	 * 
	 * 生成直接支付url，支付url有效期为2小时,模式二
	 * @param UnifiedOrderInput $input
	 */
	private function GetPayUrl($input)
	{
		if($input->GetTrade_type() == "NATIVE")
		{
			$config = new WxPayConfig();
			$result = \WxPayApi::unifiedOrder($config, $input);
			return $result;
		}
		return false;
	}
}