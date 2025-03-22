<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends BaseVerifyEmail
{
    public function toMail($notifiable)
    {
        $verificationUrl = URL::temporarySignedRoute(
            'authorization.verification.verify',
            now()->addMinutes(60),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );

        return (new MailMessage)
            ->subject('E-posta Adresinizi Doğrulayın')
            ->greeting('Merhaba ' . $notifiable->name . '!')
            ->line('Lütfen aşağıdaki butona tıklayarak e-posta adresinizi doğrulayın.')
            ->action('E-posta Doğrula', $verificationUrl)
            ->line('Eğer bu işlemi siz yapmadıysanız, herhangi bir işlem yapmanıza gerek yok.');
    }
}

