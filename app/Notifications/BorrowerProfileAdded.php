<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BorrowerProfileAdded extends Notification
{
    use Queueable;

    protected $borrowerProfile;

    public function __construct($borrowerProfile)
    {
        $this->borrowerProfile = $borrowerProfile;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Profil Emprunteur Ajouté')
                    // Ajoute la vue personnalisée et passe les données nécessaires
                    ->view('emails.borrower_profile_added', [
                        'borrowerProfile' => $this->borrowerProfile
                    ])
                    ->from('bouncarlos@gmail.com', 'Gestionnaire Bibliothèque')
                    ->salutation('Cordialement, L\'équipe de la Bibliothèque 2SND');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
