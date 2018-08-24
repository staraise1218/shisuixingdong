<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:79:"E:\PHPTools\www\shihuixingdong\public/../application/index\view\user\login.html";i:1534345866;s:72:"E:\PHPTools\www\shihuixingdong\application\index\view\common\script.html";i:1529292885;s:69:"E:\PHPTools\www\shihuixingdong\application\index\view\common\top.html";i:1534920327;s:72:"E:\PHPTools\www\shihuixingdong\application\index\view\common\footer.html";i:1534141675;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <title>登录-拾惠行动</title>
    <meta charset="UTF-8">

    <!-- Loading Bootstrap -->
    <link href="/assets/css/frontend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="/assets/js/html5shiv.js"></script>
      <script src="/assets/js/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        var require = {
            config: <?php echo json_encode($config); ?>
        };
    </script>

    <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-frontend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>

    <script src="http://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="/static/css/index.css">
    <link rel="stylesheet" type="text/css" href="/static/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/static/css/iconfont.css">

   
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
    <div id="content-container" class="container">
        <div class="user-section login-section">
            <div class="logon-tab clearfix"> <a class="active"><?php echo __('Sign in'); ?></a> <a href="<?php echo url('user/register'); ?>"><?php echo __('Sign up'); ?></a> </div>
            <div class="login-main"> 
                <form name="form" id="login-form" class="form-vertical" method="POST" action="">
                    <input type="hidden" name="url" value="<?php echo $url; ?>" />
                    <?php echo token(); ?>
                    <div class="form-group">
                        <label class="control-label" for="account"><?php echo __('Account'); ?></label>
                        <div class="controls">
                            <input class="form-control input-lg" id="account" type="text" name="account" value="" data-rule="required" placeholder="<?php echo __('Email/Mobile/Username'); ?>" autocomplete="off">
                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password"><?php echo __('Password'); ?></label>
                        <div class="controls">
                            <input class="form-control input-lg" id="password" type="password" name="password" data-rule="required;password" placeholder="<?php echo __('Password'); ?>" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="controls">
                            <input type="checkbox" name="keeplogin" checked="checked" value="1"> <?php echo __('Keep login'); ?> 
                            <div class="pull-right"><a href="javascript:;" class="btn-forgot"><?php echo __('Forgot password'); ?></a></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block"><?php echo __('Sign in'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/html" id="resetpwdtpl">
        <form id="resetpwd-form" class="form-horizontal form-layer" method="POST" action="<?php echo url('api/user/resetpwd'); ?>">
            <div class="form-body">
                <input type="hidden" name="action" value="resetpwd" />
                <div class="form-group">
                    <label for="" class="control-label col-xs-12 col-sm-3"><?php echo __('Type'); ?>:</label>
                    <div class="col-xs-12 col-sm-8">
                        <div class="radio">
                            <label for="type-email"><input id="type-email" checked="checked" name="type" data-send-url="<?php echo url('api/ems/send'); ?>" data-check-url="<?php echo url('api/validate/check_ems_correct'); ?>" type="radio" value="email"> <?php echo __('Reset password by email'); ?></label>
                            <label for="type-mobile"><input id="type-mobile" name="type" type="radio" data-send-url="<?php echo url('api/sms/send'); ?>" data-check-url="<?php echo url('api/validate/check_sms_correct'); ?>" value="mobile"> <?php echo __('Reset password by mobile'); ?></label>
                        </div>        
                    </div>
                </div>
                <div class="form-group" data-type="email">
                    <label for="email" class="control-label col-xs-12 col-sm-3"><?php echo __('Email'); ?>:</label>
                    <div class="col-xs-12 col-sm-8">
                        <input type="text" class="form-control" id="email" name="email" value="" data-rule="required(#type-email:checked);email;remote(<?php echo url('api/validate/check_email_exist'); ?>, event=resetpwd, id=<?php echo $user['id']; ?>)" placeholder="">
                        <span class="msg-box"></span>
                    </div>
                </div>
                <div class="form-group hide" data-type="mobile">
                    <label for="mobile" class="control-label col-xs-12 col-sm-3"><?php echo __('Mobile'); ?>:</label>
                    <div class="col-xs-12 col-sm-8">
                        <input type="text" class="form-control" id="mobile" name="mobile" value="" data-rule="required(#type-mobile:checked);mobile;remote(<?php echo url('api/validate/check_mobile_exist'); ?>, event=resetpwd, id=<?php echo $user['id']; ?>)" placeholder="">
                        <span class="msg-box"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="captcha" class="control-label col-xs-12 col-sm-3"><?php echo __('Captcha'); ?>:</label>
                    <div class="col-xs-12 col-sm-8">
                        <div class="input-group">
                            <input type="text" name="captcha" class="form-control" data-rule="required;length(4);integer[+];remote(<?php echo url('api/validate/check_ems_correct'); ?>, event=resetpwd, email:#email)" />
                            <span class="input-group-btn" style="padding:0;border:none;">
                                <a href="javascript:;" class="btn btn-info btn-captcha" data-url="<?php echo url('api/ems/send'); ?>" data-type="email" data-event="resetpwd"><?php echo __('Send verification code'); ?></a>
                            </span>
                        </div>
                        <span class="msg-box"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="newpassword" class="control-label col-xs-12 col-sm-3"><?php echo __('New password'); ?>:</label>
                    <div class="col-xs-12 col-sm-8">
                        <input type="password" class="form-control" id="newpassword" name="newpassword" value="" data-rule="required;password" placeholder="">
                        <span class="msg-box"></span>
                    </div>
                </div>
            </div>
            <div class="form-group form-footer">
                <label class="control-label col-xs-12 col-sm-3"></label>
                <div class="col-xs-12 col-sm-8">
                    <button type="submit" class="btn btn-md btn-info"><?php echo __('Ok'); ?></button>
                </div>
            </div>
        </form>
    </script>
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