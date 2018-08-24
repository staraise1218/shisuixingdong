<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Db;

class Index extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
        // 获取banner
        $adlist = Db::name('ad')->where('ad_position_id', 1)->field('title, image, link')->select();

        // 获取文章
        $articleList = Db::name('article')->where('status', 1)->field('id, title, createtime')->order('weigh desc')->limit(4)->select();

        $this->assign('adcount', count($adlist));
        $this->assign('adlist', $adlist);
        $this->assign('articleList', $articleList);
        return $this->fetch();
    }

}
