@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('payments.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.payments.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.payments.inputs.date')</h5>
                    <span>{{ $payment->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.payments.inputs.amount')</h5>
                    <span>{{ $payment->amount ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.payments.inputs.note')</h5>
                    <span>{{ $payment->note ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.payments.inputs.mode')</h5>
                    <span>{{ $payment->mode ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.payments.inputs.invoice_id')</h5>
                    <span
                        >{{ optional($payment->invoice)->billing_date ?? '-'
                        }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('payments.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Payment::class)
                <a href="{{ route('payments.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
