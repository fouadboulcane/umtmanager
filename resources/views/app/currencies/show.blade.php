@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('currencies.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.currencies.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.currencies.inputs.name')</h5>
                    <span>{{ $currency->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.currencies.inputs.symbol')</h5>
                    <span>{{ $currency->symbol ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('currencies.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Currency::class)
                <a
                    href="{{ route('currencies.create') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
