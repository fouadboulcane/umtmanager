@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('events.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.events.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.events.inputs.title')</h5>
                    <span>{{ $event->title ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.events.inputs.description')</h5>
                    <span>{{ $event->description ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.events.inputs.start_date')</h5>
                    <span>{{ $event->start_date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.events.inputs.end_date')</h5>
                    <span>{{ $event->end_date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.events.inputs.placement')</h5>
                    <span>{{ $event->placement ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.events.inputs.client_id')</h5>
                    <span>{{ optional($event->client)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.events.inputs.share_with')</h5>
                    <span>{{ $event->share_with ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.events.inputs.color')</h5>
                    <span>{{ $event->color ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.events.inputs.repeat')</h5>
                    <span>{{ $event->repeat ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.events.inputs.status')</h5>
                    <span>{{ $event->status ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.events.inputs.user_id')</h5>
                    <span>{{ optional($event->creator)->name ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('events.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Event::class)
                <a href="{{ route('events.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
