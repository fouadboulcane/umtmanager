<div
    @class([
        'flex space-x-2 text-xs p-2 hover:bg-primary-600 hover:text-white cursor-pointer',
        'bg-red-500' => false
    ])
>
    <div class="flex-shrink-0">
        <img 
            class="rounded-full w-8 h-8" alt=""
            @if(!$getRecord()->sender->avatar_url) 
            src="{{ \Filament\Facades\Filament::getUserAvatarUrl($getRecord()->sender) }}"
            @else 
            src="{{ Storage::url('public/' . $getRecord()->sender->avatar_url) }}"
            @endif
        >
    </div>
    <div class="w-full">
        <div class="flex justify-between">
            <div class="font-semibold">{{ $getRecord()->sender->name }}</div>
            <div class="">{{ $getRecord()->created_at }}</div>
        </div>
        <div>
            {{ $getRecord()->subject }}
        </div>
    </div>
</div>