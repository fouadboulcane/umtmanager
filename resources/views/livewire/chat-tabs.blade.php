

<?php 
    $filters = array([
            'name' => 'received', 
            'label' => 'Inbox'
        ],
        [
            'name' => 'sent',
            'label' => 'Sent'
        ]
    );
?>

<div class="p-2">
    <div class="flex">
        @foreach($filters as $key => $filter)
        <div wire:key="{{ $key }}" @class([
            'flex items-center px-2 h-10 text-gray-500 cursor-pointer font-semibold',
            'dark:text-gray-400' => config('filament.dark_mode'), 
            '!text-primary-400' => $this->msgtype == $filter['name']
        ]) 
        wire:click="$set('msgtype', '{{ $filter['name'] }}')"
        >
            {{ $filter['label'] }}
        </div>
        @endforeach        
    </div>
</div>
