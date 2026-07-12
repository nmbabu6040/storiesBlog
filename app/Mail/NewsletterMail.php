<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable
{
    use SerializesModels;

    public $subjectText;
    public $body;

    public function __construct($subjectText, $body)
    {
        $this->subjectText = $subjectText;
        $this->body = $body;
    }

    public function build()
    {
        return $this
            ->subject($this->subjectText)
            ->view('emails.newsletter');
    }
}
