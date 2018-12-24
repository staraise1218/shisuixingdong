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

        // 项目统计
        // 募捐中
        $statistics['having'] = Db::name('student')
            ->where('donation_status', 1) // 待资助
            ->where('status', 2) // 已发布
            ->count();

            // 执行中
        $statistics['executing'] = Db::name('student')
            ->where('donation_status', 2) // 资助中
            ->count();

            // 已结束项目
        $statistics['finished'] = Db::name('donation')
            ->where('paystatus', 1) // 资助中
            ->where('expirytime', 'lt', time())
            ->count();

        // 合作伙伴
        $link = Db::name('link')
            ->order('id desc')
            ->select();

        $this->assign('adcount', count($adlist));
        $this->assign('adlist', $adlist);
        $this->assign('articleList', $articleList);
        $this->assign('statistics', $statistics);
        $this->assign('link', $link);
        return $this->fetch();
    }

}
