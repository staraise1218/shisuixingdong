<?php

namespace app\common\library\payment;

require_once ( EXTEND_PATH . 'alipay/AopSdk.php');

class Alipay {
	// 支付宝支付网关
	private $gatewayUrl = 'https://openapi.alipay.com/gateway.do';
	// 支付宝分配给开发者的应用ID
	private $appId = '2018080660972237';
	private $rsaPrivateKey = 'MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAJ0rGQ4VhZipD6888u+xDL4lfaOQf+81THwDHFYRtcTHPFi4AFCP+A9sp9+WsA1kPFZqfjVPHyG/J8em7LNwyzTeUqrZfXjQMaR2yfLhTLaj/ljgiQbInjefSL8OWlc+mdBMx4obHW9jAtAv1X6/Uh2UBzTO0WVO3aO7IAbNw2pJAgMBAAECgYABLqrQlU7c+CCbE91L+kv7PjL0wQiFVyRNJoTXDOkOIuWMUU4HTR3zl8CniO2oHCHsEH8EjaTRTyvQb6wGKYoNx70gSoWhPWmAWIi9Vasw9Z47UQFhyF/WTJoDyg2BwE2BgS9zehyakZt8JlQ7P8WFqP/C5ni+ltA1SNX4OKc4gQJBANEXMZJ1dZUv9mjs5rTWhg0pJBULBP8lI8PA1dGqSH8c+wtljFUysXEF/dm2JFNvbdVG67K5PrvReAWxC4eLNPECQQDAbdPQKNmqyK+X8eLwePqvI6ZkUGvYNb3zQRZg4gJiZ6SauF2Lt4AK4ncKoWPER7hNVNlYg5ujxPrf4bXjVCrZAkEAt6tZF19ov3lXSgo4CsibDrqCAJ4icIJObWlaKggcENUDTZqRcFHMfw0VVYZjWIt8fqoC54dELTYu6UkBaLqG8QJAPLzt1JBwVBXQRveUmC63gbyQ8qznvXEJKdTriV0NP55TOHrlHAqpocXlqTdT1EqHA/G6QNQZtlGgljYaQUz50QJASDdc4ihxieZ+DwspwHL5wH+ch37E+D2ZL4Pt02SrcwFYhOHLkHCM3wMfOo9KR+fZjXqOYE7p/UruKElX4qyoGQ==';
	private $apiVersion = '1.0';
	private $signType = 'RSA2';
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