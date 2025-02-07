<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\BorrowReminder;
use App\Mail\FinalBorrowReminder;

class Borrow extends Model
{
    use HasFactory;

    // Relation avec BorrowerProfile
    public function borrowerProfile()
    {
        return $this->belongsTo(BorrowerProfile::class, 'borrower_profile_id'); // 'borrower_profile_id' est l'exemple de votre clé étrangère
    }

    // Relation avec le livre
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Cast des dates pour les rendre des objets Carbon
    protected $casts = [
        'borrow_date' => 'datetime',
        'return_date' => 'datetime',
    ];

    // Attributs mass-assignables
    protected $fillable = [
        'borrower_profile_id',  // Remplacement de user_id par borrower_profile_id
        'book_id',
        'borrow_date',
        'return_date',
        'status',
    ];
    public function markAsReturned()
    {
        $this->status = 'retourne';
        $this->return_date = now();
        $this->save();
    }

    // Méthode pour obtenir la durée de l'emprunt
    public function getDurationAttribute()
    {
        if ($this->return_date) {
            return $this->borrow_date->diffInDays($this->return_date);
        }

        return $this->borrow_date->diffInDays(Carbon::now());
    }

    // Accessor pour obtenir le statut de l'emprunt
    public function getStatusAttribute(): string
    {
        if ($this->return_date) {
            return 'Retourné';
        }

        // Vérifie si la date de retour est dépassée
        $dueDate = $this->borrow_date->copy()->addDays(14); // Date d'échéance de 14 jours
        return now()->greaterThan($dueDate) ? 'Non retourné' : 'En cours';
    }

    /**
     * Envoi des rappels par mail à 2 jours de l'échéance.
     */
    public function sendReminder()
    {
        $dueDate = $this->borrow_date->copy()->addDays(14); // Date d'échéance de 14 jours
        $reminderDate = $dueDate->copy()->subDays(2); // Rappel 2 jours avant l'échéance

        if ($reminderDate->isToday()) {
            Mail::to($this->borrowerProfile->email)->send(new BorrowReminder($this));
        }
    }

    /**
     * Envoi d'un mail si le livre n'est pas retourné après 1 jour de la date d'échéance.
     */
    public function sendFinalReminder()
    {
        $dueDate = $this->borrow_date->copy()->addDays(14);

        if ($dueDate->isPast() && !$this->return_date) {
            Mail::to($this->borrowerProfile->email)->send(new FinalBorrowReminder($this));
        }
    }

    /**
     * Vérifie si le livre a été retourné et envoie un mail si nécessaire.
     */
    public function checkReturnStatus()
    {
        if ($this->return_date === null) {
            $this->sendFinalReminder(); // Envoi d'un rappel final si non retourné
        }
    }
}