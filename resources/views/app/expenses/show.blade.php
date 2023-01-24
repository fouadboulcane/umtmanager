@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('expenses.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.expenses.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.expenses.inputs.title')</h5>
                    <span>{{ $expense->title ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.expenses.inputs.description')</h5>
                    <span>{{ $expense->description ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.expenses.inputs.amount')</h5>
                    <span>{{ $expense->amount ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.expenses.inputs.date')</h5>
                    <span>{{ $expense->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.expenses.inputs.category')</h5>
                    <span>{{ $expense->category ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.expenses.inputs.tax')</h5>
                    <span>{{ $expense->tax ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.expenses.inputs.tax2')</h5>
                    <span>{{ $expense->tax2 ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.expenses.inputs.project_id')</h5>
                    <span>{{ optional($expense->project)->title ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.expenses.inputs.user_id')</h5>
                    <span
                        >{{ optional($expense->teamMember)->name ?? '-' }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('expenses.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Expense::class)
                <a href="{{ route('expenses.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
