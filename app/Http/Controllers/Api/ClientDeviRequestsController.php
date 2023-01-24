<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeviRequestResource;
use App\Http\Resources\DeviRequestCollection;

class ClientDeviRequestsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Client $client)
    {
        $this->authorize('view', $client);

        $search = $request->get('search', '');

        $deviRequests = $client
            ->deviRequests()
            ->search($search)
            ->latest()
            ->paginate();

        return new DeviRequestCollection($deviRequests);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Client $client)
    {
        $this->authorize('create', DeviRequest::class);

        $validated = $request->validate([
            'content' => ['nullable', 'max:255', 'json'],
            'manifest_id' => ['required', 'exists:manifests,id'],
            'user_id' => ['required', 'exists:users,id'],
            'status' => ['required', 'in:pending,canceled,estimated,draft'],
        ]);

        $deviRequest = $client->deviRequests()->create($validated);

        return new DeviRequestResource($deviRequest);
    }
}
