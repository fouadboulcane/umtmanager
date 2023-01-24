@php $editing = isset($post) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="title"
            label="Title"
            value="{{ old('title', ($editing ? $post->title : '')) }}"
            maxlength="255"
            placeholder="Title"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea
            name="content"
            label="Content"
            maxlength="255"
            required
            >{{ old('content', ($editing ? $post->content : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="type" label="Type">
            @php $selected = old('type', ($editing ? $post->type : '')) @endphp
            <option value="help" {{ $selected == 'help' ? 'selected' : '' }} >Help</option>
            <option value="base_knowledge" {{ $selected == 'base_knowledge' ? 'selected' : '' }} >Base knowledge</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $post->status : '')) @endphp
            <option value="active" {{ $selected == 'active' ? 'selected' : '' }} >Active</option>
            <option value="inactive" {{ $selected == 'inactive' ? 'selected' : '' }} >Inactive</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="category_id" label="Category" required>
            @php $selected = old('category_id', ($editing ? $post->category_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Category</option>
            @foreach($categories as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
