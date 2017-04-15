<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'title','body','user_id', 'comments_count','followers_count','answers_count','close_comment','is_hidden'
    ];

    public function isHidden()
    {
        return $this->is_hidden === 'T';
    }

    public function topics(){
        return $this->belongsToMany(Topic::class)->withTimestamps();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function followers(){
        return $this->belongsToMany(User::class,'user_question')->withTimestamps();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }


    public function scopePublished($query){
        $query->where('is_hidden','F');
    }
}
