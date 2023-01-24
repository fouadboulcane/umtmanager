@php $editing = isset($category) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="title"
            label="Title"
            value="{{ old('title', ($editing ? $category->title : '')) }}"
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
            >{{ old('description', ($editing ? $category->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="sort"
            label="Sort"
            value="{{ old('sort', ($editing ? $category->sort : '')) }}"
            max="255"
            placeholder="Sort"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="type" label="Type">
            @php $selected = old('type', ($editing ? $category->type : '')) @endphp
            <option value="help" {{ $selected == 'help' ? 'selected' : '' }} >Help</option>
            <option value="base_knowledge" {{ $selected == 'base_knowledge' ? 'selected' : '' }} >Base knowledge</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $category->status : '')) @endphp
            <option value="active" {{ $selected == 'active' ? 'selected' : '' }} >Active</option>
            <option value="inactive" {{ $selected == 'inactive' ? 'selected' : '' }} >Inactive</option>
        </x-inputs.select>
    </x-inputs.group>
</div>
