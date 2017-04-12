<?php
/**
 * Created by PhpStorm.
 * User: lindy
 * Date: 2017/4/12
 * Time: 下午4:59
 */

namespace App\Repositories;


use App\Answer;

class VoteRepository
{
    public function byId($id)
    {
        return Answer::find($id);
    }
}