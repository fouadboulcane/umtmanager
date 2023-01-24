@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">@lang('crud.clients.index_title')</h4>
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
                        @can('create', App\Models\Client::class)
                        <a
                            href="{{ route('clients.create') }}"
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
                                @lang('crud.clients.inputs.name')
                            </th>
                            <th class="text-left">
                                @lang('crud.clients.inputs.address')
                            </th>
                            <th class="text-left">
                                @lang('crud.clients.inputs.city')
                            </th>
                            <th class="text-left">
                                @lang('crud.clients.inputs.state')
                            </th>
                            <th class="text-left">
                                @lang('crud.clients.inputs.zipcode')
                            </th>
                            <th class="text-left">
                                @lang('crud.clients.inputs.website')
                            </th>
                            <th class="text-left">
                                @lang('crud.clients.inputs.tva_number')
                            </th>
                            <th class="text-left">
                                @lang('crud.clients.inputs.currency_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.clients.inputs.rc')
                            </th>
                            <th class="text-left">
                                @lang('crud.clients.inputs.nif')
                            </th>
                            <th class="text-left">
                                @lang('crud.clients.inputs.art')
                            </th>
                            <th class="text-left">
                                @lang('crud.clients.inputs.online_payment')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $client)
                        <tr>
                            <td>{{ $client->name ?? '-' }}</td>
                            <td>{{ $client->address ?? '-' }}</td>
                            <td>{{ $client->city ?? '-' }}</td>
                            <td>{{ $client->state ?? '-' }}</td>
                            <td>{{ $client->zipcode ?? '-' }}</td>
                            <td>{{ $client->website ?? '-' }}</td>
                            <td>{{ $client->tva_number ?? '-' }}</td>
                            <td>
                                {{ optional($client->currency)->name ?? '-' }}
                            </td>
                            <td>{{ $client->rc ?? '-' }}</td>
                            <td>{{ $client->nif ?? '-' }}</td>
                            <td>{{ $client->art ?? '-' }}</td>
                            <td>{{ $client->online_payment ?? '-' }}</td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $client)
                                    <a
                                        href="{{ route('clients.edit', $client) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $client)
                                    <a
                                        href="{{ route('clients.show', $client) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $client)
                                    <form
                                        action="{{ route('clients.destroy', $client) }}"
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
                            <td colspan="13">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="13">{!! $clients->render() !!}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
