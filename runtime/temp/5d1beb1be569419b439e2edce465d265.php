<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:81:"E:\PHPTools\www\shihuixingdong\public/../application/admin\view\student\edit.html";i:1534993522;s:73:"E:\PHPTools\www\shihuixingdong\application\admin\view\layout\default.html";i:1529292885;s:70:"E:\PHPTools\www\shihuixingdong\application\admin\view\common\meta.html";i:1529292885;s:72:"E:\PHPTools\www\shihuixingdong\application\admin\view\common\script.html";i:1529292885;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>
    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !$config['fastadmin']['multiplenav']): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <form id="edit-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-name" class="form-control" name="row[name]" type="text" value="<?php echo $row['name']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Nation'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-nation" class="form-control" name="row[nation]" type="text" value="<?php echo $row['nation']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Age'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-age" class="form-control" name="row[age]" type="number" value="<?php echo $row['age']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Sexdata'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            
            <div class="radio">
            <?php if(is_array($sexdataList) || $sexdataList instanceof \think\Collection || $sexdataList instanceof \think\Paginator): if( count($sexdataList)==0 ) : echo "" ;else: foreach($sexdataList as $key=>$vo): ?>
            <label for="row[sexdata]-<?php echo $key; ?>"><input id="row[sexdata]-<?php echo $key; ?>" name="row[sexdata]" type="radio" value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['sexdata'])?$row['sexdata']:explode(',',$row['sexdata']))): ?>checked<?php endif; ?> /> <?php echo $vo; ?></label> 
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>

        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Number'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-number" class="form-control" name="row[number]" type="text" value="<?php echo $row['number']; ?>">
        </div>
    </div>
    <?php if($admin_id == 1): ?>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('School_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-school_id" data-rule="required" data-source="school/index" class="form-control selectpage" name="row[school_id]" type="text" value="<?php echo $row['school_id']; ?>">
        </div>
    </div>
    <?php else: ?>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('School_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <select name="row[school_id]" id="c-school_id" class="form-control" disabled="disabled">
                <option value="<?php echo $school['id']; ?>"><?php echo $school['name']; ?></option>
            </select>
        </div>
    </div>
    <?php endif; ?>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Family_status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-family_status" class="form-control" name="row[family_status]" type="text" value="<?php echo $row['family_status']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('City'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class='control-relative'><input id="c-city" class="form-control" data-toggle="city-picker" name="row[city]" type="text" value="<?php echo $row['city']; ?>"></div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Needmoney'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-needmoney" class="form-control" step="0.01" name="row[needmoney]" type="number" value="<?php echo $row['needmoney']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Needyear'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-needyear" class="form-control" name="row[needyear]" type="number" value="<?php echo $row['needyear']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Donation_status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            
            <div class="radio">
            <?php if(is_array($donationStatusList) || $donationStatusList instanceof \think\Collection || $donationStatusList instanceof \think\Paginator): if( count($donationStatusList)==0 ) : echo "" ;else: foreach($donationStatusList as $key=>$vo): ?>
            <label for="row[donation_status]-<?php echo $key; ?>"><input id="row[donation_status]-<?php echo $key; ?>" name="row[donation_status]" type="radio" value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['donation_status'])?$row['donation_status']:explode(',',$row['donation_status']))): ?>checked<?php endif; ?> /> <?php echo $vo; ?></label> 
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>

        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            
            <div class="radio">
            <?php if(is_array($statusList) || $statusList instanceof \think\Collection || $statusList instanceof \think\Paginator): if( count($statusList)==0 ) : echo "" ;else: foreach($statusList as $key=>$vo): ?>
            <label for="row[status]-<?php echo $key; ?>"><input id="row[status]-<?php echo $key; ?>" name="row[status]" type="radio" value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['status'])?$row['status']:explode(',',$row['status']))): ?>checked<?php endif; ?> /> <?php echo $vo; ?></label> 
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>

        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Detailcontent'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-detailcontent" class="form-control editor" rows="5" name="row[detailcontent]" cols="50"><?php echo $row['detailcontent']; ?></textarea>
        </div>
    </div>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>