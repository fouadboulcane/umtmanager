@php $editing = isset($payment) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="date"
            label="Date"
            value="{{ old('date', ($editing ? optional($payment->date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="amount"
            label="Amount"
            value="{{ old('amount', ($editing ? $payment->amount : '')) }}"
            max="255"
            step="0.01"
            placeholder="Amount"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea name="note" label="Note" maxlength="255"
            >{{ old('note', ($editing ? $payment->note : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="mode" label="Mode">
            @php $selected = old('mode', ($editing ? $payment->mode : '')) @endphp
            <option value="cash" {{ $selected == 'cash' ? 'selected' : '' }} >Cash</option>
            <option value="postal_check" {{ $selected == 'postal_check' ? 'selected' : '' }} >Postal check</option>
            <option value="bank_check" {{ $selected == 'bank_check' ? 'selected' : '' }} >Bank check</option>
            <option value="bank_transfer" {{ $selected == 'bank_transfer' ? 'selected' : '' }} >Bank transfer</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="invoice_id" label="Invoice" required>
            @php $selected = old('invoice_id', ($editing ? $payment->invoice_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Invoice</option>
            @foreach($invoices as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
