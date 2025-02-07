<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', // Ajoutez les champs que vous souhaitez rendre remplissables
    ];

    // Vous pouvez également ajouter des relations ou des méthodes ici si nécessaire
}
