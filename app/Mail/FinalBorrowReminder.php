<?php

namespace App\Mail;

use App\Models\Borrow;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FinalBorrowReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $borrow;

    /**
     * Create a new message instance.
     *
     * @param Borrow $borrow
     * @return void
     */
    public function __construct(Borrow $borrow)
    {
        $this->borrow = $borrow;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Dernier rappel pour l\'emprunt de livre')
                    ->view('emails.final_borrow_reminder')
                    ->with([
                        'borrowerName' => $this->borrow->borrowerProfile->name,
                        'bookTitle' => $this->borrow->book->title,
                        'dueDate' => $this->borrow->borrow_date->addDays(7)->toDateString(),
                    ]);
    }
}
