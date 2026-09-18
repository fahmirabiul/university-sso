<?php

namespace App\Http\Controllers\Web\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Passport\ClientRepository;

class ClientController extends Controller
{
    private readonly ClientRepository $clients;

    public function __construct(ClientRepository $clients)
    {
        $this->clients = $clients;
    }

    public function index(Request $request)
    {
        $clients = $request->user()->oauthApps()->where('revoked', false)->orderBy('name')->get();
        return view('clients.index', compact('clients'));
    }
}
