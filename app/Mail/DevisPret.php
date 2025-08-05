<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DevisPret extends Mailable
{
    use Queueable, SerializesModels;

    public $devis;
    public $entreprise;
    
    public function __construct($devis, $entreprise)
    {
        $this->devis = $devis;
        $this->entreprise = $entreprise;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre devis est prêt !',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.devis-pret',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}