<x-filament::page>

    <div class="grid grid-cols-5 gap-4">
        <div class="col-span-2">
            <livewire:chat-messages>
        </div>

        <div class="col-span-3">
            @if(!empty($conversation))
            <x-filament::card :class="'h-full px-0'">
                <div 
                @class([
                    'flex flex-col divide-y divide-gray-300',
                    'dark:divide-gray-700' => config('filament.dark_mode'),
                ])    
                class=" ">
                    <div class="flex my-2 space-x-3 divide-y-1 divide-gray-50 pb-4">
                        <div class="flex-shrink-0">
                            <img 
                            class="rounded-full w-12 h-12"
                            @if(!$conversation->sender->avatar_url) 
                            src="{{ \Filament\Facades\Filament::getUserAvatarUrl($conversation->sender) }}"
                            @else 
                            src="{{ Storage::url('public/' . $conversation->sender->avatar_url) }}"
                            @endif
                            alt="">
                        </div>
                        <div class="w-full">
                            <div class="flex justify-between mt-1">
                                <div class="flex flex-col justify-center space-y-0">
                                    <span class="font-semibold">{{ $conversation->sender->name }}</span>
                                    <span class="text-xs">Subject: {{ $conversation->subject }}</span>
                                </div>
                                <div class="flex space-x-2 items-center">
                                    <div 
                                        @class([
                                            'text-gray-600',
                                            'dark:text-gray-400' => config('filament.dark_mode'),
                                        ])>{{ $conversation->created_at->format('d-m-Y H:i') }}</div>
                                    
                                    <x-filament::dropdown placement="bottom-end">
                                        <x-slot name="trigger" class="ml-4">
                                            <button  @class([
                                                'flex flex-shrink-0 w-10 h-10 rounded-full hover:bg-gray-200 items-center justify-center',
                                                'dark:hover:bg-gray-900' => config('filament.dark_mode'),
                                            ]) aria-label="{{ __('filament::layout.buttons.user_menu.label') }}">
                                                @svg('heroicon-o-dots-vertical', 'w-4 h-4')
                                            </button>
                                        </x-slot>
                                        <x-filament::dropdown.list>
                                            {{-- @foreach() --}}
                                            <x-filament::dropdown.item
                                                :color="'danger'"
                                                :icon="'heroicon-o-trash'"
                                                {{-- :wire:click="'deleteConversation'" --}}
                                                x-on:click="$dispatch('open-modal', { id: 'delete-conv-modal'})"
                                                {{-- :href="$resource['url']" --}}
                                                {{-- :tag="$resource['url'] ? 'a' : 'button'" --}}
                                            >
                                                {{-- {{ $resource['label'] }} --}}
                                                Delete Conversation
                                            </x-filament::dropdown.item>
                                            {{-- @endforeach --}}
                                        </x-filament::dropdown.list>
                                    </x-filament::dropdown>
                                    
                                </div>
                            </div>
                            {{-- <div class="text-xs">Subject: {{ $conversation->subject }}</div> --}}
                            <div class="pt-3">{!! html_entity_decode($conversation->body) !!}</div>
                        </div>
                    </div>

                    @if ($hasMorePages)
                    <div class="text-center">
                        <button
                            @class([
                                'w-full hover:bg-gray-700 py-1 hover:bg-gray-200',
                                'dark:hover:bg-gray-900' => config('filament.dark_mode'),
                            ])
                            wire:click="loadComments"
                        >
                            Load More
                        </button>
                    </div>
                    @endif

                    @if(!$comments->isEmpty())
                    <div class="py-4 flex flex-col-reverse">
                        @foreach($comments as $key => $comment)
                        <div class="flex my-2 space-x-3 divide-y-1 divide-gray-50">
                            <div class="flex-shrink-0">
                                <img 
                                class="rounded-full w-12 h-12"
                                @if(!$comment->author->avatar_url) 
                                src="{{ \Filament\Facades\Filament::getUserAvatarUrl($comment->author) }}"
                                @else 
                                src="{{ Storage::url('public/' . $comment->author->avatar_url) }}"
                                @endif
                                alt="">
                            </div>
                            <div class="w-full">
                                <div class="flex justify-between">
                                    <div class="font-semibold">{{ $comment->author->name }}</div>
                                    <div @class(['text-gray-600', 'dark:text-gray-400' => config('filament.dark_mode'),])>{{ $comment->created_at->format('d-m-Y H:i') }}</div>
                                </div>
                                <div class="flex-wrap">
                                    {!! html_entity_decode($comment->body) !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    <div class="pt-4">
                        <form wire:submit.prevent="sendMessage">
                            {{ $this->form }}
                            <div class="flex pt-3 justify-end">
                                <x-filament::button type="submit" :icon="'heroicon-o-reply'" :size="'sm'">
                                    Reply
                                </x-filament::button>
                            </div>
                        </form>
                    </div>
                </div>
            </x-filament::card>

            <form wire:submit.prevent="deleteConversation">
                <x-filament::modal id="delete-conv-modal" :width="'sm'">

                        <p class="filament-modal-subheading text-gray-500">Are you sure you want to delete the conversation #{{ $conversation->id }}</p>

                        <x-slot name="footer">
                            <x-forms::modal.actions :class="'grid grid-cols-2 gap-2'">
                                <x-filament::button :color="'secondary'" type="button" x-on:click="$dispatch('close-modal', { id: 'delete-conv-modal'})">Cancel</x-filament::button>
                                <x-filament::button :color="'danger'" type="submit">Delete</x-filament::button>
                            </x-forms::modal.actions>
                        </x-slot>
                </x-filament::modal>
            </form>
            @else 
            <x-filament::card :class="'h-full flex justify-center items-center'">
                <div @class(['w-full h-full text-gray-100', 'dark:text-gray-700' => config('filament.dark_mode'),])>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </x-filament::card> 
            @endif
        </div>
    </div>  

</x-filament::page>


