<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.leaves.index', compact('leaves', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Leave::class);

        return view('app.leaves.create');
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

        return redirect()
            ->route('leaves.edit', $leave)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Leave $leave
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Leave $leave)
    {
        $this->authorize('view', $leave);

        return view('app.leaves.show', compact('leave'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Leave $leave
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Leave $leave)
    {
        $this->authorize('update', $leave);

        return view('app.leaves.edit', compact('leave'));
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

        return redirect()
            ->route('leaves.edit', $leave)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('leaves.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
