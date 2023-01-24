<?php

namespace App\Http\Controllers\Api;

use App\Models\Manifest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ManifestResource;
use App\Http\Resources\ManifestCollection;
use App\Http\Requests\ManifestStoreRequest;
use App\Http\Requests\ManifestUpdateRequest;

class ManifestController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Manifest::class);

        $search = $request->get('search', '');

        $manifests = Manifest::search($search)
            ->latest()
            ->paginate();

        return new ManifestCollection($manifests);
    }

    /**
     * @param \App\Http\Requests\ManifestStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ManifestStoreRequest $request)
    {
        $this->authorize('create', Manifest::class);

        $validated = $request->validated();

        $manifest = Manifest::create($validated);

        return new ManifestResource($manifest);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Manifest $manifest
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Manifest $manifest)
    {
        $this->authorize('view', $manifest);

        return new ManifestResource($manifest);
    }

    /**
     * @param \App\Http\Requests\ManifestUpdateRequest $request
     * @param \App\Models\Manifest $manifest
     * @return \Illuminate\Http\Response
     */
    public function update(ManifestUpdateRequest $request, Manifest $manifest)
    {
        $this->authorize('update', $manifest);

        $validated = $request->validated();

        $manifest->update($validated);

        return new ManifestResource($manifest);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Manifest $manifest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Manifest $manifest)
    {
        $this->authorize('delete', $manifest);

        $manifest->delete();

        return response()->noContent();
    }
}
