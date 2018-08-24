<?php

namespace app\common\library\payment;

require_once ( EXTEND_PATH . 'alipay/AopSdk.php');

class Alipay {
	// 支付宝支付网关
	private $gatewayUrl = 'https://openapi.alipay.com/gateway.do';
	// 支付宝分配给开发者的应用ID
	private $appId = '2018081461022343';
	private $rsaPrivateKey = 'MIIEpAIBAAKCAQEAntYOKNypKZH8deQ8mSpNFSarTmJjT/XhVFEV3mSVsaQUmGYS02QiOcJr49awF49WrjPKnrSUr+nItb33fNCeiymfF8+sLuE6tCHmibLlIuX/srXELVWoAFp9gK25k6dlSVkpdyULah9od/Ya6PzPghswmCAQmrwuvUmdZ0YpSVPpTbTtFWaoSgb4WRF+PAq6jz0bI2kPCgauJ81OlW0SFs9Ec0dq1E1RDyf8Bkn2x9ZHFC8L3CRqu3lH6AHq1PG9n4MhHvE0H+U6cT9AZHN3Fu/LPRtZ4JtJAfF2mgWUUz83nrZNSn55LBEAeTQXDf2I+A5auumoWwEVoHGBdUtRFQIDAQABAoIBAQCVotlSG5fuRs8NjYidTyGxVG28eapQETdHxOASVLZF1Wtlq3v+1G399jDIQ2A/wdUKZlZzr3IIS/m/Zgj6+Fr0hbCQsR/oRl2Uh/91KCj/+Kgsh1sazoBoXNexW3jiJqigMjSDP04CmzZDFYKCjnE7hDwChOq/q5tozipQueN5ZOyg14bD7CyUefSnRBwAs0Yz3dd6TcmuEPgQjQSjcsuQc6Qv5iaaLqHjzOmW/Ty6D5JGoaoF5RkVd0rU+HYfgkxH3v3Y6slW0kyvDWVICnA1Z4BKvMP/fwd8lBUl8BROFSY77t1nJtSGO6qU/yjltEUOaF0iemrQRdDCXnIVM1QhAoGBANNU2ElStMTECAn2JnT+Eg95sVCUucdXNTPJqlBFoptv1A3x9dkxaV12IG7XdhAnvPpiIqC2+by9Yw+VXnsPW/Rw60BP36JbYK2j4Ph+nDMN0aWqOoYfz9lfOKHJ2YKTfk8aabD6MYdmxL3p1zTQ7+LuqdTPQsjkCrbOrEUEbGxdAoGBAMBosDm/tKK+A9X2pTbsWWhCzaaGYwD6mfUxZ841OTAJ8hNqna5xmxy9gGuTvx3Lp7AoSlIk/fg47AeV4fz0jJHD6i4nwrm2CkrtejFV8E8HO3zVL7zNTMo4/vSfuJemlENfEIluXWPj+MlQUY98c0sUWHi5K/6YyBWisSDpG+wZAoGANhR5QNJEZjIQKJRwJPI7pvAqWwekPwnnGHib9+zJ/uLwLh1kH4+QehVXmWXT1bCFoMFqQRxx7kW8yukbg3xbuMMIwK1v+jlOFUFhudWUnVAE/VMBpP8RDnxanrRr0Al0gkOtFlgAQrke0ca8hsyNBtKybT4YxhXtU/ixhvvpzxUCgYEAmz/dcbtNdUL8tVgeVwK94XKFnSgyGkgakc0bhTdMvYZI3YHZWTgxgC8nv6WnP9Njqq/XyBAxHGhRio1Vm1V3VuZNvpA2fsJz66FSRxygmiOrzD34Fs9QdpsmnRuDRloSp4m9PibfFAqOY2F7bdts69euyzoeVX/RciOj6HovHYECgYAbFe8OxNDaPww8Xag6vpkd7t5n6sDgega6C0fnotorV3iE7N6YYq+caQn/w5+E8P9Eji3qRQwoX7bpktSxpXttL0jieopFPabtOqvFov+cN5Y8/GS1e7VOVxyCho5cmm8V0FmkgpClmnrcrmHFyZb1fRi0dgEYZG3ytyF15enK+g==';
	private $apiVersion = '1.0';
	private $signType = 'RSA';
	private $postCharset = 'utf-8';
	private $format = 'json';
	private $returnUrl = 'http://shisuixingdong.caapa.org/index/pay/returnUrl';
	private $notifyUrl = 'http://shisuixingdong.caapa.org/index/pay/notifyUrl';


	public function __construct(){
		
	}

	public function pagepay($out_trade_no, $subject, $total_amount){
		//构造参数  
		$aop = new \AopClient();

		$aop->gatewayUrl = $this->gatewayUrl;
		$aop->appId = $this->appId;
		$aop->rsaPrivateKey = $this->rsaPrivateKey;
		$aop->apiVersion = $this->apiVersion;
		$aop->signType = $this->signType;
		$aop->postCharset = $this->postCharset;
		$aop->format = $this->format;
		$request = new \AlipayTradePagePayRequest();
		$request->setReturnUrl($this->returnUrl);
		$request->setNotifyUrl($this->notifyUrl);

		$bizContent = array(
			'product_code' => 'FAST_INSTANT_TRADE_PAY',
			'out_trade_no' => $out_trade_no,
			'subject' => $subject,
			'total_amount' => $total_amount
		);
		$request->setBizContent(json_encode($bizContent));

		$result = $aop->pageExecute ($request);
		echo $result;
	}
}