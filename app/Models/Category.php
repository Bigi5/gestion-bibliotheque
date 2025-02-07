<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Colonnes assignables
    protected $fillable = ['name'];

    // Relation avec Book (une catégorie peut avoir plusieurs livres)
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
