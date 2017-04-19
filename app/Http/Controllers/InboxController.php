<?php

namespace App\Http\Controllers;

use App\Repositories\InboxRepository;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    protected $inboxRepository;

    /**
     * InboxController constructor.
     */
    public function __construct(InboxRepository $inboxRepository)
    {
        $this->middleware('auth');
        $this->inboxRepository = $inboxRepository;
    }

    public function index()
    {
        $messages = $this->inboxRepository->getMessagesByGroup();
        return view('inbox.index',compact('messages'));
    }

    public function show($dialogId)
    {
        $messages = $this->inboxRepository->getFromMessages($dialogId);

        $messages->markAsRead();
        return view('inbox.show',compact('messages','dialogId'));
    }

    public function store($dialogId)
    {
        $message = $this->inboxRepository->getMessageByDialogId($dialogId);
        $toUserId = $message->from_user_id === user()->id ? $message->to_user_id : $message->from_user_id;

        $arr = [
            'from_user_id' => user()->id,
            'to_user_id' => $toUserId,
            'body' => request('body'),
            'dialog_id' => $dialogId
        ];
        $this->inboxRepository->create($arr);

        return back();
    }
}
