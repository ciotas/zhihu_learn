<?php

namespace App;

use App\Events\SendRegisterEmailEvent;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','confirmation_token','is_active','api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $events = [
        'created' => SendRegisterEmailEvent::class
    ];

    public function owns(Model $model)
    {
        return $this->id === $model->user_id;
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function follows(){
        return $this->belongsToMany(Question::class,'user_question')->withTimestamps();
    }

    public function followThis($question)
    {
        return $this->follows()->toggle($question);//适用belongToMany
    }

    public function followed($question)
    {
        return $this->follows()->exists('question_id',$question);
//        return $this->follows()->where('question_id',$question)->count();
    }

    public function followers(){
        return $this->belongsToMany(self::class,'followers','followers_id','followed_id')->withTimestamps();
    }
    public function followersUser(){
        return $this->belongsToMany(self::class,'followers','followed_id','followers_id')->withTimestamps();
    }

    public function followThisUser($user){
        return $this->followers()->toggle($user);//适用belongToMany
    }

    public function votes()
    {
        return $this->belongsToMany(Answer::class,'votes')->withTimestamps();
    }

    public function voteFor($answer)
    {
        return $this->votes()->toggle($answer);
    }

    public function hasVoteFor($answer)
    {
        return $this->votes()->exists('answer_id',$answer);
    }

    public function messages()
    {
        return $this->hasMany(Message::class,'to_user_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
    }

}
