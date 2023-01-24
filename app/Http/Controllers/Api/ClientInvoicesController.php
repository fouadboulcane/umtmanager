<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\InvoiceCollection;

class ClientInvoicesController extends Controller
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

        $invoices = $client
            ->invoices()
            ->search($search)
            ->latest()
            ->paginate();

        return new InvoiceCollection($invoices);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Client $client)
    {
        $this->authorize('create', Invoice::class);

        $validated = $request->validate([
            'billing_date' => ['required', 'date'],
            'due_date' => ['required', 'date'],
            'tax' => ['nullable', 'in:dt,tva_19%,tva_9%'],
            'tax2' => ['nullable', 'in:dt,tva_19%,tva_9%'],
            'note' => ['nullable', 'max:255', 'string'],
            'reccurent' => ['required', 'boolean'],
            'status' => ['required', 'in:paid,canceled,draft,late'],
            'project_id' => ['required', 'exists:projects,id'],
        ]);

        $invoice = $client->invoices()->create($validated);

        return new InvoiceResource($invoice);
    }
}
