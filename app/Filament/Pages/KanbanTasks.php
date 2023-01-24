<?php

namespace App\Filament\Pages;

use App\Models\Task;
use Illuminate\Support\Collection;
use InvadersXX\FilamentKanbanBoard\Pages\FilamentKanbanBoard;

class KanbanTasks extends FilamentKanbanBoard
{
    protected static ?string $navigationGroup = 'Projects';

    public bool $sortable = true;
    public bool $sortableBetweenStatuses = true;

    protected function statuses() : Collection
    {
        return collect([
            [
                'id' => 'todo',
                'title' => 'Todo',
            ],
            [
                'id' => 'ongoing',
                'title' => 'Ongoing',
            ],
            [
                'id' => 'done',
                'title' => 'Done',
            ],
            [
                'id' => 'closed',
                'title' => 'Closed',
            ],
        ]);
    }

    protected function records() : Collection
    {
        return Task::all()
            ->map(function (Task $task) {
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'status' => $task->status,
                ];
            });
    }

    public function styles(): array
    {
        return [
            'wrapper' => 'w-full h-full flex space-x-4 overflow-x-auto bg-red-200',
            'kanbanWrapper' => 'h-full flex-1',
            'kanban' => 'bg-primary-200 rounded px-2 flex flex-col h-full',
            'kanbanHeader' => 'p-2 text-sm text-gray-900',
            'kanbanFooter' => '',
            'kanbanRecords' => 'space-y-2 p-2 flex-1 overflow-y-auto',
            'record' => 'shadow bg-white dark:bg-gray-800 p-2 rounded border',
            'recordContent' => 'w-full',
        ];
    }

}