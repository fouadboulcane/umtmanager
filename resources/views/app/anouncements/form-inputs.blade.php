@php $editing = isset($anouncement) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="title"
            label="Title"
            value="{{ old('title', ($editing ? $anouncement->title : '')) }}"
            maxlength="255"
            placeholder="Title"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea
            name="content"
            label="Content"
            maxlength="255"
            required
            >{{ old('content', ($editing ? $anouncement->content : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="start_date"
            label="Start Date"
            value="{{ old('start_date', ($editing ? optional($anouncement->start_date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="end_date"
            label="End Date"
            value="{{ old('end_date', ($editing ? optional($anouncement->end_date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="share_with" label="Share With">
            @php $selected = old('share_with', ($editing ? $anouncement->share_with : '')) @endphp
            <option value="all_members" {{ $selected == 'all_members' ? 'selected' : '' }} >All members</option>
            <option value="all_clients" {{ $selected == 'all_clients' ? 'selected' : '' }} >All clients</option>
        </x-inputs.select>
    </x-inputs.group>
</div>
