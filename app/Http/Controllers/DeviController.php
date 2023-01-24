<?php

namespace App\Http\Controllers;

use App\Models\Devi;
use App\Models\Client;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.devis.index', compact('devis', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Devi::class);

        $clients = Client::pluck('name', 'id');

        return view('app.devis.create', compact('clients'));
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

        return redirect()
            ->route('devis.edit', $devi)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Devi $devi
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Devi $devi)
    {
        $this->authorize('view', $devi);

        return view('app.devis.show', compact('devi'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Devi $devi
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Devi $devi)
    {
        $this->authorize('update', $devi);

        $clients = Client::pluck('name', 'id');

        return view('app.devis.edit', compact('devi', 'clients'));
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

        return redirect()
            ->route('devis.edit', $devi)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('devis.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
