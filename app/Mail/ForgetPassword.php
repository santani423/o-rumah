<?php

namespace App\Mail;


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;

class ForgetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }
    public function content(): Content
    {
        return new Content(
            view: 'emails.forgetPassword',
        );
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function attachments(): array
    {
        return [];
    }
}
