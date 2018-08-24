$(document).ready(function(){
	$('.pay_item li').click(function(){
		$(this).siblings('li').removeClass('current');
		$(this).addClass('current');
	})

	$('.pay_btn').click(function(){
		var payname = $('.pay_item li.current').attr('pay-name');
		var order_sn = $('input[name=order_sn]').val();

		if(payname == 'alipay' || payname == 'weixin'){
			window.location.href="/index/pay/topay?payname="+payname+"&order_sn="+order_sn;
		} else {
			layer.msg('请选择支付方式');
		}
	})
})