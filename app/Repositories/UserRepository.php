<?php
/**
 * Created by PhpStorm.
 * User: lindy
 * Date: 2017/4/8
 * Time: 上午11:02
 */

namespace App\Repositories;

use App\Follower;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserRepository
{

    public function byId($id)
    {
        return User::find($id);
    }

    public function doIFollowHim($id)
    {
        $follower = Follower::where(['followed_id'=>$id,'followers_id'=>Auth::guard('api')->user()->id])->first();
        if(count($follower) > 0){
            return true;
        }
        return false;
    }

}