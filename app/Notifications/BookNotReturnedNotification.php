<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class BookNotReturnedNotification extends Notification
{
    // Les données que vous souhaitez inclure dans la notification
    private $book;

    public function __construct($book)
    {
        $this->book = $book;
    }

    // Configuration de la notification
    public function via($notifiable)
    {
        return ['database'];  // Utilisation de la base de données pour stocker la notification
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Le livre "' . $this->book->title . '" n\'a pas été retourné à temps.',
            'book_id' => $this->book->id,
            'alert_type' => 'Book Not Returned'
        ];
    }
}
