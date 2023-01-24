@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">@lang('crud.invoices.index_title')</h4>
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
                        @can('create', App\Models\Invoice::class)
                        <a
                            href="{{ route('invoices.create') }}"
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
                                @lang('crud.invoices.inputs.billing_date')
                            </th>
                            <th class="text-left">
                                @lang('crud.invoices.inputs.due_date')
                            </th>
                            <th class="text-left">
                                @lang('crud.invoices.inputs.tax')
                            </th>
                            <th class="text-left">
                                @lang('crud.invoices.inputs.tax2')
                            </th>
                            <th class="text-left">
                                @lang('crud.invoices.inputs.note')
                            </th>
                            <th class="text-left">
                                @lang('crud.invoices.inputs.reccurent')
                            </th>
                            <th class="text-left">
                                @lang('crud.invoices.inputs.status')
                            </th>
                            <th class="text-left">
                                @lang('crud.invoices.inputs.project_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.invoices.inputs.client_id')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->billing_date ?? '-' }}</td>
                            <td>{{ $invoice->due_date ?? '-' }}</td>
                            <td>{{ $invoice->tax ?? '-' }}</td>
                            <td>{{ $invoice->tax2 ?? '-' }}</td>
                            <td>{{ $invoice->note ?? '-' }}</td>
                            <td>{{ $invoice->reccurent ?? '-' }}</td>
                            <td>{{ $invoice->status ?? '-' }}</td>
                            <td>
                                {{ optional($invoice->project)->title ?? '-' }}
                            </td>
                            <td>
                                {{ optional($invoice->client)->name ?? '-' }}
                            </td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $invoice)
                                    <a
                                        href="{{ route('invoices.edit', $invoice) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $invoice)
                                    <a
                                        href="{{ route('invoices.show', $invoice) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $invoice)
                                    <form
                                        action="{{ route('invoices.destroy', $invoice) }}"
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
                            <td colspan="10">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10">{!! $invoices->render() !!}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
