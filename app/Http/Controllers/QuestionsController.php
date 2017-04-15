<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{
    protected $questionRepository;
    /**
     * QuestionsController constructor.
     */
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->middleware('auth')->except(['index','show']);
        $this->questionRepository = $questionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = $this->questionRepository->getQuestionsFeed();
//        dd($questions);
        return view('questions.index',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        //先保存topics得到id数组
        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));
//        dd($topics);
        $data = [
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'user_id' => Auth::id()
        ];
        $question = $this->questionRepository->create($data);

        $question->topics()->attach($topics); //添加连接表
        return redirect()->route('question.show',[$question->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get （为一对多关系）或者 first （为一对一关系）
        $question = $this->questionRepository->byIdWithTopicsAndAnswers($id);

//        $question = Question::where('id',$id)->with('topics')->first();
        if(empty($question)){
            abort(404);
        }
        return view('questions.show',compact('question'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $question = $this->questionRepository->byId($id);
//        dd($question->body);
        if(Auth::user()->owns($question)){
            return view('questions.edit',compact('question'));
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestionRequest $request, $id)
    {
        //得到更新后的topics的id数组
        $topics = $this->questionRepository->updateNormalizeTopic($request->get('topics'));
        //得到原来的的topics的id数组
        $topicIds = $this->questionRepository->getTopicsIDbyQuestionsId($id);
        //看看少了哪些topics id
        $diff = array_diff($topicIds,$topics);
        if(!empty($diff)){
            //少了的减去
            $this->questionRepository->minusTopicQuestionsCount($diff);
        }
        $question = $this->questionRepository->byId($id);
        $question->update([
            'title' => $request->get('title'),
            'body' => $request->get('body'),
        ]);

        $question->topics()->sync($topics);//同步关联表

        return redirect()->route('question.show',[$question->id]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = $this->questionRepository->byId($id);
        if(Auth::user()->owns($question)){
            $question->delete();
            return redirect('/');
        }
        abort(403,'Forbidden');
    }


    public function follower(Request $request)
    {
        $user = Auth::guard('api')->user();
        $followed = $user->followed($request->get('question'));
        if($followed){
            return response()->json(['followed'=>true]);
        }
        return response()->json(['followed'=>false]);
    }

    public function follow(Request $request)
    {
        $user = Auth::guard('api')->user();
        $question = $this->questionRepository->byId($request->get('question'));
        $followed = $user->followThis($question->id);
        $isfollowed = true;
        if(count($followed['detached']) > 0){
            $question->decrement('followers_count');
            $isfollowed = false;
        }
        $question->increment('followers_count');

        return response()->json(['followed'=>$isfollowed]);

    }
}
