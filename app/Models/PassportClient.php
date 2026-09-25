<?php

namespace App\Models;

use Laravel\Passport\Client as BaseClient;

class PassportClient extends BaseClient
{
    /**
     * Determine if the client should skip the authorization prompt.
     *
     * @return bool
     */
    public function skipsAuthorization(\Illuminate\Contracts\Auth\Authenticatable $user, array $scopes): bool
    {
        // Selalu lewati layar "Authorize App" (Izinkan/Tolak) untuk semua klien, 
        // karena ini adalah aplikasi internal SSO.
        return true; 
    }
}
