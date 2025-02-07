<?php

namespace App\Mail;

use App\Models\BorrowerProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class BorrowerProfileAdded extends Mailable
{
    use Queueable, SerializesModels;

    public $borrowerProfile;

    /**
     * Create a new message instance.
     *
     * @param BorrowerProfile $borrowerProfile
     * @return void
     */
    public function __construct(BorrowerProfile $borrowerProfile)
    {
        $this->borrowerProfile = $borrowerProfile;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.borrower_profile_added') // La vue Blade que tu vas créer
                    ->subject('Profil d\'emprunteur ajouté')
                    ->with([
                        'borrowerProfile' => $this->borrowerProfile,
                    ]);
    }
}
