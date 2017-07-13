<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerRepository;
use App\Repositories\CommentRepository;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class CommentsController
 * @package App\Http\Controllers
 */
class CommentsController extends Controller
{
    /**
     * @var
     */
    protected $u_id;
    protected $answer;
    protected $question;
    protected $comment;

    /**
     * CommentsController constructor.
     * @param $u_id
     * @param $answer
     * @param $question
     * @param $comment
     */
    public function __construct(AnswerRepository $answer,QuestionRepository $question,CommentRepository $comment)
    {
        $this->answer = $answer;
        $this->question = $question;
        $this->comment = $comment;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function answer($id)
    {
        return $this->answer->getAnswerCommentsById($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function question($id)
    {
        return $this->question->getQuestionCommentById($id);
    }

    /**
     * @return mixed
     */
    private function getUid()
    {
        if($this->u_id == null)
        {
            $this->u_id = user('api');
        }
        return $this->u_id;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $model = $this->getModelNameFormType($data['type']);
        return $this->comment->create(
            [
                'commentable_id' => $data['model'],
                'commentable_type' => $model,
                'user_id' => $this->getUid()->id,
                'body' => $data['body']
            ]
        );
    }

    /**
     * @param $type
     * @return string
     */
    private function getModelNameFormType($type)
    {
        return $type === 'question' ? 'App\Question' : 'App\Answer';
    }
}
