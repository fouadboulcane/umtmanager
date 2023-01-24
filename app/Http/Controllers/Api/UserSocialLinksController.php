<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SocialLinkResource;
use App\Http\Resources\SocialLinkCollection;

class UserSocialLinksController extends Controller
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

        $socialLinks = $user
            ->socialLinks()
            ->search($search)
            ->latest()
            ->paginate();

        return new SocialLinkCollection($socialLinks);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', SocialLink::class);

        $validated = $request->validate([
            'facebook' => ['required', 'max:255', 'string'],
            'twitter' => ['required', 'max:255', 'string'],
            'linkedin' => ['required', 'max:255', 'string'],
            'google_plus' => ['required', 'max:255', 'string'],
            'digg' => ['required', 'max:255', 'string'],
            'youtube' => ['required', 'max:255', 'string'],
            'pinterest' => ['required', 'max:255', 'string'],
            'instagram' => ['required', 'max:255', 'string'],
            'github' => ['required', 'max:255', 'string'],
            'tumblr' => ['required', 'max:255', 'string'],
            'tiktok' => ['required', 'max:255', 'string'],
        ]);

        $socialLink = $user->socialLinks()->create($validated);

        return new SocialLinkResource($socialLink);
    }
}
