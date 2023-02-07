<?php 
    $user = $getRecord()->sender->id == Auth::id() ? $getRecord()->receiver : $getRecord()->sender;
?>

<div
    @class([
        'flex space-x-2 text-xs p-2 hover:bg-primary-600 hover:text-white cursor-pointer',
        'bg-red-500' => false
    ])
>
    <div class="flex-shrink-0">
        <img 
            class="rounded-full w-8 h-8" alt=""
            @if(!$user->avatar_url) 
            src="{{ \Filament\Facades\Filament::getUserAvatarUrl($user) }}"
            @else 
            src="{{ Storage::url('public/' . $user->avatar_url) }}"
            @endif
        >
    </div>
    <div class="w-full">
        <div class="flex justify-between">
            <div class="font-semibold">{{ $user->name }}</div>
            <div class="text-gray-600 dark:text-gray-400 hover:!text-white">{{ $getRecord()->created_at }}</div>
        </div>
        <div>
            {{ $getRecord()->subject }}
        </div>
    </div>
</div>