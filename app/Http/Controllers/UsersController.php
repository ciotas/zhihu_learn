<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function avatar()
    {
        return view('users.avatar');
    }


    /**
     * @param Request $request
     * @return array
     * 上传头像
     */
    public function changeAvatar(Request $request)
    {
        $avatar = '/avatars/default.png';
        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $filename = md5(time().user()->id).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('avatars'),$filename);

            user()->avatar = '/avatars/'.$filename;
            user()->save();

            $avatar = user()->avatar;
        }

        return ['url'=>$avatar];
    }
}
