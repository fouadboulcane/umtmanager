@php $editing = isset($currency) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $currency->name : '')) }}"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="symbol"
            label="Symbol"
            value="{{ old('symbol', ($editing ? $currency->symbol : '')) }}"
            maxlength="255"
            placeholder="Symbol"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
