@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('anouncements.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.anouncements.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.anouncements.inputs.title')</h5>
                    <span>{{ $anouncement->title ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.anouncements.inputs.content')</h5>
                    <span>{{ $anouncement->content ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.anouncements.inputs.start_date')</h5>
                    <span>{{ $anouncement->start_date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.anouncements.inputs.end_date')</h5>
                    <span>{{ $anouncement->end_date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.anouncements.inputs.share_with')</h5>
                    <span>{{ $anouncement->share_with ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('anouncements.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Anouncement::class)
                <a
                    href="{{ route('anouncements.create') }}"
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
