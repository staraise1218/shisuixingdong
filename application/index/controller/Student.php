<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Db;
// use think\Paginator;
use think\paginator\driver\Bootstrap;

class Student extends Base
{

    protected $noNeedLogin = 'index,detail';
    protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
        /**************** 筛选条件 ****************/
        $donation_status = input('get.donation_status');
        $age = input('get.age');
        $age_l = input('get.age_l/d');
        $age_r = input('get.age_r/d');
        $sexdata = input('get.sexdata');
        $city = input('get.city');
        $orderByUpdatetime = input('get.orderByUpdatetime', 'desc');
        $orderByAge = input('get.orderByAge');
        $studentName = input('get.studentName');

        if($donation_status) $where['donation_status'] = $donation_status;
        if($age){
            $ageArr = explode('-', $age);
            $y = date('Y');
            $m = date('m');
            $d = date('d');
            $birthday_l = $y-$ageArr[0].'-'.$m.'-'.$d;
            $birthday_r = $y-$ageArr[1].'-'.$m.'-'.$d;
            $where['birthday'] = array('BETWEEN', "$birthday_r, $birthday_l");
            $filter['age_l'] = $ageArr[0];
            $filter['age_r'] = $ageArr[1];
        } else {
            $filter['age_l'] = '';
            $filter['age_r'] = '';
        }
        if($sexdata) $where['sexdata'] = $sexdata;
        if($studentName) $where['stu.name'] = array('like', "%$studentName%");
        if($city) $where['stu.city'] = array('like', "%$city%");

        /****************** 排序方式 默认按更新时间倒序**************/
        if($orderByUpdatetime) $order = 'stu.updatetime '.$orderByUpdatetime;
        if($orderByAge) $order = 'stu.age '.$orderByAge;

         /**************** 查询数据 ****************/
        $where['status'] = '2';
        $list = Db::name('student')->alias('stu')
                ->join('school sch', 'stu.school_id=sch.id', 'left')
                ->where($where)
                ->order($order)
                // ->limit($offset, $limit)
                ->field('stu.id, stu.name, stu.city, stu.nation, stu.sexdata, stu.birthday, stu.number, stu.family_status, stu.donation_status')
                ->paginate(16, false, ['query'=>request()->param()]);


        /**************** 输出模板变量 ****************/
        $filter['donation_status'] = input('get.donation_status');
        $filter['age'] = input('get.age');
        // $filter['age_l'] = input('get.age_l');
        // $filter['age_r'] = input('get.age_r');
        $filter['sexdata'] = input('get.sexdata');
        $filter['city'] = $city;
        $filter['orderByUpdatetime'] = $orderByUpdatetime;
        $filter['orderByAge'] = $orderByAge;
        
        $this->assign('studentName', $studentName);
        $this->assign('filter', $filter);
        $this->assign('list', $list);
        return $this->fetch();
    }

    public function detail(){
        $id = input('id/d');

        $info = Db::name('student')->alias('stu')
                ->join('school sch', 'stu.school_id=sch.id', 'left')
                ->where('stu.id', $id)
                ->field('stu.id, stu.name, stu.nation, stu.sexdata, stu.city, stu.birthday, stu.number, stu.family_status, stu.donation_status, stu.detailcontent, stu.createtime, sch.name school_name')
                ->find();
        // 查找已结对的学生的结对对象
        if($info['donation_status'] == 2){
            $donation = Db::name('donation')
                    ->where(array('id'=>$id, 'paystatus'=>'1'))
                    ->order('id desc')
                    ->field('fullname, paytime, expirytime')
                    ->find();

            $this->assign('donation', $donation);
        }

        // 判断登录用户是否捐助该学生
        $is_donation = 0;
        $user_id = $this->auth->id;
        if($user_id){
            $count = Db::name('donation')->where(array('id'=>$id, 'paystatus'=>'1'))->count();
            $is_donation = $count ? 1 : 0;
        }


        $this->assign('info', $info);
        $this->assign('is_donation', $is_donation);
        return $this->fetch();
    }

    // 捐款
    public function donation(){
        $student_id = input('param.student_id/d');
        $user_id = $this->auth->id;

        // 学生信息
        $student = Db::name('student')->field('needmoney, donation_status, status')->find($student_id);

        if($this->request->isPost()){
            $fullname = input('post.fullname');
            $sex = input('post.sex');
            $email = input('post.email');
            $birthday = input('post.birthday');
            $profession = input('post.profession');
            $address = input('post.address');
            $address_detail = input('post.address_detail');
            $token = input('post.__token__');
            $year = input('post.year');

            $data = array(
                'fullname' => $fullname,
                'birthday' => $birthday,
                'profession' => $profession,
                'sex' => $sex,
                'email' => $email,
                'address' => $address,
                'address_detail' => $address_detail,
                '__token__' => $token,
            );

            $validate_result = $this->validate(
                $data,
                array(
                    'fullname' => 'require|max:10',
                    'birthday' => 'date',
                    'email' => 'require|email',
                    'profession' => 'max:60',
                    'address_detail' => 'max:60',
                    '__token__' => 'token',
                ),
                array(
                    'fullname.require' => '姓名必填',
                    'nickname.max' => '昵称不能超过10个字符',
                    'birthday.date' => '请选择有效的生日格式：yyyy-mm-dd',
                    'profession.max' => '职业不能超过60个字符',
                    'address_detail.max' => '地址不能超过60个字符',
                )
            );

            if( true !== $validate_result){
                $this->error($validate_result);
            }

            /****************** 判断学生状态是否在带捐助 ************/
            if($student['donation_status'] == 2) $this->error('该学生已被其他用户捐助');
            if($student['status'] == 1) $this->error('该学生尚未发布');

            unset($data['__token__']);
            

            $order_sn = $this->generateOrderSn();
            $data = array_merge($data, array(
                'user_id' => $user_id,
                'student_id' => $student_id,
                'money' => $student['needmoney'],
                'year' => $year,
                'createtime' => time(),
                'order_sn' => $order_sn,
            ));
            $donation_id = Db::name('donation')->insertGetId($data);
            if(!$donation_id){
                $this->error('修改失败');
            }
            $paymentMethodUrl = url('index/pay/paymentMethod', array('order_sn'=>$order_sn));
            $this->success('提交成功', null, ['paymentMethodUrl'=>$paymentMethodUrl]);
        }

        $userinfo = Db::name('user')->find($user_id);
        

        $this->assign('userinfo', $userinfo);
        $this->assign('student', $student);
        $this->assign('student_id', $student_id);

        return $this->fetch();
    }

    public function generateOrderSn(){
        $order_sn = date('YmdHis').mt_rand(1000, 9999);

        $count = Db::name('donation')->where('order_sn', $order_sn)->count();
        if($count) $this->generateOrderSn();

        return $order_sn;
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
