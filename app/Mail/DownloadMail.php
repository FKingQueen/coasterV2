<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class DownloadMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    public $filePath;

    public function __construct($details, $filePath)
    {
        $this->details = $details;
        $this->filePath = $filePath; // Store filePath correctlys
    }

    public function build()
    {
        $email = $this->subject($this->details['subject'])
                        ->view('emails.download')
                        ->with(['bodyContent' => $this->details['body']]);;

        foreach($this->filePath as $attachFile) {
            $email->attach($attachFile);
        }

        return $email;
    }
}