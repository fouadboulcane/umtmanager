@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">@lang('crud.events.index_title')</h4>
            </div>

            <div class="searchbar mt-4 mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <form>
                            <div class="input-group">
                                <input
                                    id="indexSearch"
                                    type="text"
                                    name="search"
                                    placeholder="{{ __('crud.common.search') }}"
                                    value="{{ $search ?? '' }}"
                                    class="form-control"
                                    autocomplete="off"
                                />
                                <div class="input-group-append">
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        <i class="icon ion-md-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        @can('create', App\Models\Event::class)
                        <a
                            href="{{ route('events.create') }}"
                            class="btn btn-primary"
                        >
                            <i class="icon ion-md-add"></i>
                            @lang('crud.common.create')
                        </a>
                        @endcan
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-borderless table-hover">
                    <thead>
                        <tr>
                            <th class="text-left">
                                @lang('crud.events.inputs.title')
                            </th>
                            <th class="text-left">
                                @lang('crud.events.inputs.description')
                            </th>
                            <th class="text-left">
                                @lang('crud.events.inputs.start_date')
                            </th>
                            <th class="text-left">
                                @lang('crud.events.inputs.end_date')
                            </th>
                            <th class="text-left">
                                @lang('crud.events.inputs.placement')
                            </th>
                            <th class="text-left">
                                @lang('crud.events.inputs.client_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.events.inputs.share_with')
                            </th>
                            <th class="text-left">
                                @lang('crud.events.inputs.color')
                            </th>
                            <th class="text-left">
                                @lang('crud.events.inputs.repeat')
                            </th>
                            <th class="text-left">
                                @lang('crud.events.inputs.status')
                            </th>
                            <th class="text-left">
                                @lang('crud.events.inputs.user_id')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                        <tr>
                            <td>{{ $event->title ?? '-' }}</td>
                            <td>{{ $event->description ?? '-' }}</td>
                            <td>{{ $event->start_date ?? '-' }}</td>
                            <td>{{ $event->end_date ?? '-' }}</td>
                            <td>{{ $event->placement ?? '-' }}</td>
                            <td>{{ optional($event->client)->name ?? '-' }}</td>
                            <td>{{ $event->share_with ?? '-' }}</td>
                            <td>{{ $event->color ?? '-' }}</td>
                            <td>{{ $event->repeat ?? '-' }}</td>
                            <td>{{ $event->status ?? '-' }}</td>
                            <td>
                                {{ optional($event->creator)->name ?? '-' }}
                            </td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $event)
                                    <a
                                        href="{{ route('events.edit', $event) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $event)
                                    <a
                                        href="{{ route('events.show', $event) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $event)
                                    <form
                                        action="{{ route('events.destroy', $event) }}"
                                        method="POST"
                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                    >
                                        @csrf @method('DELETE')
                                        <button
                                            type="submit"
                                            class="btn btn-light text-danger"
                                        >
                                            <i class="icon ion-md-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="12">{!! $events->render() !!}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
