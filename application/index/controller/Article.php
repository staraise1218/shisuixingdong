<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Db;

class Article extends Base
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
        $keyword = input('keyword');
        $category_id = input('category_id');

        $where = array('status' => 1);
        if($keyword) $where['title'] = array('title', 'like', "'%$keyword%'");
        if($category_id) $where['category_id'] = $category_id;
        // 获取文章
        $list = Db::name('article')
            ->where($where)
            ->field('id, title, thumb, description, createtime')
            ->order('weigh desc')
            ->paginate(20);

        // 文字分类
        $category = Db::name('category')->where('type', 'article')->select();

        $this->assign('list', $list);
        $this->assign('category', $category);
        $this->assign('category_id', $category_id);

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
