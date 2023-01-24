<?php

namespace App\Http\Controllers\Api;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Http\Resources\NoteResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\NoteCollection;
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
            ->paginate();

        return new NoteCollection($notes);
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

        return new NoteResource($note);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Note $note
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Note $note)
    {
        $this->authorize('view', $note);

        return new NoteResource($note);
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

        return new NoteResource($note);
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

        return response()->noContent();
    }
}
