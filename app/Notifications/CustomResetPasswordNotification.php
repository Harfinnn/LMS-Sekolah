<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPasswordNotification extends Notification
{
    /**
     * Token reset (bukan URL).
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Build URL dengan cara yang aman (relative path + url())
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset()
        ], false));

        // Data untuk blade email
        $data = [
            'url' => $url,
            'user' => $notifiable,
            'brand_color' => '#4ADE80',
            'sender_name' => 'Tim Support E-learning',
        ];

        return (new MailMessage)
            ->subject('Reset Password — Tim Support E-learning')
            ->view('emails.reset-password', $data);
    }
}
