@php $editing = isset($client) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $client->name : '')) }}"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="address"
            label="Address"
            value="{{ old('address', ($editing ? $client->address : '')) }}"
            maxlength="255"
            placeholder="Address"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="city"
            label="City"
            value="{{ old('city', ($editing ? $client->city : '')) }}"
            maxlength="255"
            placeholder="City"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="state"
            label="State"
            value="{{ old('state', ($editing ? $client->state : '')) }}"
            maxlength="255"
            placeholder="State"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="zipcode"
            label="Zipcode"
            value="{{ old('zipcode', ($editing ? $client->zipcode : '')) }}"
            maxlength="255"
            placeholder="Zipcode"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="website"
            label="Website"
            value="{{ old('website', ($editing ? $client->website : '')) }}"
            maxlength="255"
            placeholder="Website"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="tva_number"
            label="Tva Number"
            value="{{ old('tva_number', ($editing ? $client->tva_number : '')) }}"
            maxlength="255"
            placeholder="Tva Number"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="currency_id" label="Currency">
            @php $selected = old('currency_id', ($editing ? $client->currency_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Currency</option>
            @foreach($currencies as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="rc"
            label="Rc"
            value="{{ old('rc', ($editing ? $client->rc : '')) }}"
            maxlength="255"
            placeholder="Rc"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="nif"
            label="Nif"
            value="{{ old('nif', ($editing ? $client->nif : '')) }}"
            maxlength="255"
            placeholder="Nif"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="art"
            label="Art"
            value="{{ old('art', ($editing ? $client->art : '')) }}"
            maxlength="255"
            placeholder="Art"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.checkbox
            name="online_payment"
            label="Online Payment"
            :checked="old('online_payment', ($editing ? $client->online_payment : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>
</div>
