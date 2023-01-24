<?php

namespace App\Http\Controllers\Api;

use App\Models\Leave;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LeaveResource;
use App\Http\Resources\LeaveCollection;
use App\Http\Requests\LeaveStoreRequest;
use App\Http\Requests\LeaveUpdateRequest;

class LeaveController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Leave::class);

        $search = $request->get('search', '');

        $leaves = Leave::search($search)
            ->latest()
            ->paginate();

        return new LeaveCollection($leaves);
    }

    /**
     * @param \App\Http\Requests\LeaveStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeaveStoreRequest $request)
    {
        $this->authorize('create', Leave::class);

        $validated = $request->validated();

        $leave = Leave::create($validated);

        return new LeaveResource($leave);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Leave $leave
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Leave $leave)
    {
        $this->authorize('view', $leave);

        return new LeaveResource($leave);
    }

    /**
     * @param \App\Http\Requests\LeaveUpdateRequest $request
     * @param \App\Models\Leave $leave
     * @return \Illuminate\Http\Response
     */
    public function update(LeaveUpdateRequest $request, Leave $leave)
    {
        $this->authorize('update', $leave);

        $validated = $request->validated();

        $leave->update($validated);

        return new LeaveResource($leave);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Leave $leave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Leave $leave)
    {
        $this->authorize('delete', $leave);

        $leave->delete();

        return response()->noContent();
    }
}
