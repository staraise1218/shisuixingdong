<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:79:"E:\PHPTools\www\shihuixingdong\public/../application/index\view\user\index.html";i:1535092244;s:69:"E:\PHPTools\www\shihuixingdong\application\index\view\common\top.html";i:1534920327;s:72:"E:\PHPTools\www\shihuixingdong\application\index\view\user\leftmenu.html";i:1534085994;s:72:"E:\PHPTools\www\shihuixingdong\application\index\view\common\footer.html";i:1534141675;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <title>拾穗行动-我的捐赠</title>
    <meta charset="UTF-8">
    <script src="http://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/jquery/1.8.3/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/static/css/index.css">
    <link rel="stylesheet" type="text/css" href="/static/css/allstudent.css">
    <link rel="stylesheet" type="text/css" href="/static/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/static/css/iconfont.css">
    <link rel="stylesheet" type="text/css" href="/static/css/mycont.css">

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
            <li class="active active_bread">我的捐赠</li>
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
            <ul class="mycont_list_top">
                <li><a class="mycont_list_act" href="#">全部捐款</a></li>
            </ul>
            <div class="mycont_list_table">
                <table class="table ac">
                    <thead>
                        <tr>
                            <th>学生</th>
                            <th>资助时间</th>
                            <th>捐赠款</th>
                            <th>交易状态</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $key=>$item): ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['paystatus']==1?date('Y-m-d', $item['paytime']).'-'.date('Y-m-d', $item['expirytime']) : ''; ?></td>
                            <td>￥<?php echo $item['money']; ?></td>
                            <td>
                                <?php if($item['paystatus']==0): ?>
                                <a style="color: red" href="<?php echo url('index/pay/paymentMethod', array('order_sn'=>$item['order_sn'])); ?>">未支付</a>
                                <?php else: ?>
                                已支付
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($item['paystatus']==1): ?>
                                <a class="table_btn" href="<?php echo url('index/user/track', array('student_id'=>$item['student_id'])); ?>">善款追踪与学生近况</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
                <div class="pa ac">
                    <?php echo $list->render(); ?>
                </div>
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