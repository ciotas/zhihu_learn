<?php

namespace App\Http\Controllers;

use App\Notifications\NewUserFollowNotification;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowersController extends Controller
{
    protected $userRepository;

    /**
     * FollowersController constructor.
     * @param $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function follower(Request $request)
    {
        $followed = $this->userRepository->doIFollowHim($request->get('user'));
        return response()->json(['followed'=>$followed]);
//        $user = $this->userRepository->byId($request->get('user'));
//        $followers = $user->followersUser()->pluck("followers_id")->toArray();
//        if(in_array(Auth::guard('api')->user()->id,$followers)){
//            return response()->json(['followed'=>true]);
//        }
//        return response()->json(['followed'=>false]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function follow(Request $request)
    {
        $userToFollow = $this->userRepository->byId($request->get('user'));
        $followed = user('api')->followThisUser($userToFollow->id);
        if(count($followed['attached']) > 0){
            $userToFollow->notify(new NewUserFollowNotification());//站内信
            $userToFollow->increment('followers_count');
            return response()->json(['followed'=>true]);
        }
        $userToFollow->decrement('followers_count');
        return response()->json(['followed'=>false]);
    }


}
