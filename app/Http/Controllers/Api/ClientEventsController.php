<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Resources\EventCollection;

class ClientEventsController extends Controller
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

        $events = $client
            ->events()
            ->search($search)
            ->latest()
            ->paginate();

        return new EventCollection($events);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Client $client)
    {
        $this->authorize('create', Event::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'placement' => ['nullable', 'max:20', 'string'],
            'share_with' => ['required', 'in:only_me,all_members,few_members'],
            'color' => ['required'],
            'repeat' => ['required', 'boolean'],
            'status' => ['required', 'boolean'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $event = $client->events()->create($validated);

        return new EventResource($event);
    }
}
