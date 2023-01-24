<?php

namespace App\Http\Controllers\Api;

use App\Models\Anouncement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AnouncementResource;
use App\Http\Resources\AnouncementCollection;
use App\Http\Requests\AnouncementStoreRequest;
use App\Http\Requests\AnouncementUpdateRequest;

class AnouncementController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Anouncement::class);

        $search = $request->get('search', '');

        $anouncements = Anouncement::search($search)
            ->latest()
            ->paginate();

        return new AnouncementCollection($anouncements);
    }

    /**
     * @param \App\Http\Requests\AnouncementStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnouncementStoreRequest $request)
    {
        $this->authorize('create', Anouncement::class);

        $validated = $request->validated();

        $anouncement = Anouncement::create($validated);

        return new AnouncementResource($anouncement);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Anouncement $anouncement
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Anouncement $anouncement)
    {
        $this->authorize('view', $anouncement);

        return new AnouncementResource($anouncement);
    }

    /**
     * @param \App\Http\Requests\AnouncementUpdateRequest $request
     * @param \App\Models\Anouncement $anouncement
     * @return \Illuminate\Http\Response
     */
    public function update(
        AnouncementUpdateRequest $request,
        Anouncement $anouncement
    ) {
        $this->authorize('update', $anouncement);

        $validated = $request->validated();

        $anouncement->update($validated);

        return new AnouncementResource($anouncement);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Anouncement $anouncement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Anouncement $anouncement)
    {
        $this->authorize('delete', $anouncement);

        $anouncement->delete();

        return response()->noContent();
    }
}
