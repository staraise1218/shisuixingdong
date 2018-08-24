<?php

namespace app\admin\model;

use think\Model;

class Donation extends Model
{
    // 表名
    protected $name = 'donation';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'paytime_text',
        'paystatus_text',
        'expirytime_text',
        'sex_text'
    ];
    

    
    public function getPaystatusList()
    {
        return ['0' => __('Paystatus 0'),'1' => __('Paystatus 1'),'2' => __('Paystatus 2'),'3' => __('Paystatus 3')];
    }     

    public function getSexList()
    {
        return ['1' => __('Sex 1'),'2' => __('Sex 2')];
    }     


    public function getPaytimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['paytime'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getPaystatusTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['paystatus'];
        $list = $this->getPaystatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getExpirytimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['expirytime'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getSexTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['sex'];
        $list = $this->getSexList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    protected function setPaytimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setExpirytimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    public function student(){
        return $this->belongsTo('Student', 'student_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }

    public function user(){
        return $this->belongsTo('User', 'user_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


}
