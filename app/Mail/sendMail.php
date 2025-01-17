<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class sendMail extends Mailable
{
    use Queueable, SerializesModels;
    private $data;

    /**
     * Create a new message instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        Log::info($this->data);

        Log::info(env("MAIL_DEFAULT_TO_ADDRESS"));
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nuova email dal form di contatto del sito',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.sendmail',
            with: [
                'NomeMittente' => $this->data['name'],
                'CognomeMittente' => $this->data['surname'],
                'EmailMittente' => $this->data['mail'],
                'TestoMessaggioMittente' => $this->data['message'],
            ],
        );
    }
}
