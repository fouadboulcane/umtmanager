@php $editing = isset($task) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="title"
            label="Title"
            value="{{ old('title', ($editing ? $task->title : '')) }}"
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
            >{{ old('description', ($editing ? $task->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="difficulty" label="Difficulty">
            @php $selected = old('difficulty', ($editing ? $task->difficulty : '')) @endphp
            <option value="1" {{ $selected == '1' ? 'selected' : '' }} >1</option>
            <option value="2" {{ $selected == '2' ? 'selected' : '' }} >2</option>
            <option value="3" {{ $selected == '3' ? 'selected' : '' }} >3</option>
            <option value="4" {{ $selected == '4' ? 'selected' : '' }} >4</option>
            <option value="5" {{ $selected == '5' ? 'selected' : '' }} >5</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="project_id" label="Project" required>
            @php $selected = old('project_id', ($editing ? $task->project_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Project</option>
            @foreach($projects as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $task->status : '')) @endphp
            <option value="todo" {{ $selected == 'todo' ? 'selected' : '' }} >Todo</option>
            <option value="ongoing" {{ $selected == 'ongoing' ? 'selected' : '' }} >Ongoing</option>
            <option value="done" {{ $selected == 'done' ? 'selected' : '' }} >Done</option>
            <option value="closed" {{ $selected == 'closed' ? 'selected' : '' }} >Closed</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="start_date"
            label="Start Date"
            value="{{ old('start_date', ($editing ? optional($task->start_date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="end_date"
            label="End Date"
            value="{{ old('end_date', ($editing ? optional($task->end_date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>
</div>
