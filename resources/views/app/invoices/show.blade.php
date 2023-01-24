@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('invoices.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.invoices.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.invoices.inputs.billing_date')</h5>
                    <span>{{ $invoice->billing_date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.invoices.inputs.due_date')</h5>
                    <span>{{ $invoice->due_date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.invoices.inputs.tax')</h5>
                    <span>{{ $invoice->tax ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.invoices.inputs.tax2')</h5>
                    <span>{{ $invoice->tax2 ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.invoices.inputs.note')</h5>
                    <span>{{ $invoice->note ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.invoices.inputs.reccurent')</h5>
                    <span>{{ $invoice->reccurent ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.invoices.inputs.status')</h5>
                    <span>{{ $invoice->status ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.invoices.inputs.project_id')</h5>
                    <span>{{ optional($invoice->project)->title ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.invoices.inputs.client_id')</h5>
                    <span>{{ optional($invoice->client)->name ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('invoices.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Invoice::class)
                <a href="{{ route('invoices.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
