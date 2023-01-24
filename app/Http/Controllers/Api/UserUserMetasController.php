<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserMetaResource;
use App\Http\Resources\UserMetaCollection;

class UserUserMetasController extends Controller
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

        $userMetas = $user
            ->userMetas()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserMetaCollection($userMetas);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', UserMeta::class);

        $validated = $request->validate([
            'address' => ['nullable', 'max:255', 'string'],
            'address2' => ['nullable', 'max:255', 'string'],
            'phone' => ['nullable', 'max:255', 'string'],
            'gender' => ['required', 'in:male,female'],
            'birthdate' => ['nullable', 'date'],
        ]);

        $userMeta = $user->userMetas()->create($validated);

        return new UserMetaResource($userMeta);
    }
}
