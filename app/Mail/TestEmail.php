<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $userName;
    protected $userEmail;

    /**
     * Crée une nouvelle instance de message.
     *
     * @param string $userName
     * @param string $userEmail
     */
    public function __construct($userName, $userEmail)
    {
        $this->userName = $userName;
        $this->userEmail = $userEmail;
    }

    /**
     * Récupère l'enveloppe du message.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bienvenue sur notre site, ' . $this->userName,
        );
    }

    /**
     * Récupère la définition du contenu du message.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.test', // Assurez-vous d'avoir une vue `emails.test`
            with: [
                'userName' => $this->userName,
                'userEmail' => $this->userEmail,
            ],
        );
    }

    /**
     * Récupère les pièces jointes pour le message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
