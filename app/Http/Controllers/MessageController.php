<?php

namespace App\Http\Controllers;

use App\Repositories\MessageRepositories;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    protected $messages;
    protected $u_id;

    /**
     * MessageController constructor.
     * @param $message
     */
    public function __construct(MessageRepositories $message)
    {
        $this->messages = $message;
    }

    public function getUid()
    {
        if($this->u_id == null)
        {
            $this->u_id = user('api');
        }
        return $this->u_id;
    }

    public function store()
    {
        $message = $this->messages->create([
            'to_user_id' => request('user'),
            'form_user_id' => $this->getUid()->id,
            'body' => request('body'),
            'dialog_id' => time().Auth::id()
        ]);
        if(!$message)
        {
            return response()->json(['status' => false]);
        }
        return response()->json(['status'=>true]);
    }
}
