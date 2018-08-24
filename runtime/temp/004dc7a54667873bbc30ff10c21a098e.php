<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:85:"E:\PHPTools\www\shihuixingdong\public/../application/index\view\user\certificate.html";i:1534140930;s:69:"E:\PHPTools\www\shihuixingdong\application\index\view\common\top.html";i:1534920327;s:72:"E:\PHPTools\www\shihuixingdong\application\index\view\user\leftmenu.html";i:1534085994;s:72:"E:\PHPTools\www\shihuixingdong\application\index\view\common\footer.html";i:1534141675;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<title>合伙人证书</title>
	<meta charset="UTF-8">
	<script src="http://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/jquery/1.8.3/jquery.min.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/static/css/index.css">
	<link rel="stylesheet" type="text/css" href="/static/css/reset.css">
	<link rel="stylesheet" type="text/css" href="/static/css/iconfont.css">
	<link rel="stylesheet" type="text/css" href="/static/css/mycont.css">
	<link rel="stylesheet" type="text/css" href="/static/css/track.css">

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
			<li><a href="<?php echo url('user/index'); ?>">我的捐赠</a></li>
			<li class="active active_bread">合伙人证书</li>
		</ol>
	</div>
	<!-- 捐款 -->
	<div class="pa mycont">
		<ul class="mycont_menu white_bg fl ac">
    <li><a <?php echo $config['actionname']=='index'?'class=login_act' : 'href='.url('user/index'); ?>>我的捐赠</a></li>
    <li><a <?php echo $config['actionname']=='personal'?'class=login_act' : 'href='.url('user/personal'); ?>>个人中心</a></li>
    <li><a <?php echo $config['actionname']=='certificate'?'class=login_act' : 'href='.url('user/certificate'); ?>>合伙人证书</a></li>
    <li><a <?php echo $config['actionname']=='feedback'?'class=login_act' : 'href='.url('user/feedback'); ?>>平台反馈</a></li>
</ul>
		<div class="mycont_list white_bg fr">
			<ul class="personal_top">
				<li><a href="#">合伙人证书</a></li>
			</ul>
			<div class="partner">
				<img class="partner_img" src="/static/images/partner.png">
				<img class="partner_img" src="/static/images/partner.png">
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