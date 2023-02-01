@php 
$contacts = $getRecord()->contacts
@endphp

<div class="">
    @if($contacts)
    <div class="flex items-center">
        @foreach($contacts as $contact)
        <div class="flex items-center justify-center w-9 h-9 -mx-2 overflow-hidden rounded-full border-2 border-white">
            <img
                class="bg-white"
                @if(!$contact->avatar_url) 
                src="{{ \Filament\Facades\Filament::getUserAvatarUrl($contact) }}"
                @else 
                src="{{ Storage::url('public/' . $contact->avatar_url) }}"
                @endif
                x-tooltip="'{{ $contact->fullname }}'"
            >
        </div>
        @endforeach
    </div>
    @endif
</div>