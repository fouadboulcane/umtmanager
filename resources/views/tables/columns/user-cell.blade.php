@php 
@endphp
<div class="flex align-items-center">
    <img 
        class="rounded-full h-12 w-12  object-cover" 
        {{-- src="{{ Storage::url('public/' . $getRecord()->avatar_url) }}" --}}
        @if(!$getRecord()->avatar_url)
        src="{{ \Filament\Facades\Filament::getUserAvatarUrl($getRecord()) }}" 
        @else 
        src="{{ Storage::url('public/' . $getRecord()->avatar_url) }}"
        @endif
        alt="Profile Img"
    >
    <div class="pl-3 py-1">
        <div class="text-md">{{ $getRecord()->fullname }}</div>
        <div class="text-sm text-gray-500">{{ $getRecord()->email }}</div>
    </div>
</div>