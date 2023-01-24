<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Manifest;
use App\Models\DeviRequest;
use Illuminate\Http\Request;
use App\Http\Requests\DeviRequestStoreRequest;
use App\Http\Requests\DeviRequestUpdateRequest;
use Illuminate\Support\Facades\Log;

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
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.devi_requests.index',
            compact('deviRequests', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', DeviRequest::class);

        $manifests = Manifest::pluck('title', 'id');
        $clients = Client::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.devi_requests.create',
            compact('manifests', 'clients', 'users')
        );
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

        return redirect()
            ->route('devi-requests.edit', $deviRequest)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DeviRequest $deviRequest
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DeviRequest $deviRequest)
    {
        $this->authorize('view', $deviRequest);

        return view('app.devi_requests.show', compact('deviRequest'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DeviRequest $deviRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, DeviRequest $deviRequest)
    {
        $this->authorize('update', $deviRequest);

        $manifests = Manifest::pluck('title', 'id');
        $clients = Client::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.devi_requests.edit',
            compact('deviRequest', 'manifests', 'clients', 'users')
        );
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

        return redirect()
            ->route('devi-requests.edit', $deviRequest)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('devi-requests.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
