<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Db;

class Activity extends Base
{

    protected $noNeedLogin = 'detail';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {

        $where = array('status' => 1);
        // 获取文章
        $list = Db::name('activity')
            ->where($where)
            ->field('id, title, image, description, createtime')
            ->order('weigh desc')
            ->paginate(10);

        // 文字分类
        $category = Db::name('category')->where('type', 'article')->select();

        $this->assign('list', $list);
        $this->assign('category', $category);

        return $this->fetch();
    }

    public function detail(){
        $id = input('param.id');

        $info = Db::name('activity')->where('id', $id)->find();

        if(empty($info)){
            $this->error('文章不存在');
        }

        $this->assign('info', $info);
        $this->assign('activity_id', $id);
        return $this->fetch();
    }

    public function enroll(){
        
        $user_id = $this->auth->id;
        if($this->request->isPost()){
            $activity_id = input('post.activity_id');
            $fullname = input('post.fullname');
            $mobile = input('post.mobile');
            $email = input('post.email');
            $sex = input('post.sex');
            $ID_no = input('post.ID_no');
            $fang = input('post.fang');
            $people_num = input('post.people_num');
            $token = input('post.__token__');

            $data = array(
                'fullname' => $fullname,
                'mobile' => $mobile,
                'email' => $email,
                'sex' => $sex,
                'ID_no' => $ID_no,
                'fang' => $fang,
                'people_num' => $people_num,
                'token' => $token,
            );

            $validate_result = $this->validate(
                $data,
                array(
                    'fullname' => 'require|max:10',
                    'email' => 'require|email',
                    '__token__' => 'token',
                ),
                array(
                    'fullname.require' => '姓名必填',
                )
            );

            if( true !== $validate_result){
                $this->error($validate_result);
            }

            /****************** 判断是否已经报名 ************/
            $enrolled = Db::name('activity_enroll')
                ->where('user_id', $user_id)
                ->where('activity_id', $activity_id)
                ->count();

            if($enrolled) $this->error('您已报名该活动');

            unset($data['token']);
            
            $data['createtime'] = time();
            $data['activity_id'] = $activity_id;
            $data['user_id'] = $user_id;

            if(Db::name('activity_enroll')->insert($data)){
                $this->success('报名成功');
            } else {
                $this->error('报名失败');
            }
        }

        $activity_id = input('activity_id');
        if($activity_id == '') $this->error('数据错误');
        $userinfo = Db::name('user')->find($user_id);
        $this->assign('userinfo', $userinfo);
        $this->assign('activity_id', $activity_id);
        return $this->fetch();
    }

}
