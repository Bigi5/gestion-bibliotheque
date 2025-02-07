<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

class BorrowConfirmation extends Notification
{
    use Queueable;

    protected $borrowerProfile;
    protected $book;

    public function __construct($borrowerProfile, $book)
    {
        $this->borrowerProfile = $borrowerProfile;
        $this->book = $book;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Vérifie que tu as bien la date d'emprunt (borrow_date) de ton livre
        $borrowDate = $this->book->borrow_date; // Assurez-vous que $book a la propriété borrow_date
        $dueDate = Carbon::parse($borrowDate)->addDays(13); // Calculer la date limite de retour
    
        return (new MailMessage)
                    ->from('gestionnaire@bibliotheque.com', 'Gestionnaire bibliothèque') // Spécifie l'expéditeur
                    ->subject('Confirmation de prêt de livre')
                    ->view('emails.borrowed_book_notification', [
                        'borrowerProfile' => $this->borrowerProfile,
                        'book' => $this->book,
                        'borrowDate' => $borrowDate,  // Passer borrowDate à la vue
                        'dueDate' => $dueDate,        // Passer dueDate à la vue
                    ]);
    }
    



    public function toArray($notifiable)
    {
        return [
            // Données supplémentaires si nécessaire
        ];
    }
}
