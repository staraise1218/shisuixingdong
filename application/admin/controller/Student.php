<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Db;

/**
 * 学生管理
 *
 * @icon fa fa-circle-o
 */
class Student extends Backend
{
    
    /**
     * Student模型对象
     * @var \app\admin\model\Student
     */
    protected $model = null;
    protected $relationSearch = true;
    // 快速搜索时执行查找的字段
    protected $searchFields = 'name';
    protected $admin_id;
    protected $group_id;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('Student');
        $this->view->assign("sexdataList", $this->model->getSexdataList());
        $this->view->assign("donationStatusList", $this->model->getDonationStatusList());
        $this->view->assign("statusList", $this->model->getStatusList());

        $this->admin_id = $this->auth->id;
        $group = Db::name('auth_group_access')->where('uid', $this->admin_id)->field('group_id')->find();
        $this->group_id = $group['group_id'];
        
        $this->assign('group_id', $this->group_id);
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            if($this->admin_id == 1){
                // $school_where = array();
                $groupwhere = array();
            } else {
                // $admin = Db::name('admin')->where('id', $this->admin_id)->field('school_id')->find();
                // $school_where = $admin['school_id'] ? array('school_id'=>$admin['school_id']) : array();
                
                // 如果是区域管理员，查找区域管理员所有下属学生
                if($this->group_id == 2){
                    $subadmin = Db::name('admin')->where('pid', $this->admin_id)->field('id')->select();
                    if($subadmin){
                        $subadminIds = array_column($subadmin, 'id');
                        array_push($subadminIds, $this->admin_id);
                        $groupwhere['admin_id'] = array('in', $subadminIds);
                    } else {
                        $groupwhere['admin_id'] = $this->admin_id;
                    }
                } else { // 如果是老师，查找该老师下的学生
                   $groupwhere['admin_id'] = $this->admin_id;
                }
            }
            $total = $this->model
                ->with('school')
                ->where($where)
                // ->where($school_where)
                ->where($groupwhere)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->with('school')
                ->where($where)
                // ->where($school_where)
                ->where($groupwhere)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }

        $this->assign('admin_id', $this->admin_id);
        return $this->view->fetch();
    }

    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");

            if ($params) {
                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = basename(str_replace('\\', '/', get_class($this->model)));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : true) : $this->modelValidate;
                        $this->model->validate($validate);
                    }

                    $params['admin_id'] = $this->auth->id;
                    $result = $this->model->allowField(true)->save($params);
                    if ($result !== false) {
                        $this->success();
                    } else {
                        $this->error($this->model->getError());
                    }
                } catch (\think\exception\PDOException $e) {
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }

        // 学生编号
        $number = $this->generateNumber();
        // 获取老师（管理员）所负责的学校
        if($this->admin_id > 1){
            $school  = Db::name('admin')->alias('admin')
                    ->join('school sch', 'admin.school_id=sch.id', 'left')
                    ->where('admin.id', $this->admin_id)
                    ->field('sch.id, sch.name')
                    ->find();

            $this->assign('school', $school);
        }

        $this->assign('admin_id', $this->admin_id);
        $this->assign('number', $number);
        return $this->view->fetch();
    }

    public function edit($ids = NULL)
    {
        $row = $this->model->get($ids);
        if (!$row)
            $this->error(__('No Results were found'));
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = basename(str_replace('\\', '/', get_class($this->model)));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : true) : $this->modelValidate;
                        $row->validate($validate);
                    }
                    $result = $row->allowField(true)->save($params);
                    if ($result !== false) {
                        $this->success();
                    } else {
                        $this->error($row->getError());
                    }
                } catch (\think\exception\PDOException $e) {
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }


        if($this->admin_id > 1){
            $school  = Db::name('school')
                    ->where('id', $row['school_id'])
                    ->field('id, name')
                    ->find();

            $this->assign('school', $school);
        }

        $this->assign('admin_id', $this->admin_id);
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

    // 生成学生编码
    private function generateNumber(){
        $number = date('Ymd').mt_rand(1000, 9999);
        $count = Db::name('student')->where('number', $number)->count();
        if($count) $this->generateNumber();

        return $number;
    }
    

}
