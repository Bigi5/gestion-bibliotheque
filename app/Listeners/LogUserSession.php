<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Request;
use App\Models\Session;

class LogUserSession
{
    public function handle(Login $event)
    {
        Session::create([
            'user_id'      => $event->user->id,
            'ip_address'   => Request::ip(),
            'user_agent'   => Request::header('User-Agent'),
            'payload'      => json_encode([]),
            'last_activity'=> now()->timestamp,
        ]);
    }
}
