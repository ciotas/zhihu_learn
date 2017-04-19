<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Message extends Model
{
    use Notifiable;//站内信必须

    protected $fillable = ['from_user_id','to_user_id','body','dialog_id'];

    public function fromUser()
    {
        return $this->belongsTo(User::class,'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class,'to_user_id');
    }

    public function markAsRead()
    {
        if(is_null($this->read_at)){
            $this->forceFill(['has_read'=>'T','read_at'=>$this->freshTimestamp()])->save();
        }
    }


    /**
     * @param array $models
     * @return MessageCollection
     * 自定义collection
     */
    public function newCollection(array $models=[])
    {
        return new MessageCollection($models);
    }

    public function read()
    {
        return $this->has_read === 'T';
    }

    public function unRead()
    {
        return $this->has_read === 'F';
    }

    public function shouldAddUnreadClass()
    {
        if(user()->id === $this->from_user_id){
            return false;
        }

        return $this->unRead();

    }
}
