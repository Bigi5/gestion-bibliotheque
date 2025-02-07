<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'copies_total',
        'copies_available', // Ajouté pour gérer la disponibilité
        'category_id',
        'cover_image',
        'status', // Définit si le livre est disponible ou non
    ];

    // Relations
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }

    // Définir copies_available par défaut à copies_total lors de la création
    protected static function booted()
    {
        static::creating(function ($book) {
            $book->copies_available = $book->copies_total;
            $book->updateStatus(); // Définir le statut lors de la création
        });
    }

    // Met à jour copies_available et le statut après modification
    public function decrementCopies()
    {
        if ($this->copies_available > 0) {
            $this->copies_available--;
            $this->updateStatus(); // Mettre à jour le statut après décrémentation
            $this->save();
        }
    }

    public function incrementCopies()
    {
        if ($this->copies_available < $this->copies_total) {
            $this->copies_available++;
            $this->updateStatus(); // Mettre à jour le statut après incrémentation
            $this->save();
        }
    }

    // Vérifie si le prêt est possible
    public function canBorrow()
    {
        return $this->copies_available > 0;
    }

    // Met à jour le statut du livre en fonction des copies disponibles
    public function updateStatus()
    {
        $this->status = $this->copies_available > 0 ? 'available' : 'unavailable';
    }
}
