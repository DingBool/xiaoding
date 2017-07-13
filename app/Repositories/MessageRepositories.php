<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-12
 * Time: 12:22
 */

namespace App\Repositories;
use App\Messages;


/**
 * Class MessageRepositories
 * @package App\Repositories
 */
class MessageRepositories
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return Messages::create($attributes);
    }

    /**
     * @return mixed
     */
    public function getAllMessages()
    {
        return Messages::where('to_user_id',user()->id)->orwhere('form_user_id',user()->id)->with(['fromUser' => function ($query)
        {
            return $query->select(['id','name','avatar']);
        },'toUser' => function ($query)
        {
            return $query->select(['id','name','avatar']);
        }])->latest()->get();
    }

    /**
     * @param $dialogId
     * @return mixed
     */
    public function getDialogMessagesByDialogId($dialogId)
    {
        return Messages::where('dialog_id',$dialogId)->with(['fromUser' => function ($query)
        {
            return $query->select(['id','name','avatar']);
        },'toUser' => function ($query)
        {
            return $query->select(['id','name','avatar']);
        }])->get();    //降
    }

    /**
     * @param $dialogId
     * @return mixed
     */
    public function getSingleMessageByDialogId($dialogId)
    {
        return Messages::where('dialog_id',$dialogId)->first();
    }
}