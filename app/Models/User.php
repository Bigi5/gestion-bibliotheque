<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    public function borrows()
{
    return $this->hasMany(Borrow::class);
}
// Dans votre modèle User (User.php)
public function sessions()
{
    return $this->hasMany(Session::class);
}


    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


public function isAdmin()
{
    return $this->role === 'admin';
}

    
}
