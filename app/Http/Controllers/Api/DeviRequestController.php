<?php

namespace App\Http\Controllers\Api;

use App\Models\DeviRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeviRequestResource;
use App\Http\Resources\DeviRequestCollection;
use App\Http\Requests\DeviRequestStoreRequest;
use App\Http\Requests\DeviRequestUpdateRequest;

class DeviRequestController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', DeviRequest::class);

        $search = $request->get('search', '');

        $deviRequests = DeviRequest::search($search)
            ->latest()
            ->paginate();

        return new DeviRequestCollection($deviRequests);
    }

    /**
     * @param \App\Http\Requests\DeviRequestStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeviRequestStoreRequest $request)
    {
        $this->authorize('create', DeviRequest::class);

        $validated = $request->validated();
        $validated['content'] = json_decode($validated['content'], true);

        $deviRequest = DeviRequest::create($validated);

        return new DeviRequestResource($deviRequest);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DeviRequest $deviRequest
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DeviRequest $deviRequest)
    {
        $this->authorize('view', $deviRequest);

        return new DeviRequestResource($deviRequest);
    }

    /**
     * @param \App\Http\Requests\DeviRequestUpdateRequest $request
     * @param \App\Models\DeviRequest $deviRequest
     * @return \Illuminate\Http\Response
     */
    public function update(
        DeviRequestUpdateRequest $request,
        DeviRequest $deviRequest
    ) {
        $this->authorize('update', $deviRequest);

        $validated = $request->validated();

        $validated['content'] = json_decode($validated['content'], true);

        $deviRequest->update($validated);

        return new DeviRequestResource($deviRequest);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DeviRequest $deviRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DeviRequest $deviRequest)
    {
        $this->authorize('delete', $deviRequest);

        $deviRequest->delete();

        return response()->noContent();
    }
}
