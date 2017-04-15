<?php
/**
 * Created by PhpStorm.
 * User: lindy
 * Date: 2017/4/15
 * Time: 下午2:49
 */

namespace App\Repositories;


use App\Topic;
use Illuminate\Support\Facades\Request;

class TopicRepository
{
    public function getTopicsForTagging(Request $request)
    {
        $topics = Topic::select(['id','name'])
            ->where('name','like','%'.$request->query('q').'%')->get();
        return $topics;
    }
}