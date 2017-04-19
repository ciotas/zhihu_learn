<?php
/**
 * Created by PhpStorm.
 * User: lindy
 * Date: 2017/4/19
 * Time: 下午1:32
 */

namespace App;


use Illuminate\Database\Eloquent\Collection;

class MessageCollection extends Collection
{

    public function markAsRead()
    {
        $this->each(function ($message){
            if($message->to_user_id == user()->id){
                $message->markAsRead();
            }

        });
    }
}