<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerRepository;

/*
 * Class VotesController
 * @package App\Http\Controllers
 */
class VotesController extends Controller
{
    /*
     * @var
     * @var AnswerRepository
     */
    protected $u_id;
    protected $answer;

    /*
     * VotesController constructor.
     * @param AnswerRepository $answer
     */
    public function __construct(AnswerRepository $answer)
    {
        $this->answer = $answer;
    }

    /*
     * @return mixed
     */
    public function u_id()
    {
        if($this->u_id == null)
        {
            $this->u_id = user('api');
        }
        return $this->u_id;
    }

    /*
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function users($id)
    {
        if($this->u_id()->hasVotedFor($id))
        {
            return response()->json(['voted'=>true]);
        }
        return response()->json(['voted'=>false]);
    }

    /*
     * @return \Illuminate\Http\JsonResponse
     */
    public function vote()
    {
        $answer = $this->answer->byId(request('answer'));
        $vote = $this->u_id()->voteFoi(request('answer'));
        if(count($vote['attached']) > 0)
        {
            $answer -> increment('votes_count');
            return response()->json(['voted'=>true]);
        }
        $answer -> decrement('votes_count');
        return response()->json(['voted'=>false]);
    }
}