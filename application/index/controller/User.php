<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Config;
use think\Cookie;
use think\Hook;
use think\Session;
use think\Validate;
use think\Db;

/**
 * 会员中心
 */
class User extends Frontend
{

    protected $layout = '';
    protected $noNeedLogin = ['login', 'register', 'third'];
    protected $noNeedRight = ['*'];

    public function _initialize()
    {
        parent::_initialize();
        $auth = $this->auth;

        if (!Config::get('fastadmin.usercenter')) {
            $this->error(__('User center already closed'));
        }

        $ucenter = get_addon_info('ucenter');
        if ($ucenter && $ucenter['state']) {
            include ADDON_PATH . 'ucenter' . DS . 'uc.php';
        }

        //监听注册登录注销的事件
        Hook::add('user_login_successed', function ($user) use ($auth) {
            $expire = input('post.keeplogin') ? 30 * 86400 : 0;
            Cookie::set('uid', $user->id, $expire);
            Cookie::set('token', $auth->getToken(), $expire);
        });
        Hook::add('user_register_successed', function ($user) use ($auth) {
            Cookie::set('uid', $user->id);
            Cookie::set('token', $auth->getToken());
        });
        Hook::add('user_delete_successed', function ($user) use ($auth) {
            Cookie::delete('uid');
            Cookie::delete('token');
        });
        Hook::add('user_logout_successed', function ($user) use ($auth) {
            Cookie::delete('uid');
            Cookie::delete('token');
        });
    }

    /**
     * 会员中心
     */
    public function index()
    {
        $user_id = $this->auth->id;
        $list = Db::name('donation')->alias('don')
                ->join('student stu', 'don.student_id=stu.id', 'left')
                ->where('user_id', $user_id)
                ->field('stu.name, paystatus, paytime, expirytime, don.money, don.id donation_id, don.student_id, don.order_sn')
                ->order('don.id desc')
                ->paginate();

        // 查看是否有未读善款追踪和未读学生近况
        // $is_track_read = 

        $this->assign('list', $list);
        return $this->view->fetch();
    }

    public function track(){
        $user_id = $this->auth->id;
        $student_id = input('param.student_id');
        /************* 判断是否捐助了该学生，如果没捐助，不能查看此信息*/
        $count = Db::name('donation')->where(array('user_id'=>$user_id, 'student_id'=>$student_id, 'paystatus'=>'1'))->count();
        if(!$count) $this->error('您无权查看该学生信息');


        $list = Db::name('student_situation')->where('student_id', $student_id)
                ->select();

        $this->assign('list', $list);

        return $this->fetch();
    }

    public function situation(){
        $user_id = $this->auth->id;
        $student_id = input('param.student_id');
        /************* 判断是否捐助了该学生，如果没捐助，不能查看此信息*/
        $count = Db::name('donation')->where(array('user_id'=>$user_id, 'student_id'=>$student_id, 'paystatus'=>'1'))->count();
        if(!$count) $this->error('您无权查看该学生信息');

        $list = Db::name('track')->where('student_id', $student_id)->select();

        $this->assign('list', $list);

        return $this->fetch();
    }

    /**
     * 注册会员
     */
    public function register()
    {
        $url = $this->request->request('url');
        if ($this->auth->id)
            $this->success(__('You\'ve logged in, do not login again'), $url);
        if ($this->request->isPost()) {
            $username = $this->request->post('username');
            $password = $this->request->post('password');
            $email = $this->request->post('email');
            $mobile = $this->request->post('mobile', '');
            $captcha = $this->request->post('captcha');
            $token = $this->request->post('__token__');
            $rule = [
                'username'  => 'require|length:3,30',
                'password'  => 'require|length:6,30',
                'email'     => 'require|email',
                'mobile'    => 'regex:/^1\d{10}$/',
                'captcha'   => 'require|captcha',
                '__token__' => 'token',
            ];

            $msg = [
                'username.require' => 'Username can not be empty',
                'username.length'  => 'Username must be 3 to 30 characters',
                'password.require' => 'Password can not be empty',
                'password.length'  => 'Password must be 6 to 30 characters',
                'captcha.require'  => 'Captcha can not be empty',
                'captcha.captcha'  => 'Captcha is incorrect',
                'email'            => 'Email is incorrect',
                'mobile'           => 'Mobile is incorrect',
            ];
            $data = [
                'username'  => $username,
                'password'  => $password,
                'email'     => $email,
                'mobile'    => $mobile,
                'captcha'   => $captcha,
                '__token__' => $token,
            ];
            $validate = new Validate($rule, $msg);
            $result = $validate->check($data);
            if (!$result) {
                $this->error(__($validate->getError()), null, ['token' => $this->request->token()]);
            }
            if ($this->auth->register($username, $password, $email, $mobile)) {
                $synchtml = '';
                ////////////////同步到Ucenter////////////////
                if (defined('UC_STATUS') && UC_STATUS) {
                    $uc = new \addons\ucenter\library\client\Client();
                    $synchtml = $uc->uc_user_synregister($this->auth->id, $password);
                }
                $this->success(__('Sign up successful') . $synchtml, $url ? $url : url('user/index'));
            } else {
                $this->error($this->auth->getError(), null, ['token' => $this->request->token()]);
            }
        }
        //判断来源
        $referer = $this->request->server('HTTP_REFERER');
        if (!$url && (strtolower(parse_url($referer, PHP_URL_HOST)) == strtolower($this->request->host()))
            && !preg_match("/(user\/login|user\/register)/i", $referer)) {
            $url = $referer;
        }
        $this->view->assign('url', $url);
        $this->view->assign('title', __('Register'));
        return $this->view->fetch();
    }

    /**
     * 会员登录
     */
    public function login()
    {
        $url = $this->request->request('url');
        if ($this->auth->id)
            $this->success(__('You\'ve logged in, do not login again'), $url);
        if ($this->request->isPost()) {
            $account = $this->request->post('account');
            $password = $this->request->post('password');
            $keeplogin = (int)$this->request->post('keeplogin');
            $token = $this->request->post('__token__');
            $rule = [
                'account'   => 'require|length:3,50',
                'password'  => 'require|length:6,30',
                '__token__' => 'token',
            ];

            $msg = [
                'account.require'  => 'Account can not be empty',
                'account.length'   => 'Account must be 3 to 50 characters',
                'password.require' => 'Password can not be empty',
                'password.length'  => 'Password must be 6 to 30 characters',
            ];
            $data = [
                'account'   => $account,
                'password'  => $password,
                '__token__' => $token,
            ];
            $validate = new Validate($rule, $msg);
            $result = $validate->check($data);
            if (!$result) {
                $this->error(__($validate->getError()), null, ['token' => $this->request->token()]);
                return FALSE;
            }
            if ($this->auth->login($account, $password)) {
                $synchtml = '';
                ////////////////同步到Ucenter////////////////
                if (defined('UC_STATUS') && UC_STATUS) {
                    $uc = new \addons\ucenter\library\client\Client();
                    $synchtml = $uc->uc_user_synlogin($this->auth->id);
                }
                $this->success(__('Logged in successful') . $synchtml, $url ? $url : url('user/index'));
            } else {
                $this->error($this->auth->getError(), null, ['token' => $this->request->token()]);
            }
        }
        //判断来源
        $referer = $this->request->server('HTTP_REFERER');
        if (!$url && (strtolower(parse_url($referer, PHP_URL_HOST)) == strtolower($this->request->host()))
            && !preg_match("/(user\/login|user\/register)/i", $referer)) {
            $url = $referer;
        }
        $this->view->assign('url', $url);
        $this->view->assign('title', __('Login'));
        return $this->view->fetch();
    }

    /**
     * 注销登录
     */
    function logout()
    {
        //注销本站
        $this->auth->logout();
        $synchtml = '';
        ////////////////同步到Ucenter////////////////
        if (defined('UC_STATUS') && UC_STATUS) {
            $uc = new \addons\ucenter\library\client\Client();
            $synchtml = $uc->uc_user_synlogout();
        }
        $this->success(__('Logout successful') . $synchtml, url('user/index'));
    }

    /**
     * 个人信息
     */
    public function profile()
    {
        $this->view->assign('title', __('Profile'));
        return $this->view->fetch();
    }

    /**
     * 修改密码
     */
    public function changepwd()
    {
        if ($this->request->isPost()) {
            $oldpassword = $this->request->post("oldpassword");
            $newpassword = $this->request->post("newpassword");
            $renewpassword = $this->request->post("renewpassword");
            $token = $this->request->post('__token__');
            $rule = [
                'oldpassword'   => 'require|length:6,30',
                'newpassword'   => 'require|length:6,30',
                'renewpassword' => 'require|length:6,30|confirm:newpassword',
                '__token__'     => 'token',
            ];

            $msg = [
            ];
            $data = [
                'oldpassword'   => $oldpassword,
                'newpassword'   => $newpassword,
                'renewpassword' => $renewpassword,
                '__token__'     => $token,
            ];
            $field = [
                'oldpassword'   => __('Old password'),
                'newpassword'   => __('New password'),
                'renewpassword' => __('Renew password')
            ];
            $validate = new Validate($rule, $msg, $field);
            $result = $validate->check($data);
            if (!$result) {
                $this->error(__($validate->getError()), null, ['token' => $this->request->token()]);
                return FALSE;
            }

            $ret = $this->auth->changepwd($newpassword, $oldpassword);
            if ($ret) {
                $synchtml = '';
                ////////////////同步到Ucenter////////////////
                if (defined('UC_STATUS') && UC_STATUS) {
                    $uc = new \addons\ucenter\library\client\Client();
                    $synchtml = $uc->uc_user_synlogout();
                }
                $this->success(__('Reset password successful') . $synchtml, url('user/login'));
            } else {
                $this->error($this->auth->getError(), null, ['token' => $this->request->token()]);
            }
        }
        $this->view->assign('title', __('Change password'));
        return $this->view->fetch();
    }

    // 个人中心
    public function personal(){
        $user_id = $this->auth->id;

        if($this->request->isPost()){
            $nickname = input('post.nickname');
            $gender = input('post.gender');
            $birthday = input('post.birthday');
            $profession = input('post.profession');
            $address = input('post.address');
            $address_detail = input('post.address_detail');
            $avatar = input('post.avatar');
            $token = input('poat.__token__');

            $data = array(
                'nickname' => $nickname,
                'gender' => $gender,
                'birthday' => $birthday,
                'profession' => $profession,
                'gender' => $gender,
                'address' => $address,
                'address_detail' => $address_detail,
                'avatar' => $avatar,
                '__token__' => $token,
            );

            $validate_result = $this->validate(
                $data,
                array(
                    'nickname' => 'require|max:20',
                    'birthday' => 'date',
                    'profession' => 'max:60',
                    'address_detail' => 'max:60',
                    '__token__' => 'token',
                ),
                array(
                    'nickname.require' => '昵称必填',
                    'nickname.max' => '昵称不能超过20个字符',
                    'birthday.date' => '请选择有效的生日格式：yyyy-mm-dd',
                    'profession.max' => '职业不能超过60个字符',
                    'address_detail.max' => '地址不能超过60个字符',
                )
            );

            if( true !== $validate_result){
                $this->error($validate_result);
            }

            unset($data['__token__']);
            if( false === Db::name('user')->where('id', $user_id)->update($data) ){
                $this->error('修改失败');
            }
            $this->success();
            
        }

        $userinfo = Db::name('user')->find($user_id);

        $this->assign('userinfo', $userinfo);
        return $this->fetch();
    }

    // 合伙人证书
    public function certificate(){

        return $this->fetch();
    }

    // 平台反馈
    public function feedback(){

        return $this->fetch();
    }

    // 我的活动
    public function activity(){
        $user_id = $this->auth->id;
        $list = Db::name('activity_enroll')->alias('ae')
            ->join('activity a', 'ae.activity_id=a.id')
            ->where('user_id', $user_id)
            ->order('ae.id desc')
            ->field('ae.id, a.title, ae.fullname, a.time, a.activity_status')
            ->paginate(10);

        $this->assign('list', $list);
        return $this->fetch();
    }

    public function cancleEnroll(){
        $user_id = $this->auth->id;
        $id = input('id');

        if( false !== Db::name("activity_enroll")->where(array('id'=>$id, 'user_id'=>$user_id))->delete()){
            die(json_encode(array('status'=>1)));
        } else {
            die(json_encode(array('status'=>0)));
        }
    }

}
