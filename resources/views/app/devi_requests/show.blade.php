@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('devi-requests.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.devi_requests.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.devi_requests.inputs.content')</h5>
                    <pre>{{ json_encode($deviRequest->content) ?? '-' }}</pre>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.devi_requests.inputs.manifest_id')</h5>
                    <span
                        >{{ optional($deviRequest->manifest)->title ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.devi_requests.inputs.client_id')</h5>
                    <span
                        >{{ optional($deviRequest->client)->name ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.devi_requests.inputs.user_id')</h5>
                    <span
                        >{{ optional($deviRequest->assignedMember)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.devi_requests.inputs.status')</h5>
                    <span>{{ $deviRequest->status ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('devi-requests.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\DeviRequest::class)
                <a
                    href="{{ route('devi-requests.create') }}"
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
