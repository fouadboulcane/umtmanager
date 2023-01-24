<?php

namespace App\Http\Controllers;

use App\Models\Manifest;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.manifests.index', compact('manifests', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Manifest::class);

        return view('app.manifests.create');
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

        return redirect()
            ->route('manifests.edit', $manifest)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Manifest $manifest
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Manifest $manifest)
    {
        $this->authorize('view', $manifest);

        return view('app.manifests.show', compact('manifest'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Manifest $manifest
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Manifest $manifest)
    {
        $this->authorize('update', $manifest);

        return view('app.manifests.edit', compact('manifest'));
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

        return redirect()
            ->route('manifests.edit', $manifest)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('manifests.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
