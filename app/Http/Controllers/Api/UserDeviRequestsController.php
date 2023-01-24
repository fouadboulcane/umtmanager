<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeviRequestResource;
use App\Http\Resources\DeviRequestCollection;

class UserDeviRequestsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $deviRequests = $user
            ->deviRequests()
            ->search($search)
            ->latest()
            ->paginate();

        return new DeviRequestCollection($deviRequests);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', DeviRequest::class);

        $validated = $request->validate([
            'content' => ['nullable', 'max:255', 'json'],
            'manifest_id' => ['required', 'exists:manifests,id'],
            'client_id' => ['required', 'exists:clients,id'],
            'status' => ['required', 'in:pending,canceled,estimated,draft'],
        ]);

        $deviRequest = $user->deviRequests()->create($validated);

        return new DeviRequestResource($deviRequest);
    }
}
