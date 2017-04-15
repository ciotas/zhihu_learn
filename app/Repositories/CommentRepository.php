<?php
/**
 * Created by PhpStorm.
 * User: lindy
 * Date: 2017/4/15
 * Time: 上午11:00
 */

namespace App\Repositories;


use App\Comment;

class CommentRepository
{
    public function create(array $attributes)
    {
        return Comment::create($attributes);
    }
}