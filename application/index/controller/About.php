<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Db;

class About extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function _initialize()
    {
        parent::_initialize();
    }

    public function page(){
        $id = input('id');

        $info = Db::name('page')->where('id', $id)->find();

        // 文章分类
        $category = Db::name('category')->where('type', 'partner')->select();

        $this->assign('id', $id);
        $this->assign('info', $info);
        $this->assign('category', $category);
        $this->assign('category_id', 0);
        return $this->fetch();
    }

}
