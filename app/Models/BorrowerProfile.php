<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class BorrowerProfile extends Model
{
    use HasFactory, Notifiable; // Inclure le trait Notifiable pour l'envoi de notifications

    /**
     * Les attributs pouvant être remplis en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
    ];

    /**
     * Relation avec le modèle Borrow.
     * Un profil emprunteur peut avoir plusieurs emprunts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function borrows()
    {
        return $this->hasMany(Borrow::class, 'borrower_profile_id');
    }
    
}
