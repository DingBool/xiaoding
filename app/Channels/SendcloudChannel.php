<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-08
 * Time: 14:20
 */
namespace App\Channels;
use Illuminate\Notifications\Notification;

class SendcloudChannel
{
    public function send($notifiable,Notification $notification)
    {
        $message = $notification -> toSendcloud($notifiable);
    }
}