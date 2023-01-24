@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('presences.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.presences.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.presences.inputs.arrival_date')</h5>
                    <span>{{ $presence->arrival_date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.presences.inputs.departure_date')</h5>
                    <span>{{ $presence->departure_date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.presences.inputs.note')</h5>
                    <span>{{ $presence->note ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.presences.inputs.user_id')</h5>
                    <span
                        >{{ optional($presence->teamMember)->name ?? '-'
                        }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('presences.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Presence::class)
                <a href="{{ route('presences.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
