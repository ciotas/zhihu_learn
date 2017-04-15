<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerRepository;
use App\Repositories\CommentRepository;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    protected $answerReponsitory;
    protected $questionReponsitory;
    protected $commentReponsitory;

    /**
     * CommentsController constructor.
     * @param $answerReponsitory
     * @param $questionReponsitory
     * @param $commentReponsitory
     */
    public function __construct(AnswerRepository $answerReponsitory,QuestionRepository $questionReponsitory,CommentRepository $commentReponsitory)
    {
        $this->answerReponsitory = $answerReponsitory;
        $this->questionReponsitory = $questionReponsitory;
        $this->commentReponsitory = $commentReponsitory;
    }


    public function answer($id)
    {
        return $this->answerReponsitory->getAnswerCommentsById($id);
    }

    public function question($id)
    {
        return $this->questionReponsitory->getQuestionCommentsById($id);

    }

    public function store(Request $request)
    {
        $model = $this->getModelNameFromType($request->get('type'));
        return $this->commentReponsitory->create([
            'commentable_id'   => $request->get('model'),
            'commentable_type' => $model,
            'user_id'          => Auth::guard('api')->user()->id,
            'body'             => $request->get('body')
        ]);

    }

    private function getModelNameFromType($type)
    {
        return $type === 'question' ? 'App\Question' : 'App\Answer';
    }
}
