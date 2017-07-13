<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Repositories\QuestionRepository;
use App\Topic;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{
    protected $questionRepository;
    protected $u_id;
    /*
     * Verify that the user has landed
     *
     * @return true or flash
     * */
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->middleware('auth')->except(['index','show']);
        $this->questionRepository = $questionRepository;
    }

    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = $this->questionRepository->getQuestionsFeed();
        return view('questions.index',compact('questions'));
    }

    /*
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.make');
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        $datas = $request->all();
        $topics = $this->normalizeTopic($datas['topics']);
        $data = [
            'title' => $datas['title'],
            'body'  => $datas['body'],
            'user_id' => $this->getUid(),
        ];
        $question = $this->questionRepository->create($data);
        $question->topics()->attach($topics);
        return redirect()->route('questions.show',[$question->id]);
    }

    /*
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        $question = $this->questionRepository->byIdWithTopicsAndAnswer($id);
//        $questions = $this->questionRepository->getQuestionsFeed($id);
        $question = $this->questionRepository->byIdWithTopicsAndAnswerName($id);
        return view('questions.show',compact('question'));
    }

    /*
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = $this->questionRepository->byId($id);
        if(Auth::user()->owns($question))
        {
            return view('questions.edit',compact('question'));
        }
        return back();
    }

    /*
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestionRequest $request, $id)
    {
        $requests = $request->all();
        $datas = [
            'title' => $requests['title'],
            'body' => $requests['body'],
        ];
//        $question = $this->questionRepository->byId($id);
        $topics = $this->normalizeTopic($requests['topics']);
        $this->questionRepository->byIdupdate($datas,$id,$topics);
        return redirect()->route('questions.show',[$id]);
    }

    /*
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = $this->questionRepository->byId($id);
        if(Auth::user()->owns($question))
        {
            $question->delete();
            return redirect('/');
        }
        abort('403','Forbidden');
    }
    
    /*
     * Deal with issues related to publishing, many to many relationships.
     *
     * @param array $topics
     * @return array
     * */
    public function normalizeTopic(array $topics)
    {
        return collect($topics)->map(function($topic)
        {
            if(is_numeric($topic))
            {
                Topic::find($topic)->increment('questions_count');
                return (int) $topic;
            }
//            $newTopic = Topic::create(['name' => $topic,'questions_count' => 1]);
//            return $newTopic->id;
        })->toArray();
    }

}
