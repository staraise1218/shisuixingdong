<?php

namespace app\common\library\payment;

require_once ( EXTEND_PATH . 'alipay/AopSdk.php');

class Alipay {
	// 支付宝支付网关
	private $gatewayUrl = 'https://openapi.alipay.com/gateway.do';
	// 支付宝分配给开发者的应用ID
	private $appId = '2018102561805577';
	private $rsaPrivateKey = 'MIIEpAIBAAKCAQEAvTZBCoTp/C4HTYZmPenWNEJi4lDp3DQX0Fs4agwbvq2z4PuBFtFh3Sucmj9vWYpgBP2IGAdqouaeU5Lx3d9P36CYlE5VffUWjZEsjXJy23bMJgrI1dVEzjKWV0QT29TPtxu7YGLdrpLtS7AWKG9ybT9O2RndzmIdjFyrsTgo48hBArNxI/WLqyl4FkVVpRTLzFCcY3XF76M6M/uS6kZn4egCb/b/Li2mJwKzYDqG5cvXRqd+urt3roEIHbAXev6nhEiH8kAWP//Myw5JmjoVVgMy9x15A+b2/FfpkEaEtnGr8mk6QJ5ElZyTuNpBV0kq+xLhXCjpuletmyZx0WXanQIDAQABAoIBAQCd0shTxuQJJjePMcDMeeTjOFCU59r5gzYt5DjdM/ZciTUWP5LAfqv7uKnqe2kcrfBDmVpQeLc449ZCbbpzUBamuKUsZ16mLq2+Lc6UuVcWujO0s6ArxLWcrNN8PNu3rP4JhQc5cZ3pRMLMNDd3SOaQO5NAQXQi9vIgpxfLPcXVoD3pXaYYnpi7TalWh677gh+56m0PcZR7Vxyoiimjd5nvNDhEfRd86agEAozSPw5jVtJ6rOYoXdDeqs8Xge6PRD4j3f/zSgDNSGW8+tS3M5DE7M4a+1B8X7Dj/SwDZzrRZmQ9oJVdQYIKyeORB2biWf5Cxg1qIpPxgMqBLNDCg0GhAoGBAPFYXFiBdOrIVmnfWnWGYWQTOzauc3ELYPe8uVrXR4ViKsAM1PCX33+znTPbJDdFGKhY4ykHH0Bg56MT32Cdbub7leQnANi8CwABGKKAoRUtZvp2J+P+C6xtrvXIZWTMKCAIhAZsysUzSmHUPSiqF5Yo4SxwcCmMaOh4zyqnYUXJAoGBAMizf2fq+qTp+A2vN1CXoZb0y/PsUpEmKS+9aXGPhHB4yfUlY8d/hEvSvu1DjYeX3xG32CPnwGtzlvq2YuQuv4bgIUwDXBs3HsT/yyHDc4bemKghYW0ksGlsxK92IqFik1zeERQC7KTvq6UA1X/rr2TQ5nG4+KacBzmaLKv2Ayg1AoGBAKxBnOeuvnw0sTivqijn2OtMrp7AtLSionsvwDwOG4YgItMgVXvDakoDMNiqOJcaQhcmGjxWUP/qKmpC7NRQia9jMgC9teT7kf5WyfZySIaM+Usaui4ITNytDItwlK306U6zxUewrqlBin14to4nmN4cH1tQhT2icd47G+IdxVfBAoGAN2btVZdU5y867TQf9dxVm+EpZ8UlqbG6Dtafg9yVN6LwRP60Q37c2z1qvP431GVFC5QPUyIHSOIYnE66j7ij4CyApIYM5+pYURM3VLOqcWGDDG5igYluNTv0M2dN+fTHLwyR9E82WfVbEWpghTZfLVpJMr1Xzk4l5G29xR5dEr0CgYB1ZNDSIgf81cmOHyT+zOL/I9o7mAQhpMOXiNQclX2iXR8KOZeWti5xXEHQPsgoRRu7nvx70LqAw8fAXvVFPSsT8ofhRwcqS1tY/YYu3/dMbzrKWQTECfyJA3HlncdfxVX5ZL/wJj/UB0qVUiJtGKLJIWwdcBb+Ig+6cERnMJ2Qtw==';
	private $alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAj2wOj24l/XINf1fmYHMxM2UCEkm3t7noVO5/GpNkSv1c+WxnFu01/MyURLSkP2Fg1Gxe2k3RlXaIoGplB/bTYmgyP5qWC8fKu6uJhOt3GfEOKuax9ARFWgnv3ntwk7xXB4X7J1XkAHGCnLe79i0xGXu7p9yAE5K1Xm1qyUM4WfyMOHlSh9sv9JdcwtLLjoZ7Fq2lTSmIWpfUOG9h07NQIH3PQDYUI/kQ+dBDBy2GlmeOFi+WOlksGNnHaRHhXsI3ccjee8eakcK4a2Ix6Sjv7KKSV4zHmCLkhcO3LOqK/qv9YlVRy8e4fx6cql6ZAw/EwV4PVAl0dDSKMWrigakRoQIDAQAB';
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

	// 回调验签
	public function checkSign(){
		$aop = new \AopClient;
		$aop->alipayrsaPublicKey = $this->alipayrsaPublicKey;
		$signType = $this->signType;
file_put_contents('runtime/log/request.log',var_export($_POST, true), FILE_APPEND);
		return $aop->rsaCheckV1($_POST, $this->alipayrsaPublicKey, $signType);
	}
}