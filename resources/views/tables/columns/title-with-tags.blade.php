@php 
$tags = $getRecord()->tags
@endphp

<div class="p-2">
    <div class="flex flex-col">
        <div>{{ $getState() }}</div>
        @if($tags)
        <div class="flex space-x-1">
            @foreach($tags as $tag)
            <div>
                <span class="bg-primary-50 text-primary-600 font-semibold text-xs font-medium px-2 py-0.5 pt-0 rounded-sm dark:bg-primary-900 dark:text-primary-300">{{ $tag->name }}</span>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>