<?php

namespace App\Http\Controllers;

use App\Repositories\TopicRepository;
use Illuminate\Http\Request;

class TopicsController extends Controller
{
    protected $topicReponsitory;

    /**
     * TopicsController constructor.
     * @param $topicReponsitory
     */
    public function __construct(TopicRepository $topicReponsitory)
    {
        $this->topicReponsitory = $topicReponsitory;
    }

    public function index(Request $request)
    {
        $this->topicReponsitory->getTopicsForTagging($request);

    }

}
