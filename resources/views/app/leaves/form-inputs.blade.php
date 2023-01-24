@php $editing = isset($leave) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="type" label="Type">
            @php $selected = old('type', ($editing ? $leave->type : '')) @endphp
            <option value="Casual Leave" {{ $selected == 'Casual Leave' ? 'selected' : '' }} >Casual leave</option>
            <option value="Maternity Leave" {{ $selected == 'Maternity Leave' ? 'selected' : '' }} >Maternity leave</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="duration" label="Duration">
            @php $selected = old('duration', ($editing ? $leave->duration : '')) @endphp
            <option value="One Day" {{ $selected == 'One Day' ? 'selected' : '' }} >One day</option>
            <option value="Multiple Days" {{ $selected == 'Multiple Days' ? 'selected' : '' }} >Multiple days</option>
            <option value="Hours" {{ $selected == 'Hours' ? 'selected' : '' }} >Hours</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="start_date"
            label="Start Date"
            value="{{ old('start_date', ($editing ? optional($leave->start_date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="end_date"
            label="End Date"
            value="{{ old('end_date', ($editing ? optional($leave->end_date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea name="reason" label="Reason" maxlength="255" required
            >{{ old('reason', ($editing ? $leave->reason : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
