<?php
/**
 * Created by PhpStorm.
 * User: lindy
 * Date: 2017/4/9
 * Time: 下午8:48
 */

namespace App\Channels;


use Illuminate\Notifications\Notification;

class SendCloudChannel
{
    public function send($notifiable,Notification $notification)
    {
        $message = $notification->toSendCloud($notifiable);
    }
}