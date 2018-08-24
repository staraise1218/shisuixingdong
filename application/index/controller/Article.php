<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Db;

class Article extends Frontend
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
        $keyword = input('get.keyword');

        $where = array('status' => 1);
        if($keyword) $where['title'] = array('title', 'like', "'%$keyword%'");
        // 获取文章
        $list = Db::name('article')
            ->where($where)
            ->field('id, title, createtime')
            ->order('weigh desc')
            ->paginate(20);

        $this->assign('list', $list);
        return $this->fetch();
    }

    public function detail(){
        $id = input('param.id');

        $info = Db::name('article')->where('id', $id)->find();

        if(empty($info)){
            $this->error('文章不存在');
        }

        $this->assign('info', $info);
        return $this->fetch();
    }

}
