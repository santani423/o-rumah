<?php

namespace App\Mail;


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BankEmailLelang extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    protected $filePath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details, $filePath)
    {
        $this->details = $details;
        $this->filePath = $filePath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('O-Rumah Pengajuan Lelang')
            ->view('emails.lelang')
            ->attach($this->filePath, [
                'as' => 'ktp.png',
                'mime' => 'image/png',
            ]);
    }
}
