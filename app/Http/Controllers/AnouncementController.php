<?php

namespace App\Http\Controllers;

use App\Models\Anouncement;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.anouncements.index',
            compact('anouncements', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Anouncement::class);

        return view('app.anouncements.create');
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

        return redirect()
            ->route('anouncements.edit', $anouncement)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Anouncement $anouncement
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Anouncement $anouncement)
    {
        $this->authorize('view', $anouncement);

        return view('app.anouncements.show', compact('anouncement'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Anouncement $anouncement
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Anouncement $anouncement)
    {
        $this->authorize('update', $anouncement);

        return view('app.anouncements.edit', compact('anouncement'));
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

        return redirect()
            ->route('anouncements.edit', $anouncement)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('anouncements.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
