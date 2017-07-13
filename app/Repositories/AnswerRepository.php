<?php
/*
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-05-26
 * Time: 11:01
 */

namespace App\Repositories;


use App\Answer;

/*
 * Class AnswerRepository
 * @package App\Repositories
 */
class AnswerRepository
{
	/*
	 * @param array $attributes
	 * @return mixed
	 */
	public function create(array $attributes)
	{
		return Answer::create($attributes);
	}

    /*
     * @param $id
     * @return mixed
     */
    public function byId($id)
    {
        return Answer::find($id);
	}

    /*
     * @param $id
     * @return mixed
     */
    public function getAnswerCommentsById($id)
    {
        $answer = Answer::with('comments','comments.user')->where('id',$id)->first();
        return $answer->comments;
    }
}