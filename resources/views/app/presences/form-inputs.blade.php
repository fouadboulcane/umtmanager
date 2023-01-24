@php $editing = isset($presence) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.datetime
            name="arrival_date"
            label="Arrival Date"
            value="{{ old('arrival_date', ($editing ? optional($presence->arrival_date)->format('Y-m-d\TH:i:s') : '')) }}"
            max="255"
            required
        ></x-inputs.datetime>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.datetime
            name="departure_date"
            label="Departure Date"
            value="{{ old('departure_date', ($editing ? optional($presence->departure_date)->format('Y-m-d\TH:i:s') : '')) }}"
            max="255"
            required
        ></x-inputs.datetime>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea name="note" label="Note" maxlength="255" required
            >{{ old('note', ($editing ? $presence->note : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="user_id" label="Team Member" required>
            @php $selected = old('user_id', ($editing ? $presence->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
