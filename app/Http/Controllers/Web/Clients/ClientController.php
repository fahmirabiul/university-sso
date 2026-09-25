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
        $clients = $request->user()->oauthApps()->orderBy('name')->get();
        return view('clients.index', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'redirect' => 'required|url',
        ]);

        $client = $this->clients->createAuthorizationCodeGrantClient(
            $validated['name'], 
            [$validated['redirect']],
            confidential: true,
            user: $request->user()
        );

        return redirect()->route('clients.index')
            ->with('success', 'Aplikasi OAuth berhasil ditambahkan.')
            ->with('new_client_id', $client->id)
            ->with('new_client_secret', $client->plainSecret);
    }

    public function destroy(Request $request, string $clientId)
    {
        $client = $request->user()->oauthApps()->find($clientId);

        if ($client) {
            $this->clients->delete($client);
        }

        return redirect()->route('clients.index')->with('success', 'Akses klien telah dicabut.');
    }
}
