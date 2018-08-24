<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:87:"E:\PHPTools\www\shihuixingdong\public/../application/index\view\pay\payment_method.html";i:1535094633;s:69:"E:\PHPTools\www\shihuixingdong\application\index\view\common\top.html";i:1534920327;s:72:"E:\PHPTools\www\shihuixingdong\application\index\view\common\footer.html";i:1534141675;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<title>拾穗行动-学生详情</title>
	<meta charset="UTF-8">
	<script src="http://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/assets/libs/layer/dist/layer.js"></script>
	<script type="text/javascript" src="/static/js/pay.js"></script>
	<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/static/css/index.css">
	<link rel="stylesheet" type="text/css" href="/static/css/details.css">
	<link rel="stylesheet" type="text/css" href="/static/css/reset.css">
	<link rel="stylesheet" type="text/css" href="/static/css/iconfont.css">
	<link rel="stylesheet" type="text/css" href="/static/css/contributor.css">
	<link rel="stylesheet" type="text/css" href="/static/css/track.css">
	<link rel="stylesheet" type="text/css" href="/static/css/pay.css">

</head>
<body>
	    <!-- 顶部登陆 -->
    <div class="login pa" id="top">
        <div class="fr">
            <?php if($isLogin == true): ?>
            <a href="<?php echo url('user/index'); ?>">我的捐赠</a><span>|</span>
            <a href="<?php echo url('user/logout'); ?>">注销</a><span>|</span>
            <?php else: ?>
            <a href="<?php echo url('user/login'); ?>">登陆</a><span>|</span>
            <a href="<?php echo url('user/register'); ?>">注册</a><span>|</span>
            <?php endif; ?>
            <!-- 微信二维码 -->
            <a class="login_wx" href="#"><i class="iconfont icon-iconfontweixin"></i> 关注微信公众号</a>
            <div class="wx_code ac">
                <div class="wx_code_title">微信二维码</div>
                <div class="wx_code_img"><img src="/static/images/code.png"></div>
            </div>
        </div>
    </div>
    <!-- 导航 -->
    <nav class="pa white_bg">
        <a href="/"><img class="nav_logo" src="/static/images/logo.png"></a>
        <div class="nav_search">
            <div class="nav_input">
                <i class="iconfont icon-search"></i>
                <input type="text" name="studentName" value="<?php echo !empty($studentName)?$studentName : ''; ?>" placeholder="请输入学生姓名">
            </div>
            <div class="nav_icon fr ac searchBtn"><span class="iconfont icon-search" style="font-size: 24px;"></span></div>
        </div>
        <ul class="nav_list">
            <li class="active <?php echo $config['controllername']=='index'?'active_bg' : ''; ?>"><a href="/">首页</a></li>
            <li class="<?php echo $config['controllername']=='student'?'active_bg' : ''; ?>"><a href="<?php echo url('student/index'); ?>">全部学生</a></li>
        </ul>
    </nav>

    <script type="text/javascript">
        $('.searchBtn').click(function(){
            var studentName = $('input[name=studentName]').val();
            if(studentName.trim() == '') return false;

            window.location.href = "<?php echo url('index/student/index'); ?>?studentName="+studentName;
        })

    </script>
	<!-- 面包屑导航 -->
	<div class="pa white_bg">
		<ol class="breadcrumb white_bg">
			<li><a href="/">首页</a></li>
			<li class="active active_bread">支付中心</li>
		</ol>
	</div>
	<!-- 捐款 -->
	<div class="pa">
		<div class="pay_title">支付中心</div>
		<div class="pay_body white_bg">
			<div class="pay_body_title">
				<div class="pay_body_word">您正在向 <span><?php echo $info['name']; ?></span> 捐助 <span><?php echo $info['year']; ?></span> 年的费用 <span><?php echo $info['money']; ?></span> 元</div>
			</div>
			<div class="pay_method">
				<h2 class="pay_method_title">支付方式</h2>
				<ul class="pay_item">
					<li class="border_active current" pay-name="alipay">
						<img class="" src="/static/images/zhi.png">
						<div class="triangle">
							<i class="iconfont icon-icon"></i>
						</div>
					</li>
					<li pay-name="weixin">
						<img src="/static/images/wei.png">
						<div class="triangle">
							<i class="iconfont icon-icon"></i>
						</div>
					</li>
				</ul>
			</div>
			<div class="pay_bottom fr">
				<div class="pay_bottom_word">应付金额 <span class="pay_bottom_red"> ￥ <em>2875.00</em></span></div>
				<input type="hidden" name="order_sn" value="<?php echo $info['order_sn']; ?>">
				<button class="pay_btn">确认支付</button>
			</div>
			<div style="clear: both;"></div>
		</div>
	</div>
	<!-- 底部 -->
    <div class="footer pa ac">
        <p><?php echo $site['copyright']; ?> 备案号：<?php echo $site['beian']; ?></p>
        <p>由北京烽火万家科技有限公司提供技术支持 </p>
    </div>
    <div class="fixed">
        <a class="iconfont icon-xiazai_ ac"></a>
        <br/>
        <a href="#top" class="iconfont icon-shangyi ac"></a>
    </div>
</body>
</html>