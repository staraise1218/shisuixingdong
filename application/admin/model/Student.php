<?php

namespace app\admin\model;

use think\Model;

class Student extends Model
{
    // 表名
    protected $name = 'student';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [
        'sexdata_text',
        'donation_status_text',
        'status_text'
    ];
    

    
    public function getSexdataList()
    {
        return ['1' => __('Sexdata 1'),'2' => __('Sexdata 2')];
    }     

    public function getDonationStatusList()
    {
        return ['1' => __('Donation_status 1'),'2' => __('Donation_status 2')];
    }     

    public function getStatusList()
    {
        return ['1' => __('Status 1'),'2' => __('Status 2')];
    }     


    public function getSexdataTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['sexdata'];
        $list = $this->getSexdataList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getDonationStatusTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['donation_status'];
        $list = $this->getDonationStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getStatusTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['status'];
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function school()
    {
        return $this->belongsTo('School', 'school_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }




}
