<?php

namespace App\Listeners;

use App\Events\SendRegisterEmailEvent;
use App\Mailer\UserMailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendRegisterEmailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendRegisterEmailEvent  $event
     * @return void
     */
    public function handle(SendRegisterEmailEvent $event)
    {
        (new UserMailer())->RegisterEmail($event->user->name,$event->user->email,$event->user->confirmation_token);
    }
}
