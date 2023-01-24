@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('posts.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.posts.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.posts.inputs.title')</h5>
                    <span>{{ $post->title ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.posts.inputs.content')</h5>
                    <span>{{ $post->content ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.posts.inputs.type')</h5>
                    <span>{{ $post->type ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.posts.inputs.status')</h5>
                    <span>{{ $post->status ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.posts.inputs.category_id')</h5>
                    <span>{{ optional($post->category)->title ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('posts.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Post::class)
                <a href="{{ route('posts.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
