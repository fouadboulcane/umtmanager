@php $editing = isset($invoice) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="billing_date"
            label="Billing Date"
            value="{{ old('billing_date', ($editing ? optional($invoice->billing_date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="due_date"
            label="Due Date"
            value="{{ old('due_date', ($editing ? optional($invoice->due_date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="tax" label="Tax">
            @php $selected = old('tax', ($editing ? $invoice->tax : '')) @endphp
            <option value="dt" {{ $selected == 'dt' ? 'selected' : '' }} >Dt</option>
            <option value="tva_19%" {{ $selected == 'tva_19%' ? 'selected' : '' }} >Tva 19</option>
            <option value="tva_9%" {{ $selected == 'tva_9%' ? 'selected' : '' }} >Tva 9</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="tax2" label="Tax2">
            @php $selected = old('tax2', ($editing ? $invoice->tax2 : '')) @endphp
            <option value="dt" {{ $selected == 'dt' ? 'selected' : '' }} >Dt</option>
            <option value="tva_19%" {{ $selected == 'tva_19%' ? 'selected' : '' }} >Tva 19</option>
            <option value="tva_9%" {{ $selected == 'tva_9%' ? 'selected' : '' }} >Tva 9</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea name="note" label="Note" maxlength="255"
            >{{ old('note', ($editing ? $invoice->note : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.checkbox
            name="reccurent"
            label="Reccurent"
            :checked="old('reccurent', ($editing ? $invoice->reccurent : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $invoice->status : '')) @endphp
            <option value="paid" {{ $selected == 'paid' ? 'selected' : '' }} >Paid</option>
            <option value="canceled" {{ $selected == 'canceled' ? 'selected' : '' }} >Canceled</option>
            <option value="draft" {{ $selected == 'draft' ? 'selected' : '' }} >Draft</option>
            <option value="late" {{ $selected == 'late' ? 'selected' : '' }} >Late</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="project_id" label="Project" required>
            @php $selected = old('project_id', ($editing ? $invoice->project_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Project</option>
            @foreach($projects as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="client_id" label="Client" required>
            @php $selected = old('client_id', ($editing ? $invoice->client_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Client</option>
            @foreach($clients as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
