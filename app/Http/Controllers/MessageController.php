<?php

namespace App\Http\Controllers;

use App\Notifications\SendPrivateMsgNotification;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    protected $messageRepository;

    /**
     * MessageController constructor.
     * @param $messageRepository
     */
    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function store(Request $request)
    {
        $message = $this->messageRepository->create([
            'from_user_id' => Auth::guard('api')->user()->id,
            'to_user_id' => $request->get('user'),
            'body' => $request->get('body')
        ]);
        if($message){
            $message->notify(new SendPrivateMsgNotification());//站内信
            return response()->json(['status'=>true]);
        }

        return response()->json(['status'=>false]);
    }
}
