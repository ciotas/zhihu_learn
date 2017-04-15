<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        foreach($user->notifications as $notification){
            echo snake_case(class_basename($notification->type));
            echo "\r\n";
        }
        dd();
        return view('notifications.index',compact('user'));
    }
}
