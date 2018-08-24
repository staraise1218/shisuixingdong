<?php

namespace app\admin\model;

use think\Model;

class StudentSituation extends Model
{
    // 表名
    protected $name = 'student_situation';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [

    ];
    

    

    public function student(){
        return $this->belongsTo('Student', 'student_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }







}
