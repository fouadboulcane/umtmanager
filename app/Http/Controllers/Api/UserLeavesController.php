<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LeaveResource;
use App\Http\Resources\LeaveCollection;

class UserLeavesController extends Controller
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

        $leaves = $user
            ->leaves()
            ->search($search)
            ->latest()
            ->paginate();

        return new LeaveCollection($leaves);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Leave::class);

        $validated = $request->validate([
            'type' => ['required', 'in:casual_leave,maternity_leave'],
            'duration' => ['required', 'in:one_day,multiple_days,hours'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'reason' => ['required', 'max:255', 'string'],
        ]);

        $leave = $user->leaves()->create($validated);

        return new LeaveResource($leave);
    }
}
