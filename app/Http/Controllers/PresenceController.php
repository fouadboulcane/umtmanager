<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Presence;
use Illuminate\Http\Request;
use App\Http\Requests\PresenceStoreRequest;
use App\Http\Requests\PresenceUpdateRequest;

class PresenceController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Presence::class);

        $search = $request->get('search', '');

        $presences = Presence::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.presences.index', compact('presences', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Presence::class);

        $users = User::pluck('name', 'id');

        return view('app.presences.create', compact('users'));
    }

    /**
     * @param \App\Http\Requests\PresenceStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PresenceStoreRequest $request)
    {
        $this->authorize('create', Presence::class);

        $validated = $request->validated();

        $presence = Presence::create($validated);

        return redirect()
            ->route('presences.edit', $presence)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Presence $presence)
    {
        $this->authorize('view', $presence);

        return view('app.presences.show', compact('presence'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Presence $presence)
    {
        $this->authorize('update', $presence);

        $users = User::pluck('name', 'id');

        return view('app.presences.edit', compact('presence', 'users'));
    }

    /**
     * @param \App\Http\Requests\PresenceUpdateRequest $request
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function update(PresenceUpdateRequest $request, Presence $presence)
    {
        $this->authorize('update', $presence);

        $validated = $request->validated();

        $presence->update($validated);

        return redirect()
            ->route('presences.edit', $presence)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Presence $presence)
    {
        $this->authorize('delete', $presence);

        $presence->delete();

        return redirect()
            ->route('presences.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
