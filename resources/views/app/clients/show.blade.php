@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('clients.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.clients.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.clients.inputs.name')</h5>
                    <span>{{ $client->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.clients.inputs.address')</h5>
                    <span>{{ $client->address ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.clients.inputs.city')</h5>
                    <span>{{ $client->city ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.clients.inputs.state')</h5>
                    <span>{{ $client->state ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.clients.inputs.zipcode')</h5>
                    <span>{{ $client->zipcode ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.clients.inputs.website')</h5>
                    <span>{{ $client->website ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.clients.inputs.tva_number')</h5>
                    <span>{{ $client->tva_number ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.clients.inputs.currency_id')</h5>
                    <span>{{ optional($client->currency)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.clients.inputs.rc')</h5>
                    <span>{{ $client->rc ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.clients.inputs.nif')</h5>
                    <span>{{ $client->nif ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.clients.inputs.art')</h5>
                    <span>{{ $client->art ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.clients.inputs.online_payment')</h5>
                    <span>{{ $client->online_payment ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('clients.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Client::class)
                <a href="{{ route('clients.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
