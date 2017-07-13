<?php
/*
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-05-25
 * Time: 14:42
 */

namespace App\Repositories;
use App\Question;
/*
 * Class QuestionRepository
 * @package App\Repositories
 */
class QuestionRepository
{
	/*
	 * @param $id
	 * @return mixed
	 */
	public function byIdWithTopicsAndAnswer($id)
	{
		return Question::where('id',$id)->with(['topics','answer'])->first();
	}
	
	/*
	 * @param $id
	 * @return mixed
	 */
	public function byIdWithTopicsAndAnswerName($id)
	{
		return Question::published()->latest('updated_at')->with(['user','topics','answer'])->where('id',$id)->first();
	}
	
	/*
	 * @param array $attributes
	 * @return mixed
	 */
	public function create(array $attributes)
	{
		return Question::create($attributes);
	}

	/*
	 * @param $id
	 * @return mixed
	 */
	public function byId($id)
	{
		return Question::find($id);
	}

	/*
	 * @param array $data
	 * @param $byId
	 * @param $topics
	 * @return mixed
	 */
	public function byIdupdate(array $data, $byId, $topics)
	{
		$question = $this->byId($byId);
		$question -> update($data);
		$data = $question -> topics() ->sync($topics);
		return $data;
	}
	
	/*
	 * @return mixed
	 */
	public function getQuestionsFeed()
	{
		return Question::published()->latest('updated_at')->with('user')->get();
	}

    public function getQuestionCommentById($id)
    {
        $question = Question::with('comments','comments.user')->where('id',$id)->first();
        return $question->comments;
	}
}