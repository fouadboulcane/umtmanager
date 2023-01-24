<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\ExpenseCollection;

class ProjectExpensesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        $search = $request->get('search', '');

        $expenses = $project
            ->expenses()
            ->search($search)
            ->latest()
            ->paginate();

        return new ExpenseCollection($expenses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project)
    {
        $this->authorize('create', Expense::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'category' => ['required', 'in:miscellaneous_expense'],
            'tax' => ['required', 'in:dt,tva_19%,tva_9%'],
            'tax2' => ['required', 'in:dt,tva_19%,tva_9%'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $expense = $project->expenses()->create($validated);

        return new ExpenseResource($expense);
    }
}
