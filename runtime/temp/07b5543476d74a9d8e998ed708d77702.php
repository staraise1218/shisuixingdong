<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:82:"E:\PHPTools\www\shihuixingdong\public/../application/index\view\user\personal.html";i:1534777475;s:69:"E:\PHPTools\www\shihuixingdong\application\index\view\common\top.html";i:1534920327;s:72:"E:\PHPTools\www\shihuixingdong\application\index\view\user\leftmenu.html";i:1534085994;s:72:"E:\PHPTools\www\shihuixingdong\application\index\view\common\footer.html";i:1534141675;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<title>个人中心</title>
	<meta charset="UTF-8">
	<script src="http://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
	<!-- <script src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
	<link href="/assets/css/frontend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">
	<script type="text/javascript">
        var require = {
            config: <?php echo json_encode($config); ?>
        };
    </script>
	<script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-frontend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
	
	<!-- <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
	<link rel="stylesheet" type="text/css" href="/static/css/index.css">
	<link rel="stylesheet" type="text/css" href="/static/css/reset.css">
	<link rel="stylesheet" type="text/css" href="/static/css/iconfont.css">
	<link rel="stylesheet" type="text/css" href="/static/css/mycont.css">
	<link rel="stylesheet" type="text/css" href="/static/css/track.css">
	<link rel="stylesheet" type="text/css" href="/static/css/contributor.css">
	
    
	
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
			<li class="active active_bread">个人中心</li>
		</ol>
	</div>
	<!-- 捐款 -->
	<div class="pa mycont" style="overflow: visible">
		<ul class="mycont_menu white_bg fl ac">
    <li><a <?php echo $config['actionname']=='index'?'class=login_act' : 'href='.url('user/index'); ?>>我的捐赠</a></li>
    <li><a <?php echo $config['actionname']=='personal'?'class=login_act' : 'href='.url('user/personal'); ?>>个人中心</a></li>
    <li><a <?php echo $config['actionname']=='certificate'?'class=login_act' : 'href='.url('user/certificate'); ?>>合伙人证书</a></li>
    <li><a <?php echo $config['actionname']=='feedback'?'class=login_act' : 'href='.url('user/feedback'); ?>>平台反馈</a></li>
</ul>
		<div class="mycont_list white_bg fr">
			<ul class="personal_top">
				<li><a href="#">个人中心</a></li>
			</ul>
			<div class="personal" style="padding-bottom: 50px;">
				<form name="personal-form" id="personal-form" action="" method="post" class="form-vertical">
					<?php echo token(); ?>
					<div class="contributor_item">
						<label class="contributor_name">用户名：</label>
						<?php echo $userinfo['username']; ?>
					</div>
					<div class="contributor_item">
						<span class="contributor_name">手机号码：</span>
						<?php echo $userinfo['mobile']; ?>
						<button class="submit_btn btn-change" data-type="mobile" type="button">修改</button>
					</div>
					<div class="contributor_item">
						<span class="contributor_name">邮箱：</span>
						<!-- <input class="personal_input contributor_input" type="text" name="email" value="<?php echo $userinfo['email']; ?>" data-rule="email"> -->
						<?php echo $userinfo['email']; ?>
						<button class="submit_btn btn-change" data-type="email" type="button">修改</button>
					</div>
					<div class="contributor_item">
						<span class="contributor_name">密码：</span>
						<!-- <input class="personal_input contributor_input" type="password" name=""> -->
						******
						<button class="submit_btn btn-change" data-type="password" type="button">修改</button>
					</div>
					<div class="contributor_item">
						<label class="contributor_name">昵称：</label>
						<input class="personal_input contributor_input" type="text" name="nickname" value="<?php echo $userinfo['nickname']; ?>"  data-rule="昵称:required;length(~20)">
					</div>
					<div class="contributor_item">
						<span class="contributor_name">性别：</span>
						<input type="radio" name="gender" value="0" <?php echo $userinfo['gender']=='0'?'checked="checked"' : ''; ?>> 男
						<span></span>
						<input type="radio" name="gender" value="1" <?php echo $userinfo['gender']=='1'?'checked="checked"' : ''; ?>> 女
					</div>
					<div class="contributor_item">
						<span class="contributor_name">生日：</span>
						<input class="personal_input contributor_input datetimepicker" data-rule="date" type="text" name="birthday"
						 value="<?php echo $userinfo['birthday']; ?>" data-date-format="YYYY-MM-DD" />
					</div>
					<div class="contributor_item">
						<span class="contributor_name">职业：</span>
						<input class="personal_input contributor_input" data-rule="职业:length(~60)" type="text" name="profession" value="<?php echo $userinfo['profession']; ?>">
					</div>
					<div class="contributor_item" style="position: relative;">
						<span class="contributor_name">地址：</span>
						<input class="contributor_input personal_selinput"  data-toggle="city-picker" type="text" name="address" value="<?php echo $userinfo['address']; ?>">
						<input class="contributor_input personal_selinput" data-rule="详细地址:length(~60)" placeholder="详细地址" type="text" name="address_detail" value="<?php echo $userinfo['address_detail']; ?>">
					</div>

					<style type="text/css">
						.city-picker-span{display: inline-block;}
						.city-picker-dropdown {margin-left: 80px; margin-top: -20px;}
					</style>
					<div class="personal_item contributor_item">
						<span class="contributor_name">修改头像：</span>
						<div class="personal_jia ac">+</div>
					</div>
					<div class="ac">
						<button type="submit" class="details_btn ac">保存修改</button>
					</div>
				</form>
			</div>
			
		</div>
		<div style="clear: both;"></div>
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

	<!-- 修改密码 -->
	<!-- <div class="modal fade" id="myPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="jump">
			<div class="login_title ac">修改密码</div>
			<div class="contributor_item">
				<span class="contributor_name">旧 密 码&nbsp;&nbsp;：</span>
				<input class="jump_input contributor_input" type="text" name="">
			</div>
			<div class="contributor_item">
				<span class="contributor_name">新 密 码&nbsp;&nbsp;：</span>
				<input class="jump_input contributor_input" type="password" name="">
			</div>
			<div class="contributor_item">
				<span class="contributor_name">确认密码：</span>
				<input class="jump_input contributor_input" type="password" name="">
			</div>
			<div class="ac">
				<botton class="details_btn ac">确定</botton>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<botton class="cancel_btn details_btn ac">取消</botton>
			</div>
		</div>
	</div>
	修改手机号
	<div class="modal fade" id="myPhone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="jump">
			<div class="login_title ac">修改手机号</div>
			<div class="contributor_item">
				<span class="contributor_name">手机号：</span>
				<input class="jump_input contributor_input">
			</div>
			<div class="contributor_item">
				<span class="contributor_name">验证码：</span>
				<input class="jump_input contributor_input">
				<button class="ident_btn submit_btn">获取验证码</button>
			</div>
			<div class="ac">
				<botton class="details_btn ac">确定</botton>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<botton class="cancel_btn details_btn ac">取消</botton>
			</div>
		</div>
	</div> -->

<script type="text/html" id="emailtpl">
    <form id="email-form" class="form-horizontal form-layer" method="POST" action="<?php echo url('api/user/changeemail'); ?>">
        <div class="form-body">
            <input type="hidden" name="action" value="changeemail" />
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3"><?php echo __('New Email'); ?>:</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="text" class="form-control" id="email" name="email" value="" data-rule="required;email;remote(<?php echo url('api/validate/check_email_available'); ?>, event=changeemail, id=<?php echo $user['id']; ?>)" placeholder="<?php echo __('New email'); ?>">
                    <span class="msg-box"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3"><?php echo __('Captcha'); ?>:</label>
                <div class="col-xs-12 col-sm-8">
                    <div class="input-group">
                        <input type="text" name="captcha" id="email-captcha" class="form-control" data-rule="required;length(4);integer[+];remote(<?php echo url('api/validate/check_ems_correct'); ?>, event=changeemail, email:#email)" />
                        <span class="input-group-btn" style="padding:0;border:none;">
                            <a href="javascript:;" class="btn btn-info btn-captcha" data-url="<?php echo url('api/ems/send'); ?>" data-type="email" data-event="changeemail">获取验证码</a>
                        </span>
                    </div>
                    <span class="msg-box"></span>
                </div>
            </div>
        </div>
        <div class="form-footer">
            <div class="form-group" style="margin-bottom:0;">
                <label class="control-label col-xs-12 col-sm-3"></label>
                <div class="col-xs-12 col-sm-8">
                    <button type="submit" class="btn btn-md btn-info"><?php echo __('Submit'); ?></button>
                </div>
            </div>
        </div>
    </form>
</script>
<script type="text/html" id="mobiletpl">
    <form id="mobile-form" class="form-horizontal form-layer" method="POST" action="<?php echo url('api/user/changemobile'); ?>">
        <div class="form-body">
            <input type="hidden" name="action" value="changemobile" />
            <div class="form-group">
                <label for="c-mobile" class="control-label col-xs-12 col-sm-3"><?php echo __('New mobile'); ?>:</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="text" class="form-control" id="mobile" name="mobile" value="" data-rule="required;mobile;remote(<?php echo url('api/validate/check_mobile_available'); ?>, event=changemobile, id=<?php echo $user['id']; ?>)" placeholder="<?php echo __('New mobile'); ?>">
                    <span class="msg-box"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="mobile-captcha" class="control-label col-xs-12 col-sm-3"><?php echo __('Captcha'); ?>:</label>
                <div class="col-xs-12 col-sm-8">
                    <div class="input-group">
                        <input type="text" name="captcha" id="mobile-captcha" class="form-control" data-rule="required;length(4);integer[+];remote(<?php echo url('api/validate/check_sms_correct'); ?>, event=changemobile, mobile:#mobile)" />
                        <span class="input-group-btn" style="padding:0;border:none;">
                            <a href="javascript:;" class="btn btn-info btn-captcha" data-url="<?php echo url('api/sms/send'); ?>" data-type="mobile" data-event="changemobile">获取验证码</a>
                        </span>
                    </div>
                    <span class="msg-box"></span>
                </div>
            </div>
        </div>
        <div class="form-footer">
            <div class="form-group" style="margin-bottom:0;">
                <label class="control-label col-xs-12 col-sm-3"></label>
                <div class="col-xs-12 col-sm-8">
                    <button type="submit" class="btn btn-md btn-info"><?php echo __('Submit'); ?></button>
                </div>
            </div>
        </div>
    </form>
</script>

<script type="text/html" id="passwordtpl">
    <form id="mobile-form" class="form-horizontal form-layer" method="POST" action="<?php echo url('index/user/changepwd'); ?>">
        <div class="form-body">
            <input type="hidden" name="action" value="changepasswd" />
            <div class="form-group">
                <label for="oldpassword" class="control-label col-xs-12 col-sm-3">旧密码:</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="password" class="form-control" id="oldpassword" name="oldpassword" value="" data-rule="required;length(6~)" placeholder="旧密码">
                    <span class="msg-box"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="newpassword" class="control-label col-xs-12 col-sm-3">新密码:</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="password" class="form-control" id="newpassword" name="newpassword" value="" data-rule="required;length(6~)" placeholder="旧密码">
                    <span class="msg-box"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="renewpassword" class="control-label col-xs-12 col-sm-3">确认新密码:</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="password" class="form-control" id="renewpassword" name="renewpassword" value="" data-rule="required;match(newpassword)" placeholder="确认新密码" />
                    <span class="msg-box"></span>
                </div>
            </div>
        </div>
        <div class="form-footer">
            <div class="form-group" style="margin-bottom:0;">
                <label class="control-label col-xs-12 col-sm-3"></label>
                <div class="col-xs-12 col-sm-8">
                    <button type="submit" class="btn btn-md btn-info"><?php echo __('Submit'); ?></button>
                </div>
            </div>
        </div>
    </form>
</script>
</body>
</html>