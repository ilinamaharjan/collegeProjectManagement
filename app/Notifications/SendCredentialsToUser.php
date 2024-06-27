<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendCredentialsToUser extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('verifyEmail',$this->data['id']);
        $mail =  (new MailMessage)
                    ->line('Username : '.$this->data['username'])
                    ->line('Password : '.$this->data['password'])
                    ->line('Company : '.$this->data['company']['name'])
                    // ->getHeaders()->addTextHeader('X-Tags', env('APP_NAME'))
                    ->action('Click here to verify email', $url);
        $mail->withSwiftMessage(function ($message) {
            $message->getHeaders()->addTextHeader('X-Tags', env('APP_NAME'));
        });
        return $mail;
    }


    /**
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
