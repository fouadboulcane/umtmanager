@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('tasks.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.tasks.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.tasks.inputs.title')</h5>
                    <span>{{ $task->title ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tasks.inputs.description')</h5>
                    <span>{{ $task->description ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tasks.inputs.difficulty')</h5>
                    <span>{{ $task->difficulty ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tasks.inputs.project_id')</h5>
                    <span>{{ optional($task->project)->title ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tasks.inputs.status')</h5>
                    <span>{{ $task->status ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tasks.inputs.start_date')</h5>
                    <span>{{ $task->start_date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tasks.inputs.end_date')</h5>
                    <span>{{ $task->end_date ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('tasks.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Task::class)
                <a href="{{ route('tasks.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
