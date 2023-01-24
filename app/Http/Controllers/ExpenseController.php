<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Expense;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\ExpenseStoreRequest;
use App\Http\Requests\ExpenseUpdateRequest;

class ExpenseController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Expense::class);

        $search = $request->get('search', '');

        $expenses = Expense::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.expenses.index', compact('expenses', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Expense::class);

        $projects = Project::pluck('title', 'id');
        $users = User::pluck('name', 'id');

        return view('app.expenses.create', compact('projects', 'users'));
    }

    /**
     * @param \App\Http\Requests\ExpenseStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseStoreRequest $request)
    {
        $this->authorize('create', Expense::class);

        $validated = $request->validated();

        $expense = Expense::create($validated);

        return redirect()
            ->route('expenses.edit', $expense)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Expense $expense)
    {
        $this->authorize('view', $expense);

        return view('app.expenses.show', compact('expense'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Expense $expense)
    {
        $this->authorize('update', $expense);

        $projects = Project::pluck('title', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.expenses.edit',
            compact('expense', 'projects', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\ExpenseUpdateRequest $request
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function update(ExpenseUpdateRequest $request, Expense $expense)
    {
        $this->authorize('update', $expense);

        $validated = $request->validated();

        $expense->update($validated);

        return redirect()
            ->route('expenses.edit', $expense)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Expense $expense)
    {
        $this->authorize('delete', $expense);

        $expense->delete();

        return redirect()
            ->route('expenses.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
