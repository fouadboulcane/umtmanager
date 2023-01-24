@php $editing = isset($deviRequest) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea name="content" label="Content" maxlength="255"
            >{{ old('content', ($editing ? json_encode($deviRequest->content) :
            '')) }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="manifest_id" label="Manifest" required>
            @php $selected = old('manifest_id', ($editing ? $deviRequest->manifest_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Manifest</option>
            @foreach($manifests as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="client_id" label="Client" required>
            @php $selected = old('client_id', ($editing ? $deviRequest->client_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Client</option>
            @foreach($clients as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="user_id" label="Assigned Member" required>
            @php $selected = old('user_id', ($editing ? $deviRequest->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $deviRequest->status : '')) @endphp
            <option value="pending" {{ $selected == 'pending' ? 'selected' : '' }} >Pending</option>
            <option value="canceled" {{ $selected == 'canceled' ? 'selected' : '' }} >Canceled</option>
            <option value="estimated" {{ $selected == 'estimated' ? 'selected' : '' }} >Estimated</option>
            <option value="draft" {{ $selected == 'draft' ? 'selected' : '' }} >Draft</option>
        </x-inputs.select>
    </x-inputs.group>
</div>
