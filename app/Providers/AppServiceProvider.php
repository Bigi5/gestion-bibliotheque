<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('alertes', collect([
            'Rappel : Vous avez des livres en retard.',
            'Nouveau livre disponible dans la bibliothèque.',
            'La date de retour d\'un livre approche.'
        ]));
    
        Schema::defaultStringLength(191);  // <-- Cela doit être en dehors de la méthode View::share
    }
    
}
