<?php

namespace App\Http\Controllers\Api;

use App\Models\Devi;
use Illuminate\Http\Request;
use App\Http\Resources\DeviResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeviCollection;
use App\Http\Requests\DeviStoreRequest;
use App\Http\Requests\DeviUpdateRequest;

class DeviController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Devi::class);

        $search = $request->get('search', '');

        $devis = Devi::search($search)
            ->latest()
            ->paginate();

        return new DeviCollection($devis);
    }

    /**
     * @param \App\Http\Requests\DeviStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeviStoreRequest $request)
    {
        $this->authorize('create', Devi::class);

        $validated = $request->validated();

        $devi = Devi::create($validated);

        return new DeviResource($devi);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Devi $devi
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Devi $devi)
    {
        $this->authorize('view', $devi);

        return new DeviResource($devi);
    }

    /**
     * @param \App\Http\Requests\DeviUpdateRequest $request
     * @param \App\Models\Devi $devi
     * @return \Illuminate\Http\Response
     */
    public function update(DeviUpdateRequest $request, Devi $devi)
    {
        $this->authorize('update', $devi);

        $validated = $request->validated();

        $devi->update($validated);

        return new DeviResource($devi);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Devi $devi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Devi $devi)
    {
        $this->authorize('delete', $devi);

        $devi->delete();

        return response()->noContent();
    }
}
