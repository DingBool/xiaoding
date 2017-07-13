<?php

namespace App\Http\Controllers;

use App\Notifications\NewMessageNotification;
use App\Repositories\MessageRepositories;
use Illuminate\Http\Request;

/**
 * Class InboxController
 * @package App\Http\Controllers
 */
class InboxController extends Controller
{
    /**
     * @var MessageRepositories
     */
    protected $message;

    /**
     * InboxController constructor.
     */
    public function __construct(MessageRepositories $message)
    {
        $this->message = $message;
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $messages = $this->message->getAllMessages();
        return view('inbox.index',['messages' => $messages->groupBy('dialog_id')]);
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function show($dialogId)
    {
        $messages = $this->message->getDialogMessagesByDialogId($dialogId);
        $messages->markAsRead();
        return view('inbox.show',compact('messages','dialogId'));
    }

    /**
     * @param Request $request
     * @param $dialogId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $dialogId)
    {
        $message = $this->message->getSingleMessageByDialogId($dialogId);
        $toUserId = $message->form_user_id === user()->id ? $message->to_user_id : $message->form_user_id;
        $newMessage = $this->message->create(
            [
                'form_user_id' => user()->id,
                'to_user_id' => $toUserId,
                'body' => $request->input('body'),
                'dialog_id' => $dialogId
            ]
        );
        $newMessage->toUser->notify(new NewMessageNotification($newMessage));
        return back();
    }
}
