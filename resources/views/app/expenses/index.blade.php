@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">@lang('crud.expenses.index_title')</h4>
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
                        @can('create', App\Models\Expense::class)
                        <a
                            href="{{ route('expenses.create') }}"
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
                                @lang('crud.expenses.inputs.title')
                            </th>
                            <th class="text-left">
                                @lang('crud.expenses.inputs.description')
                            </th>
                            <th class="text-right">
                                @lang('crud.expenses.inputs.amount')
                            </th>
                            <th class="text-left">
                                @lang('crud.expenses.inputs.date')
                            </th>
                            <th class="text-left">
                                @lang('crud.expenses.inputs.category')
                            </th>
                            <th class="text-left">
                                @lang('crud.expenses.inputs.tax')
                            </th>
                            <th class="text-left">
                                @lang('crud.expenses.inputs.tax2')
                            </th>
                            <th class="text-left">
                                @lang('crud.expenses.inputs.project_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.expenses.inputs.user_id')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $expense)
                        <tr>
                            <td>{{ $expense->title ?? '-' }}</td>
                            <td>{{ $expense->description ?? '-' }}</td>
                            <td>{{ $expense->amount ?? '-' }}</td>
                            <td>{{ $expense->date ?? '-' }}</td>
                            <td>{{ $expense->category ?? '-' }}</td>
                            <td>{{ $expense->tax ?? '-' }}</td>
                            <td>{{ $expense->tax2 ?? '-' }}</td>
                            <td>
                                {{ optional($expense->project)->title ?? '-' }}
                            </td>
                            <td>
                                {{ optional($expense->teamMember)->name ?? '-'
                                }}
                            </td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $expense)
                                    <a
                                        href="{{ route('expenses.edit', $expense) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $expense)
                                    <a
                                        href="{{ route('expenses.show', $expense) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $expense)
                                    <form
                                        action="{{ route('expenses.destroy', $expense) }}"
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
                            <td colspan="10">{!! $expenses->render() !!}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
