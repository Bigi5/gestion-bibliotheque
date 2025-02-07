<?php

namespace App\Mail;

use App\Models\Borrow;
use App\Models\Book;
use App\Models\BorrowerProfile;
use Illuminate\Mail\Mailable;

class BookBorrowedMail extends Mailable
{
    public $borrowerProfile;
    public $book;
    public $borrow;
    public $dueDate;

    public function __construct(BorrowerProfile $borrowerProfile, Book $book, Borrow $borrow, $dueDate)
    {
        $this->borrowerProfile = $borrowerProfile;
        $this->book = $book;
        $this->borrow = $borrow;
        $this->dueDate = $dueDate;
    }

    public function build()
    {
        return $this->view('emails.borrowed_book_notification')
                    ->with([
                        'borrowerName' => $this->borrowerProfile->first_name . ' ' . $this->borrowerProfile->last_name,
                        'bookTitle' => $this->book->title,
                        'borrowDate' => $this->borrow->borrow_date,
                        'dueDate' => $this->dueDate,
                    ]);
    }
}
