<?php

namespace App\Http\Controllers\Api;

use App\Models\Manifest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeviRequestResource;
use App\Http\Resources\DeviRequestCollection;

class ManifestDeviRequestsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Manifest $manifest
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Manifest $manifest)
    {
        $this->authorize('view', $manifest);

        $search = $request->get('search', '');

        $deviRequests = $manifest
            ->deviRequests()
            ->search($search)
            ->latest()
            ->paginate();

        return new DeviRequestCollection($deviRequests);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Manifest $manifest
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Manifest $manifest)
    {
        $this->authorize('create', DeviRequest::class);

        $validated = $request->validate([
            'content' => ['nullable', 'max:255', 'json'],
            'client_id' => ['required', 'exists:clients,id'],
            'user_id' => ['required', 'exists:users,id'],
            'status' => ['required', 'in:pending,canceled,estimated,draft'],
        ]);

        $deviRequest = $manifest->deviRequests()->create($validated);

        return new DeviRequestResource($deviRequest);
    }
}
