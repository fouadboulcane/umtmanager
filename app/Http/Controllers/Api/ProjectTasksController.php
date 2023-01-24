<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskCollection;

class ProjectTasksController extends Controller
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

        $tasks = $project
            ->tasks()
            ->search($search)
            ->latest()
            ->paginate();

        return new TaskCollection($tasks);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project)
    {
        $this->authorize('create', Task::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'difficulty' => ['required', 'in:1,2,3,4,5'],
            'status' => ['required', 'in:todo,ongoing,done,closed'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ]);

        $task = $project->tasks()->create($validated);

        return new TaskResource($task);
    }
}
