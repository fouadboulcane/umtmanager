@props([
    'user' => $getState()
])



<div class="">
    @if($user)
    <div class="flex items-center">
        <div class="flex items-center justify-center w-9 h-9 mr-1 overflow-hidden rounded-full border-2 border-white">
            <img
                class="bg-white"
                @if(!$user->avatar_url) 
                src="{{ \Filament\Facades\Filament::getUserAvatarUrl($user) }}"
                @else 
                src="{{ Storage::url('public/' . $user->avatar_url) }}"
                @endif
            >
        </div>
        <div><a href="{{ route('filament.resources.users.view', $user->id) }}">{{ $user->fullname }}</a></div>
    </div>
    @endif
</div>