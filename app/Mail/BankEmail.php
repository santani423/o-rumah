<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BankEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    protected $files;

    /**
     * Create a new message instance.
     *
     * @param array $details
     * @param array|null $files
     * @return void
     */
    public function __construct($details, $files = [])
    {
        $this->details = $details;
        $this->files = $files;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->subject('O-Rumah')
                      ->view('emails.kpr')
                      ->with('details', $this->details);

        foreach ($this->files as $file) {
            $email->attach($file);
        }

        return $email;
    }
}

