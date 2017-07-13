<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-14
 * Time: 12:32
 */

namespace App;

use Illuminate\Database\Eloquent\Collection;

class MessageController extends Collection
{
    public function markAsRead()
    {
        $this->each(function($message)
        {
            if($message->to_user_id === user()->id)
            {
                $message->markAsRead();
            }
        });
    }
}