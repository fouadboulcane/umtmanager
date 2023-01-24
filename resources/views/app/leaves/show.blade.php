@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('leaves.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.leaves.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.leaves.inputs.type')</h5>
                    <span>{{ $leave->type ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.leaves.inputs.duration')</h5>
                    <span>{{ $leave->duration ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.leaves.inputs.start_date')</h5>
                    <span>{{ $leave->start_date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.leaves.inputs.end_date')</h5>
                    <span>{{ $leave->end_date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.leaves.inputs.reason')</h5>
                    <span>{{ $leave->reason ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('leaves.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Leave::class)
                <a href="{{ route('leaves.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
