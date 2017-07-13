<?php

namespace App\Http\Controllers;

use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/**
 * Class QuestionFollowController
 * @package App\Http\Controllers
 */
class QuestionFollowController extends Controller
{
    /**
     * @var QuestionRepository
     */
    protected $question;

	/*
	 * @param $question
	 * @return \Illuminate\Http\RedirectResponse
	 * QuestionFollowController constructor.
	 */
	public function __construct(QuestionRepository $question)
	{
		$this->middleware('auth');
		$this->question = $question;
	}

	/*
	 * @param $question
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function follow($question)
	{
//        user()->followsThis($question);
        Auth::user()->followsThis($question);
		return back();
	}

    public function follower(Request $request)
    {
        $requests = $request->all();
        $followed = user('api')->followed($requests['question']);
        if($followed)
        {
            return response()->json(['followed'=>true]);
        }
        return response()->json(['followed'=>false]);
	}

    public function followerThisQuestion(Request $request)
    {
        $requests = $request->all();
        $question = $this->question->byId($requests['question']);
        $followed = user('api')->followsThis($question->id);
        if(count($followed['detached']) > 0)
        {
            $question->decrement('followers_count');
            return response()->json(['followed'=>false]);
        }
        $question->increment('followers_count');
        return response()->json(['followed'=>true]);
	}
}
