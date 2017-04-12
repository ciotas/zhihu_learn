<?php
/**
 * Created by PhpStorm.
 * User: lindy
 * Date: 2017/4/3
 * Time: 上午11:07
 */

namespace App\Repositories;


use App\Answer;

class AnswerRepository
{
    public function create(array $attributes){
        return Answer::create($attributes);
    }
}