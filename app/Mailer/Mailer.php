<?php
/**
 * Created by PhpStorm.
 * User: lindy
 * Date: 2017/4/11
 * Time: 下午10:09
 */

namespace App\Mailer;


use Illuminate\Support\Facades\Mail;
use Naux\Mail\SendCloudTemplate;

class Mailer
{
    public function sendTo($template,$email,array $data)
    {
        $content = new SendCloudTemplate($template, $data);

        Mail::raw($content, function ($message) use ($email) {
            $message->from(config('app.mail'), config('app.name'));
            $message->to($email);
        });
    }
}