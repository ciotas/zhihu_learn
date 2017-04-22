<?php
/**
 * Created by PhpStorm.
 * User: lindy
 * Date: 2017/4/17
 * Time: 下午10:37
 */

namespace App\Repositories;


use App\Message;

class InboxRepository
{
    public function getMessagesByGroup()
    {
        $messages = Message::where('to_user_id',user()->id)
            ->orWhere('from_user_id',user()->id)
            ->with(['fromUser'=>function($query){
                return $query->select(['id','name','avatar']);
            },'toUser'=>function($query){
                return $query->select(['id','name','avatar']);
            }])->latest()->get();
        return $messages->groupBy('to_user_id');
    }

    public function getFromMessages($dialogId)
    {
        $messages = Message::where('dialog_id',$dialogId)
            ->with(['fromUser'=>function($query){
                return $query->select(['id','name','avatar']);
            },'toUser'=>function($query){
                return $query->select(['id','name','avatar']);
            }])->latest()->get();
        return $messages;
    }

    public function getMessageByDialogId($dialogId)
    {
        return Message::where('dialog_id',$dialogId)->first();
    }

    public function create(array $arr)
    {
        return Message::create($arr);
    }

}