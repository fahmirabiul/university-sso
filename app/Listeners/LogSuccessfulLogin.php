<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use App\Models\LoginHistory;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     */
    public function __construct(protected Request $request)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        LoginHistory::create([
            'user_id' => $event->user->id,
            'ip_address' => $this->request->ip(),
            'user_agent' => $this->request->userAgent(),
        ]);
    }
}
