<?php

namespace App\Http\Controllers;

use App\Repositories\VoteRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VotesController extends Controller
{
    protected $answerRepository;

    /**
     * VotesController constructor.
     * @param $answerRepository
     */
    public function __construct(VoteRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    public function users(Request $request)
    {
        $user = Auth::guard('api')->user();
        return response()->json(['voted'=>$user->hasVoteFor($request->get('id'))]);
    }

    public function vote(Request $request)
    {
        $answer = $this->answerRepository->byId($request->get('answer'));
        $voted = Auth::guard('api')->user()->voteFor($request->get('answer'));
        if(count($voted['attached']) > 0){
            $answer->increment('votes_count');
            return response()->json(['voted'=>true]);
        }
        $answer->decrement('votes_count');
        return response()->json(['voted'=>false]);
    }
}
