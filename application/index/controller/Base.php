<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Db;

class Base extends Frontend
{

    public function _initialize()
    {
        parent::_initialize();

        $user_id = $this->auth->id;
        
        $is_message = 0;

        if($user_id){
            $is_track_read = Db::name('track')
                ->where('donor', $user_id)
                ->where('is_read', 0)
                ->count();

            $is_situation_read = Db::name('student_situation')
                ->where('donor', $user_id)
                ->where('is_read', 0)
                ->count();
            if($is_track_read || $is_situation_read) $is_message = 1;
        }
        $this->assign('is_message', $is_message);
    }
} 