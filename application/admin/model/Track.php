<?php

namespace app\admin\model;

use think\Model;

class Track extends Model
{
    // 表名
    protected $name = 'track';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'is_read_text'
    ];
    

    
    public function getIsReadList()
    {
        return ['0' => __('Is_read 0'),'1' => __('Is_read 1')];
    }     


    public function getIsReadTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['is_read'];
        $list = $this->getIsReadList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function student(){
        return $this->belongsTo('Student', 'student_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


}
