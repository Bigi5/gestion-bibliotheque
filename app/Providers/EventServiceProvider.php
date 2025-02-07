<?php

namespace App\Providers;

use App\Listeners\LogSuccessfulLogin;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Listeners\LogUserSession;
class EventServiceProvider extends ServiceProvider
{
    /**
     * Les événements et leurs écouteurs.
     *
     * @var array
     */
    protected $listen = [
        \Illuminate\Auth\Events\Login::class => [
            \App\Listeners\LogUserSession::class,
        ],
    ];
    

    /**
     * Enregistre tout autre écouteur d'événement.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
