@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('projects.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.projects.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.projects.inputs.title')</h5>
                    <span>{{ $project->title ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.projects.inputs.description')</h5>
                    <span>{{ $project->description ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.projects.inputs.start_date')</h5>
                    <span>{{ $project->start_date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.projects.inputs.end_date')</h5>
                    <span>{{ $project->end_date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.projects.inputs.price')</h5>
                    <span>{{ $project->price ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.projects.inputs.client_id')</h5>
                    <span>{{ optional($project->client)->name ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('projects.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Project::class)
                <a href="{{ route('projects.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
