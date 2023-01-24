<?php

namespace App\Http\Controllers\Api;

use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ClientCollection;

class CurrencyClientsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Currency $currency)
    {
        $this->authorize('view', $currency);

        $search = $request->get('search', '');

        $clients = $currency
            ->clients()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClientCollection($clients);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Currency $currency)
    {
        $this->authorize('create', Client::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'address' => ['required', 'max:255', 'string'],
            'city' => ['required', 'max:255', 'string'],
            'state' => ['required', 'max:255', 'string'],
            'zipcode' => ['required', 'max:255'],
            'website' => ['nullable', 'max:255', 'string'],
            'tva_number' => ['required', 'max:255', 'string'],
            'rc' => ['required', 'max:255', 'string'],
            'nif' => ['required', 'max:255', 'string'],
            'art' => ['required', 'max:255', 'string'],
            'online_payment' => ['required', 'boolean'],
        ]);

        $client = $currency->clients()->create($validated);

        return new ClientResource($client);
    }
}
