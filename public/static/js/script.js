$(document).ready(function(){
			
	$("#select1 dd").click(function () {
		$(this).addClass("selected").siblings().removeClass("selected");
		if ($(this).hasClass("select-all")) {
			$("#selectA").remove();
		} else {
			var copyThisA = $(this).clone();
			if ($("#selectA").length > 0) {
				$("#selectA a").html($(this).text());
			} else {
				$(".select-result dl").append(copyThisA.attr("id", "selectA"));
			}
		}

		// 发起筛选请求
		$('#filter').find('input[name=donation_status]').val($(this).attr('data-val'));
		$('#filter').submit();
	});
	
	$("#select2 dd.dosubmit").click(function () {
		$(this).addClass("selected").siblings().removeClass("selected");
		if ($(this).hasClass("select-all")) {
			$("#selectB").remove();
		} else {
			var copyThisB = $(this).clone();
			if ($("#selectB").length > 0) {
				$("#selectB a").html($(this).text());
			} else {
				$(".select-result dl").append(copyThisB.attr("id", "selectB"));
			}
		}

		// 发起筛选请求
		$('#filter').find('input[name=age]').val($(this).attr('data-val'));
		$('#filter').submit();
	});
	
	$("#select3 dd").click(function () {
		$(this).addClass("selected").siblings().removeClass("selected");
		if ($(this).hasClass("select-all")) {
			$("#selectC").remove();
		} else {
			var copyThisC = $(this).clone();
			if ($("#selectC").length > 0) {
				$("#selectC a").html($(this).text());
			} else {
				$(".select-result dl").append(copyThisC.attr("id", "selectC"));
			}
		}
		// 发起筛选请求
		$('#filter').find('input[name=sexdata]').val($(this).attr('data-val'));
		$('#filter').submit();
	});
	
	// 点击年龄后面的确定
	$('input[name=ageBtn]').click(function(){
		var age_l = $.trim($('input[name=age_l').val());
		var age_r = $.trim($('input[name=age_r').val());

		if(age_l == '' || age_r == '') {
			layer.msg('请将年龄范围填写完整');
			return false;
		}

		$('#filter').find('input[name=age]').val(age_l+'-'+age_r);

		$('#filter').submit();
	})
	
	// 点击地区后面的确定
	$('input[name=cityBtn]').click(function(){
		var city = $.trim($('#city').val());

		if(city == '') {
			layer.msg('请选择地区');
			return false;
		}

		$('#filter').find('input[name=city]').val(city);

		$('#filter').submit();
	})

	// 点击学生页面的排序按钮
	$('.condition_list li').click(function(){
		var orderName = $(this).attr('order-name');
		var orderVal = $('input[name='+orderName+']').val()

		$('input.orderInput').val('');
		orderVal = orderVal == 'desc' ? 'asc' : 'desc';
		$('input[name='+orderName+']').val(orderVal);

		$('#filter').submit();
	})
});