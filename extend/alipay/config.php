<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2088231060888185",

		//商户私钥
		'merchant_private_key' => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCnxj/9qwVfgoUh/y2W89L6BkRAFljhNhgPdyPuBV64bfQNN1PjbCzkIM6qRdKBoLPXmKKMiFYnkd6rAoprih3/PrQEB/VsW8OoM8fxn67UDYuyBTqA23MML9q1+ilIZwBC2AQ2UBVOrFXfFl75p6/B5KsiNG9zpgmLCUYuLkxpLQIDAQAB",
		
		//异步通知地址
		'notify_url' => "http://外网可访问网关地址/alipay.trade.page.pay-PHP-UTF-8/notify_url.php",
		
		//同步跳转
		'return_url' => "http://外网可访问网关地址/alipay.trade.page.pay-PHP-UTF-8/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEArOIQAl26+RNfue1KYYWGGE1TWAC6BcnxMkygw2GbWGO3SXSz8rqO7Pj+YW8mGqH5WfYektk0ZT/HjJXjh0jbQQrFoXpfVkp9yqY8qXFBUcCBhghi587OKFD/ZyD9v6lewTVWgJjqXnsmZjPj4DhalzaRKHwtQ0R9zo1SLMpRGbEtCUhJPWTLVYOGVGSL+EkGQi5D/auOvoAEmNh9qf+aOz6z00SoqP8KpsNzIWjjqkapNzj+f5CU4iIBpnGf+uMu/ovWo1VnLHOTUvHR1KxA9+x9DO20hnwJFF+PzZuN+9lm0ORh0qai8dXc0wv7sa3xFoaYMCLlcGfCnX0FDjq+JwIDAQAB",
);