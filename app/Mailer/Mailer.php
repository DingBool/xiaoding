<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-08
 * Time: 20:46
 */

namespace App\Mailer;


use Illuminate\Support\Facades\Mail;
use Naux\Mail\SendCloudTemplate;

/*
 * Class Mailer
 * @package App\Mailer
 */
class Mailer
{
    /*
     * @param $template
     * @param $email
     * @param array $data
     */
    protected function sendTo($template, $email, array $data)
    {
        $content = new SendCloudTemplate($template, $data);
        Mail::raw($content, function ($message) use($email) {
            $message->from('foo@example.com', '小丁');
            $message->to($email);
        });
    }
}