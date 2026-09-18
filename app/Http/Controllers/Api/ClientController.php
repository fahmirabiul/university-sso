<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Passport\ClientRepository;

class ClientController extends Controller
{
    use ApiResponses;

    public function __construct(
        private readonly ClientRepository $clients
    ) {}

    public function index(Request $request): JsonResponse
    {
        $clients = $request->user()->oauthApps()->where('revoked', false)->orderBy('name')->get();
        return $this->successResponse('Clients retrieved successfully.', $clients);
    }

    public function store(Request $request): JsonResponse
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

        return $this->successResponse('Client created successfully.', $client, 201);
    }

    public function destroy(Request $request, string $clientId): JsonResponse
    {
        $client = $request->user()->oauthApps()->where('revoked', false)->find($clientId);

        if (!$client) {
            return $this->errorResponse('Client not found.', 404);
        }

        $this->clients->delete($client);

        return $this->successResponse('Client deleted successfully.');
    }
}
