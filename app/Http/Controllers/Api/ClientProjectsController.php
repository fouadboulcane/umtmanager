<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ProjectCollection;

class ClientProjectsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Client $client)
    {
        $this->authorize('view', $client);

        $search = $request->get('search', '');

        $projects = $client
            ->projects()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProjectCollection($projects);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Client $client)
    {
        $this->authorize('create', Project::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'price' => ['required', 'numeric'],
        ]);

        $project = $client->projects()->create($validated);

        return new ProjectResource($project);
    }
}
