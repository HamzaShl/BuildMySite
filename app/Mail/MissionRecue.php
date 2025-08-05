<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MissionRecue extends Mailable
{
    use Queueable, SerializesModels;

    public $mission;
    public $dev;
    
    public function __construct($mission, $dev)
    {
        $this->mission = $mission;
        $this->dev = $dev;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle mission reçue !',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.mission-recue',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}