<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskCollection;

class UserTasksController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $tasks = $user
            ->tasks2()
            ->search($search)
            ->latest()
            ->paginate();

        return new TaskCollection($tasks);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user, Task $task)
    {
        $this->authorize('update', $user);

        $user->tasks2()->syncWithoutDetaching([$task->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user, Task $task)
    {
        $this->authorize('update', $user);

        $user->tasks2()->detach($task);

        return response()->noContent();
    }
}
