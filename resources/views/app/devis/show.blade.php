@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('devis.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.devis.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.devis.inputs.start_date')</h5>
                    <span>{{ $devi->start_date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.devis.inputs.end_date')</h5>
                    <span>{{ $devi->end_date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.devis.inputs.tax')</h5>
                    <span>{{ $devi->tax ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.devis.inputs.tax2')</h5>
                    <span>{{ $devi->tax2 ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.devis.inputs.note')</h5>
                    <span>{{ $devi->note ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.devis.inputs.client_id')</h5>
                    <span>{{ optional($devi->client)->name ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('devis.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Devi::class)
                <a href="{{ route('devis.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
