<?php

namespace App\Notifications;

use App\Channels\SendCloudChannel;
use App\Mailer\UserMailer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;

class NewUserFollowNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database',SendCloudChannel::class];
    }


    public function toDatabase($notifiable)
    {
        return [

            'name' => Auth::guard('api')->user()->name,
        ];

    }

    /**
     * @param $notifiable
     * 发送通知邮件
     */
    public function toSendCloud($notifiable){
        (new UserMailer())->followNotifyEmail($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
