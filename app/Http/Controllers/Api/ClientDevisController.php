<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Resources\DeviResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeviCollection;

class ClientDevisController extends Controller
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

        $devis = $client
            ->devis()
            ->search($search)
            ->latest()
            ->paginate();

        return new DeviCollection($devis);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Client $client)
    {
        $this->authorize('create', Devi::class);

        $validated = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'tax' => ['nullable', 'in:dt,tva_19%,tva_9%'],
            'tax2' => ['nullable', 'in:dt,tva_19%,tva_9%'],
            'note' => ['nullable', 'max:255', 'string'],
        ]);

        $devi = $client->devis()->create($validated);

        return new DeviResource($devi);
    }
}
