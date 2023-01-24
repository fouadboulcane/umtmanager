<?php

namespace App\Http\Controllers\Api;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\PaymentCollection;

class InvoicePaymentsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Invoice $invoice)
    {
        $this->authorize('view', $invoice);

        $search = $request->get('search', '');

        $payments = $invoice
            ->payments()
            ->search($search)
            ->latest()
            ->paginate();

        return new PaymentCollection($payments);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Invoice $invoice)
    {
        $this->authorize('create', Payment::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric'],
            'note' => ['nullable', 'max:255', 'string'],
            'mode' => [
                'required',
                'in:cash,postal_check,bank_check,bank_transfer',
            ],
        ]);

        $payment = $invoice->payments()->create($validated);

        return new PaymentResource($payment);
    }
}
