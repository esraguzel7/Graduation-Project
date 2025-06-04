<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail; // Mailable sınıfını dahil et
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class SendMail extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_mail_is_sent_successfully()
    {
        // Mail gönderimini sahtele (mock)
        Mail::fake();

        // Test için alıcı e-posta adresi
        $recipient = 'guvenfatih98@gmail.com';

        // Mail gönderme işlemi
        Mail::to($recipient)->send(new TestMail());

        // Mail'in gerçekten gönderildiğini doğrula
        Mail::assertSent(TestMail::class, function ($mail) use ($recipient) {
            return $mail->hasTo($recipient);
        });
    }
}
