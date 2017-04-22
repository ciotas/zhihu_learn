<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function index()
    {
        $user = user();
        return view('notifications.index',compact('user'));
    }

    public function show(DatabaseNotification $notification)
    {
        $notification->markAsRead();//自带方法

        return redirect(request('redirect_url'));
    }

}
