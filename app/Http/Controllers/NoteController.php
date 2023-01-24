<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Http\Requests\NoteStoreRequest;
use App\Http\Requests\NoteUpdateRequest;

class NoteController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Note::class);

        $search = $request->get('search', '');

        $notes = Note::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.notes.index', compact('notes', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Note::class);

        return view('app.notes.create');
    }

    /**
     * @param \App\Http\Requests\NoteStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(NoteStoreRequest $request)
    {
        $this->authorize('create', Note::class);

        $validated = $request->validated();

        $note = Note::create($validated);

        return redirect()
            ->route('notes.edit', $note)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Note $note
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Note $note)
    {
        $this->authorize('view', $note);

        return view('app.notes.show', compact('note'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Note $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Note $note)
    {
        $this->authorize('update', $note);

        return view('app.notes.edit', compact('note'));
    }

    /**
     * @param \App\Http\Requests\NoteUpdateRequest $request
     * @param \App\Models\Note $note
     * @return \Illuminate\Http\Response
     */
    public function update(NoteUpdateRequest $request, Note $note)
    {
        $this->authorize('update', $note);

        $validated = $request->validated();

        $note->update($validated);

        return redirect()
            ->route('notes.edit', $note)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Note $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Note $note)
    {
        $this->authorize('delete', $note);

        $note->delete();

        return redirect()
            ->route('notes.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
