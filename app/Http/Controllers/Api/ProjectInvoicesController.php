<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\InvoiceCollection;

class ProjectInvoicesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        $search = $request->get('search', '');

        $invoices = $project
            ->invoices()
            ->search($search)
            ->latest()
            ->paginate();

        return new InvoiceCollection($invoices);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project)
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
            'client_id' => ['required', 'exists:clients,id'],
        ]);

        $invoice = $project->invoices()->create($validated);

        return new InvoiceResource($invoice);
    }
}
