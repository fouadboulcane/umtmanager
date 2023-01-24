<?php

namespace App\Http\Controllers\Api;

use App\Models\Presence;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PresenceResource;
use App\Http\Resources\PresenceCollection;
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
            ->paginate();

        return new PresenceCollection($presences);
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

        return new PresenceResource($presence);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Presence $presence)
    {
        $this->authorize('view', $presence);

        return new PresenceResource($presence);
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

        return new PresenceResource($presence);
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

        return response()->noContent();
    }
}
