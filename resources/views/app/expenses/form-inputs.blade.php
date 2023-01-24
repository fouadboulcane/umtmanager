@php $editing = isset($expense) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="title"
            label="Title"
            value="{{ old('title', ($editing ? $expense->title : '')) }}"
            maxlength="255"
            placeholder="Title"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            required
            >{{ old('description', ($editing ? $expense->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="amount"
            label="Amount"
            value="{{ old('amount', ($editing ? $expense->amount : '')) }}"
            max="255"
            step="0.01"
            placeholder="Amount"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="date"
            label="Date"
            value="{{ old('date', ($editing ? optional($expense->date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="category" label="Category">
            @php $selected = old('category', ($editing ? $expense->category : '')) @endphp
            <option value="Miscellaneous Expense" {{ $selected == 'Miscellaneous Expense' ? 'selected' : '' }} >Miscellaneous expense</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="tax" label="Tax">
            @php $selected = old('tax', ($editing ? $expense->tax : '')) @endphp
            <option value="DT" {{ $selected == 'DT' ? 'selected' : '' }} >Dt</option>
            <option value="TVA 19%" {{ $selected == 'TVA 19%' ? 'selected' : '' }} >Tva 19</option>
            <option value="TVA 9%" {{ $selected == 'TVA 9%' ? 'selected' : '' }} >Tva 9</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="tax2" label="Tax2">
            @php $selected = old('tax2', ($editing ? $expense->tax2 : '')) @endphp
            <option value="DT" {{ $selected == 'DT' ? 'selected' : '' }} >Dt</option>
            <option value="TVA 19%" {{ $selected == 'TVA 19%' ? 'selected' : '' }} >Tva 19</option>
            <option value="TVA 9%" {{ $selected == 'TVA 9%' ? 'selected' : '' }} >Tva 9</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="project_id" label="Project" required>
            @php $selected = old('project_id', ($editing ? $expense->project_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Project</option>
            @foreach($projects as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="user_id" label="Team Member" required>
            @php $selected = old('user_id', ($editing ? $expense->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
