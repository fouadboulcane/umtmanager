<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Collection;
use InvadersXX\FilamentKanbanBoard\Pages\FilamentKanbanBoard;

class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

}
