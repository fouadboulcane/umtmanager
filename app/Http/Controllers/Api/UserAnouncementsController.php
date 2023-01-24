<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AnouncementResource;
use App\Http\Resources\AnouncementCollection;

class UserAnouncementsController extends Controller
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

        $anouncements = $user
            ->anouncements()
            ->search($search)
            ->latest()
            ->paginate();

        return new AnouncementCollection($anouncements);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Anouncement::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'content' => ['required', 'max:255', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'share_with' => ['required', 'in:all_members,all_clients'],
        ]);

        $anouncement = $user->anouncements()->create($validated);

        return new AnouncementResource($anouncement);
    }
}
