@php
$items = $getItems()
@endphp
<div {{ $attributes }}>
    {{ $getChildComponentContainer() }}
    
    <div class="flex justify-center">
        <ul class="bg-white rounded-lg border border-gray-200 w-full text-gray-900">
        @foreach($items as $item)
            {{-- <a href="google.com">{{ $item['title'] }}</a> --}}
            <li class="px-6 py-2 w-full @if($loop->first) border-b border-gray-200 rounded-t-lg @elseif($loop->last) rounded-b-lg @else border-b border-gray-200 @endif">
                <a class="text-primary-600" href="{{ route('filament.resources.devi-requests.create', ['manifest_id' => $item['id']]) }}">{{ $item['title'] }}</a>
            </li>
        @endforeach
          {{-- <li class="px-6 py-2 border-b border-gray-200 w-full">A second item</li>
          <li class="px-6 py-2 border-b border-gray-200 w-full">A third item</li>
          <li class="px-6 py-2 border-b border-gray-200 w-full">A fourth item</li> --}}
          {{-- <li class="px-6 py-2 w-full rounded-b-lg">And a fifth one</li> --}}
        </ul>
    </div>
</div>
