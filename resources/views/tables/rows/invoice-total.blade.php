@php 

@endphp

<tr>
    <td></td>
    <td></td>
    <td class="px-4 py-3">{{ $records->sum('total') }}</td>
    <td class="px-4 py-3">{{ $records->sum('paid') }}</td>
    <td></td>
    <td></td>
</tr>