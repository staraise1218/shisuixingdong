<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:82:"E:\PHPTools\www\shihuixingdong\public/../application/index\view\student\index.html";i:1534949137;s:69:"E:\PHPTools\www\shihuixingdong\application\index\view\common\top.html";i:1534920327;s:72:"E:\PHPTools\www\shihuixingdong\application\index\view\common\footer.html";i:1534141675;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<title>拾穗行动-全部学生</title>
	<meta charset="UTF-8">

	<script src="http://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
	<link href="/assets/css/frontend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">
	<script type="text/javascript">
        var require = {
            config: <?php echo json_encode($config); ?>
        };
    </script>
	<script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-frontend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
	<!-- <script src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
	<!-- <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
	<!-- <script type="text/javascript" src="/assets/libs/layer/dist/layer.js"></script> -->
	<script type="text/javascript" src="/static/js/script.js"></script>
	<link rel="stylesheet" type="text/css" href="/static/css/index.css">
	<link rel="stylesheet" type="text/css" href="/static/css/allstudent.css">
	<link rel="stylesheet" type="text/css" href="/static/css/reset.css">
	<link rel="stylesheet" type="text/css" href="/static/css/iconfont.css">
	<link rel="stylesheet" type="text/css" href="/static/css/contributor.css">
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
			<li class="active active_bread">全部学生</li>
		</ol>
	</div>
	<!-- 条件筛选 -->
	<div class="pa white_bg" style="overflow:visible;">
		<ul class="select">
			<li class="select-list">
				<dl id="select1">
					<dt>资助情况：</dt>
					<dd class="select-all <?php echo !empty($filter['donation_status'])?'' : 'selected'; ?>" data-val=""><a href="javascript:;">全部</a></dd>
					<dd class='<?php if($filter['donation_status'] == 1): ?>selected<?php endif; ?>' data-val="1"><a href="javascript:;">待资助</a></dd>
					<dd class='<?php if($filter['donation_status'] == 2): ?>selected<?php endif; ?>' data-val="2"><a href="javascript:;">资助中</a></dd>
				</dl>
			</li>
			<li class="select-list">
				<dl id="select2">
					<dt>年龄：</dt>
					<dd class="dosubmit select-all <?php echo !empty($filter['age'])?'' : 'selected'; ?>" data-val=""><a href="javascript:;">不限</a></dd>
					<dd class="dosubmit <?php echo $filter['age']=='3-6'?'selected' : ''; ?>" data-val="3-6"><a href="javascript:;">3-6岁</a></dd>
					<dd class="dosubmit <?php echo $filter['age']=='7-14'?'selected' : ''; ?>" data-val="7-14"><a href="javascript:;">7-14岁</a></dd>
					<dd class="dosubmit <?php echo $filter['age']=='15-20'?'selected' : ''; ?>" data-val="15-20"><a href="javascript:;">15-20岁</a></dd>
					<dd><input type="text" name="age_l" value="<?php echo $filter['age_l']; ?>"> 岁&nbsp;&nbsp;</dd>
					<dd class="none">至</dd>
					<dd><input type="text" name="age_r" value="<?php echo $filter['age_r']; ?>"> 岁&nbsp;&nbsp;</dd>
					<dd><input class="subbtn" type="submit" name="ageBtn" value="确定"></dd>
				</dl>
			</li>
			<li class="select-list">
				<dl id="select3">
					<dt>性别：</dt>
					<dd class="select-all <?php echo !empty($filter['sexdata'])?'' : 'selected'; ?>" data-val=""><a href="javascript:;">不限</a></dd>
					<dd class="<?php echo $filter['sexdata']=='1'?'selected' : ''; ?>" data-val="1"><a href="javascript:;">男</a></dd>
					<dd class="<?php echo $filter['sexdata']=='2'?'selected' : ''; ?>" data-val="2"><a href="javascript:;">女</a></dd>
				</dl>
			</li>
			<li class="select-list">
				<form role="diqu" action="">
				<dl id="select4">
					<dt>地区：</dt>
					<dd><input type="city" style="width: 200px;" name="city" value="<?php echo $filter['city']; ?>" id="city" data-toggle="city-picker" /></dd>
					<dd><input class="subbtn" type="button" name="cityBtn" value="确定"></dd>
				</dl>
				</form>
			</li>
		</ul>
		<form action="<?php echo url('student/index'); ?>" method="get" id="filter" style="display: none;">
			<input type="hidden" name="donation_status" value="<?php echo $filter['donation_status']; ?>">
			<input type="hidden" name="age" value="<?php echo $filter['age']; ?>">
			<input type="hidden" name="sexdata" value="<?php echo $filter['sexdata']; ?>">
			<input type="hidden" name="city" value="<?php echo $filter['city']; ?>">
			<input type="hidden" class="orderInput" name="orderByUpdatetime" value="<?php echo $filter['orderByUpdatetime']; ?>">
			<input type="hidden" class="orderInput" name="orderByAge" value="<?php echo $filter['orderByAge']; ?>">
		</form>
	</div>
	<div class="pa">
		<div class="white_bg">
			<ul class="condition_list">
				<li class="<?php echo !empty($filter['orderByUpdatetime'])?'condition_active' : ''; ?>" order-name="orderByUpdatetime">按更新时间 <span class="iconfont icon-shangxia"></span></li>
				<li class="<?php echo !empty($filter['orderByAge'])?'condition_active' : ''; ?>" order-name="orderByAge">按年龄 <span class="iconfont icon-shangxia"></span></li>
			</ul>
		</div>
	</div>
	<!-- 学生列表 -->
	<div class="pa">
		<?php foreach($list as $item): ?>
		<div class=" col-lg-3 col-md-4 col-sm-6">
			<div class="student_item">
				<div class="student_name"><a href="<?php echo url('student/detail', array('id'=>$item['id'])); ?>"><?php echo $item['name']; ?></a></div>
				<p><?php echo $item['nation']; ?> / <?php echo $item['age']; ?>岁 / <?php echo $item['sexdata']=='1'?'男' : '女'; ?></p>
				<p>编号： <span><?php echo $item['number']; ?></span></p>
				<p>学校： <span><?php echo $item['school_name']; ?></span></p>
				<div class="student_family">家庭： <span><?php echo $item['family_status']; ?></span></div>
				<?php if($item['donation_status'] == 1): ?>
				<a class="student_donation" href="<?php echo url('student/donation', array('student_id'=>$item['id'])); ?>">捐助</a>
				<?php endif; ?>
			</div>
			<div class="item_mr"></div>
		</div>
		<?php endforeach; ?>
	</div>
	<div class="pa ac">
		<?php echo $list->render(); ?>
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