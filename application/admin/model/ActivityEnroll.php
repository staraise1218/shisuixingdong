<?php

namespace app\admin\model;

use think\Model;

class ActivityEnroll extends Model
{
    // 表名
    protected $name = 'activity_enroll';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'sex_text',
        'people_num_text'
    ];
    

    
    public function getSexList()
    {
        return ['0' => __('Sex 0'),'1' => __('Sex 1')];
    }     

    public function getPeopleNumList()
    {
        return ['2' => __('People_num 2')];
    }     


    public function getSexTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['sex'];
        $list = $this->getSexList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getPeopleNumTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['people_num'];
        $list = $this->getPeopleNumList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}
