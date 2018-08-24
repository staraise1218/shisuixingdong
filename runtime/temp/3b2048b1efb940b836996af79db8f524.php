<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:85:"E:\PHPTools\www\shihuixingdong\public/../application/index\view\student\donation.html";i:1534849791;s:69:"E:\PHPTools\www\shihuixingdong\application\index\view\common\top.html";i:1534920327;s:72:"E:\PHPTools\www\shihuixingdong\application\index\view\common\footer.html";i:1534141675;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<title>拾穗行动-捐款人信息</title>
	<meta charset="UTF-8">
	<script src="http://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>

	<link href="/assets/css/frontend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">
	<script type="text/javascript">
        var require = {
            config: <?php echo json_encode($config); ?>
        };
    </script>
	<script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-frontend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>

	<link rel="stylesheet" type="text/css" href="/static/css/index.css">
	<link rel="stylesheet" type="text/css" href="/static/css/contributor.css">
	<link rel="stylesheet" type="text/css" href="/static/css/reset.css">
	<link rel="stylesheet" type="text/css" href="/static/css/iconfont.css">
	<style type="text/css">
		.contributor_input {width: 400px;}
		.paybtn {}
	</style>
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
			<li><a href="index.html">首页</a></li>
			<li><a href="<?php echo url('student/index'); ?>">全部学生</a></li>
			<li class="active active_bread">捐款人信息</li>
		</ol>
		<p class="remarks">拾穗活动工作组会确保此次信息收集的保密性，个人信息仅供内部人员使用，绝不外泄，感谢大家支持拾穗行动，帮助乡村单亲失依孩子！</p>
	</div>
	<!-- 捐款 -->
	<div class="pa" style="overflow: visible;">
		<div class="remarks">
			<div class="contributor white_bg">
				<form name="donation-form" id="donation-form" action="" method="post" class="form-vertical">
					<?php echo token(); ?>
					<input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
					<input type="hidden" name="year" value="1">
					<div class="contributor_item">
						<p class="contributor_name">姓名 <span class="xing">*</span></p>
						<input class="contributor_input" type="text" name="fullname" data-rule="姓名：required;length(~10)">
					</div>
					<div class="contributor_item">
						<p class="contributor_name">性别 <span class="xing">*</span></p>
						<div  class="contributor_sex">
							<input type="radio" name="sex" value="1" <?php echo $userinfo['gender']=='0'?'checked="checked"' : ''; ?>> 男
						</div>
						<div  class="contributor_sex">
							<input type="radio" name="sex" value="2" <?php echo $userinfo['gender']=='1'?'checked="checked"' : ''; ?>> 女
						</div>
						
					</div>
					<div class="contributor_item">
						<p class="contributor_name">邮箱 <span class="xing">*</span></p>
						<input class="contributor_input" type="email" data-rule="require;email" name="email" value="<?php echo $userinfo['email']; ?>">
					</div>
					<div class="contributor_item">
						<p class="contributor_name">生日</p>
						<input class="contributor_input datetimepicker" type="text" data-rule="date" name="birthday" value="<?php echo $userinfo['birthday']; ?>"  data-date-format="YYYY-MM-DD">
					</div>
					<div class="contributor_item">
						<p class="contributor_name">职业</p>
						<input class="contributor_input" type="text" data-rule="职业:length(~60)" name="profession" value="<?php echo $userinfo['profession']; ?>">
					</div>
					<div class="contributor_item">
						<p class="contributor_name">地址</p>
						<div style="position: relative;">

							<input class="contributor_input contributor_selinput" style="width: 200px;"  data-toggle="city-picker" type="text" name="address" value="<?php echo $userinfo['address']; ?>">
							<input class="contributor_input contributor_selinput" data-rule="详细地址:length(~60)" name="address_detail" placeholder="详细地址" type="text" value="<?php echo $userinfo['address_detail']; ?>">

						</div>
						<style type="text/css">
							.city-picker-span{display: inline-block;}
							/*.city-picker-dropdown {margin-left: 80px; margin-top: -20px;}*/
						</style>
					</div>
					<!-- <div class="contributor_item">
						<p class="contributor_name">个人或家庭照片</p>
						<p>照片用于制作合伙人海报及资助小孩选择合伙人对接时使用，如不愿公开，请在下一项选择不公开</p>
						<div class="contributor_input contributor_area">
							<p class="ac" style="color: #333;"> <span class="fl" style="font-size: 30px;">+</span>请选择文件，限制10MB以内</p>
						</div>
					</div>
					<div class="contributor_item">
						<p class="contributor_name">照片知否公开</p>
						<div  class="contributor_sex">
							<input type="radio" name="phone" checked="checked"> 公开
						</div>
						<div  class="contributor_sex">
							<input type="radio" name="phone"> 不公开
						</div>
					</div> -->
					<div class="contributor_item contributor_bottom">
						<p class="contributor_name contributor_bottom">捐款金额（元）： <span><?php echo $student['needmoney']; ?></span></p>
						<p class="fr">注：默认捐赠一年</p>
					</div>
					<div class="contributor_item contributor_bottom contributor_pay">
						<div class="contributor_name contributor_bottom contributor_payl">总计（元）： <span><?php echo $student['needmoney']; ?></span></div>
						<button type="submit" class="contributor_payr contributor_bottom contributor_name ac paybtn">去支付</button>
					</div>
				</form>
			</div>
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