<?php
/**
 * Created by PhpStorm.
 * User: lindy
 * Date: 2017/4/11
 * Time: 下午10:17
 */

namespace App\Mailer;


use Illuminate\Support\Facades\Auth;

class UserMailer extends Mailer
{
    public function followNotifyEmail($email)
    {
        $data = [
            'url' => config('url'),
            'name' => Auth::guard('api')->user()->name
        ];
        $this->sendTo('zhihu_app_new_user_follow',$email,$data);
    }

    public function RegisterEmail($name,$email,$confirmation_token)
    {
        $data = [
            'url' => route('email.verify',['token'=>$confirmation_token]),
            'name' => $name,
        ];
        $this->sendTo('welcome',$email,$data);
    }

    public function passwordReset($email,$token)
    {
        $data = [
            'url' => route('password.reset', $token),
        ];
        $this->sendTo('reset_password',$email,$data);

    }
}