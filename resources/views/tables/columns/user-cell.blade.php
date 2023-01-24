@php 
@endphp



<div class="flex align-items-center">
    <img class="rounded-full h-12 w-12  object-cover" src="https://images.unsplash.com/photo-1613588718956-c2e80305bf61?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=634&q=80" alt="unsplash image">
    <div class="pl-3 py-1">
        <div class="text-md">{{ $getRecord()->name }}</div>
        <div class="text-sm text-gray-500">{{ $getRecord()->email }}</div>
    </div>
</div>