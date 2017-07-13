<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-08
 * Time: 20:51
 */

namespace App\Mailer;


use App\User;
use Illuminate\Support\Facades\Auth;

/*
 * Class UserMailer
 * @package App\Mailer
 */
class UserMailer extends Mailer
{
    /*
     * @var
     */
    protected $u_name;

    /*
     * @return mixed
     */
    private function u_name()
    {
        if($this->u_name == null)
        {
            $this->u_name = Auth::guard('api')->user()->name;
        }
        return $this->u_name;
    }

    /*
     * @param $email
     */
    public function followNotifyEmail($email)
    {
        $data = ['url' => 'xiaoding.bid','name' => $this->u_name() ];
        $this->sendTo('xdzhifu_app_new_user_follow',$email,$data);
    }

    /*
     * @param $email
     * @param $token
     */
    public function passwordReset($email, $token)
    {
        $data = ['url' => url('password/reset',$token)];
        $this->sendTo('xdzhifu_app_register_reset',$email,$data);
    }

    /*
     * @param User $user
     */
    public function welcome(User $user)
    {
        $data = ['url' => route('email.verify',['token'=>$user->confirmation_token]),'name'=>$user->name];
        $this->sendTo('xdzhifu_app_register',$user->email,$data);
    }
}