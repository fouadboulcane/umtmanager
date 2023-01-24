@php $editing = isset($devi) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="start_date"
            label="Start Date"
            value="{{ old('start_date', ($editing ? optional($devi->start_date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="end_date"
            label="End Date"
            value="{{ old('end_date', ($editing ? optional($devi->end_date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="tax" label="Tax">
            @php $selected = old('tax', ($editing ? $devi->tax : '')) @endphp
            <option value="dt" {{ $selected == 'dt' ? 'selected' : '' }} >Dt</option>
            <option value="tva_19%" {{ $selected == 'tva_19%' ? 'selected' : '' }} >Tva 19</option>
            <option value="tva_9%" {{ $selected == 'tva_9%' ? 'selected' : '' }} >Tva 9</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="tax2" label="Tax2">
            @php $selected = old('tax2', ($editing ? $devi->tax2 : '')) @endphp
            <option value="dt" {{ $selected == 'dt' ? 'selected' : '' }} >Dt</option>
            <option value="tva_19%" {{ $selected == 'tva_19%' ? 'selected' : '' }} >Tva 19</option>
            <option value="tva_9%" {{ $selected == 'tva_9%' ? 'selected' : '' }} >Tva 9</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea name="note" label="Note" maxlength="255"
            >{{ old('note', ($editing ? $devi->note : '')) }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="client_id" label="Client" required>
            @php $selected = old('client_id', ($editing ? $devi->client_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Client</option>
            @foreach($clients as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
