<?php

namespace App\Notifications;

use App\Mailer\UserMailer;
use App\Channels\SendcloudChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;


class NewUserFollowNotification extends Notification
{
    use Queueable;
    /*
     * @var
     */
    protected $u_name;

    /*
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /*
     * @param $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database',SendcloudChannel::class];
    }

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

    /**
     * @param $notifiable
     */
    public function toSendcloud($notifiable)
    {
        (new UserMailer())->followNotifyEmail($notifiable->email);
    }

    /*
     * @param $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'name' => $this->u_name()
        ];
    }

    /*
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /*
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
