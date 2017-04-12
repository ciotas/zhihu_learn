<?php
/**
 * Created by PhpStorm.
 * User: lindy
 * Date: 2017/3/31
 * Time: 下午9:50
 */

namespace App\Repositories;


use App\Question;
use App\Topic;

class QuestionRepository
{

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     * 根据question_id得到一条question以及关联的topics
     */
    public function byIdWithTopicsAndAnswers($id){
        return Question::with(['topics','answers'])->findOrFail($id);
//        return Question::with('topics')->findOrFail($id);
//        return Question::where('id',$id)->with(['topics','answers'])->first();
    }

    /**
     * @param array $attributes
     * @return mixed
     * 创建一条question
     */
    public function create(array $attributes){
        return Question::create($attributes);
    }

    /**
     * @param $topics
     * @return array
     * 创建topic
     */
    public function normalizeTopic($topics)
    {
        return collect($topics)->map(function ($topic){
            if(!is_numeric($topic)){
                $oldTopic = Topic::where('name',$topic)->first();
                if(!empty($oldTopic)){//查找到了
                    Topic::where('name',$topic)->increment('questions_count');
                    return $oldTopic->id;
                }else{
                    $newTopic = Topic::create(['name'=>$topic,'questions_count'=>1]);
                    return $newTopic->id;
                }
            }else{
                Topic::find($topic)->increment('questions_count');
                return (int) $topic;
            }
        })->toArray();
    }

    /**
     * @param $topics
     * @return array
     */
    public function updateNormalizeTopic($topics)
    {
        return collect($topics)->map(function ($topic){
            if(!is_numeric($topic)){
                $oldTopic = Topic::where('name',$topic)->first();
                if(!empty($oldTopic)){//查找到了
                    return $oldTopic->id;
                }else{
                    $newTopic = Topic::create(['name'=>$topic,'questions_count'=>1]);
                    return $newTopic->id;
                }
            }else{
                return (int) $topic;
            }
        })->toArray();
    }
    /**
     * @param $id
     * @return array
     */
    public function getTopicsIDbyQuestionsId($id){
        $question = $this->byIdWithTopicsAndAnswers($id);
        $arr = array();
        foreach ($question->topics as $topic){
            $arr[] = $topic->id;
        }
        return $arr;

    }

    /**
     * @param $diff
     */
    public function minusTopicQuestionsCount($topics){
          foreach ($topics as $topic) {
              Topic::find($topic)->decrement('questions_count');
          }
    }


    /**
     * @param $id
     * @return mixed
     * 根据id获取一条question
     */
    public function byId($id){
        return Question::find($id);
    }

    public function getQuestionsFeed(){
        return Question::published()->latest('updated_at')->with('user')->get();
    }
}