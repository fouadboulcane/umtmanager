<?php 
    // $messages = array(); 
?>

<x-filament::page>

    <div class="grid grid-cols-5 gap-4">
        <div class="col-span-2">
            <livewire:chat-messages>
        </div>


        <div class="col-span-3">
            @if(!empty($messages))
            <x-filament::card :class="'h-full'">
                @foreach($messages as $message)
                <div class="flex my-2 space-x-3 divide-y-1 divide-gray-50">
                    <div>
                        <img 
                        class="rounded-full"
                        @if(!$message->sender->avatar_url) 
                        src="{{ \Filament\Facades\Filament::getUserAvatarUrl($message->sender) }}"
                        @else 
                        src="{{ Storage::url('public/' . $message->sender->avatar_url) }}"
                        @endif
                        alt="">
                    </div>
                    <div class="w-full">
                        <div class="flex justify-between">
                            <div class="font-semibold">{{ $message->sender->name }}</div>
                            <div class="text-gray-400">{{ $message->sender->created_at->format('d-m-Y H:i') }}</div>
                        </div>
                        <div>
                            {{ $message->body }}
                        </div>
                    </div>
                </div>
                @endforeach
            </x-filament::card> 
            @else 
            <x-filament::card :class="'h-full flex justify-center items-center'">
                <div class="w-full h-full text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </x-filament::card> 
            @endif
        </div>
    </div>

</x-filament::page>
