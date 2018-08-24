<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:80:"E:\PHPTools\www\shihuixingdong\public/../application/index\view\index\index.html";i:1534159234;s:69:"E:\PHPTools\www\shihuixingdong\application\index\view\common\top.html";i:1534920327;s:72:"E:\PHPTools\www\shihuixingdong\application\index\view\common\footer.html";i:1534141675;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <title>拾穗行动-首页</title>
    <meta charset="UTF-8">
    <script src="http://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/static/css/index.css">
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
    <!-- 轮播图 -->
    <div id="myCarousel" class="carousel slide pa">
        <!-- 轮播点 -->
        <ol class="carousel-indicators">
            <?php $__FOR_START_26720__=0;$__FOR_END_26720__=$adcount;for($i=$__FOR_START_26720__;$i < $__FOR_END_26720__;$i+=1){ ?>
            <li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>" <?php echo $i==0?'class="active"' : ''; ?>></li>
            <?php } ?>
        </ol>   
        <!-- 轮播图片 -->
        <div class="carousel-inner">
            <?php if(is_array($adlist) || $adlist instanceof \think\Collection || $adlist instanceof \think\Paginator): if( count($adlist)==0 ) : echo "" ;else: foreach($adlist as $k=>$ad): ?>
            <div class="item <?php echo $k==0?'active' : ''; ?>">
                <a href="<?php echo !empty($ad['link'])?$ad['link'] : 'javascript:;'; ?>"><img class="carousel_img" src="<?php echo $ad['image']; ?>" alt="<?php echo $ad['title']; ?>"></a>
            </div>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
    <!-- 消息 -->
    <div class="pa">
        <div class="news">
            <div class="fl">
                <span class="iconfont icon-huaban" style="font-size: 22px"></span> 全部文件
            </div>
            <div class="news_r fr">
                <a href="<?php echo url('article/index'); ?>">查看全部 <span class="iconfont icon-you-yuan" style="font-size: 22px"></span></a>
            </div>
        </div>
        <ul class="news_list">
            <?php if(is_array($articleList) || $articleList instanceof \think\Collection || $articleList instanceof \think\Paginator): if( count($articleList)==0 ) : echo "" ;else: foreach($articleList as $key=>$article): ?>
            <li>
                <i class="login_act iconfont icon-dian1"></i>
                <span class="news_list_title"><a href="<?php echo url('article/detail', array('id'=>$article['id'])); ?>"><?php echo $article['title']; ?></a></span>
                <div class="news_list_date fr"><?php echo date("Y-m-d H:i", $article['createtime']); ?></div>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
    <!-- 项目统计 -->
    <br/><br/>
    <div class="pa">
        <div class="ac">
            <div class="pub_title">CENSUS</div>
            <img src="/static/images/line.png">
            <div class="pub_stitle">项目统计</div>
        </div>
        <div class="pro">
            <div class="pro_item ac col-lg-4">
                <img class="pro_item_img" src="/static/images/icon.png"> 募捐中项目 <span>2345</span> 个
            </div>
            <div class="pro_item ac col-lg-4">
                <img class="pro_item_img" src="/static/images/icon.png"> 执行中项目 <span>2345</span> 个
            </div>
            <div class="pro_item ac col-lg-4">
                <img class="pro_item_img" src="/static/images/icon.png"> 已结束项目 <span>2345</span> 个
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