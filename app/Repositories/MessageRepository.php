<?php
/**
 * Created by PhpStorm.
 * User: lindy
 * Date: 2017/4/14
 * Time: 下午10:25
 */

namespace App\Repositories;


use App\Message;

class MessageRepository
{
    public function create(array $attributes)
    {
        return Message::create($attributes);
    }
}