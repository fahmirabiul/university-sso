<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Passport\ClientRepository;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request, ClientRepository $clients)
    {
        // Get some basic stats for the dashboard
        $stats = [
            'total_users' => User::count(),
            'total_clients' => $request->user()->oauthApps()->where('revoked', false)->count(),
        ];

        return view('dashboard.index', compact('stats'));
    }
}
