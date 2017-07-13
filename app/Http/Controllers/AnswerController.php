<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Repositories\AnswerRepository;
use Illuminate\Support\Facades\Auth;

/*
 * Class AnswerController
 * @package App\Http\Controllers
 */
class AnswerController extends Controller
{
	/*
	 * @var AnswerRepository
	 * @var int|null
	 */
	protected $answerRepository;
	protected $u_id;
	
	/*
	 * AnswerController constructor.
	 * @param AnswerRepository $answerRepository
	 */
	public function __construct(AnswerRepository $answerRepository)
	{
		$this->answerRepository = $answerRepository;
	}
	
	/*
	 * @return int|null
	 */
	private function getUid()
	{
		if($this->u_id==null)
		{
			$this->u_id = Auth::id();
		}
		return $this->u_id;
	}

	/*
	 * @param Request $request
	 * @param $question
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(StoreAnswerRequest $request, $question)
	{
		if($this->getUid() != null)
		{
			$answer = $this->answerRepository->create([
				'question_id' => $question,
				'user_id'	  => $this->getUid(),
				'body'		  => $request->get('body'),
			]);
			$answer->question()->increment('answers_count');
		}
		return back();
	}
}
