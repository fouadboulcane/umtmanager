@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('manifests.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.manifests.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.manifests.inputs.title')</h5>
                    <span>{{ $manifest->title ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.manifests.inputs.description')</h5>
                    <span>{{ $manifest->description ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.manifests.inputs.status')</h5>
                    <span>{{ $manifest->status ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.manifests.inputs.is_public')</h5>
                    <span>{{ $manifest->is_public ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.manifests.inputs.has_files')</h5>
                    <span>{{ $manifest->has_files ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('manifests.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Manifest::class)
                <a href="{{ route('manifests.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
