<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Pages\Actions;
use Filament\Pages\Actions\CreateAction;
use Filament\Pages\Contracts\HasFormActions;
use Filament\Resources\Pages\Concerns\HasRecordBreadcrumb;
use Filament\Resources\Pages\Concerns\HasRelationManagers;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Concerns\UsesResourceForm;
use Filament\Resources\Pages\Page;
use Filament\Resources\Table;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\HtmlString;

class ProjectView extends Page
{
    protected static string $resource = ProjectResource::class;

    protected static string $view = 'filament.resources.project-resource.pages.project-view';

    // protected ?string $heading = 'resources.components.header.heading'

    // protected ?string $subheading = view('resources.components.header.subheading');

    public function getActions(): array 
    {
        return [
            Actions\Action::make('Edit')->color('secondary')->icon('heroicon-o-check-circle'),
            Actions\Action::make('Table')->color('secondary')->icon('heroicon-o-users')->url(route('filament.resources.projects.index')),
            CreateAction::make('createProject'),
        ];
    }

    public function getTableSchema(Table $table): Table 
    {
        return $table->columns([
            TextColumn::make('title')->limit(50)
                ->sortable()->searchable(),
            TextColumn::make('client.name')->limit(50),
            TextColumn::make('price'),
            // TextColumn::make('description')->limit(50),
            TextColumn::make('start_date')->date(),
            TextColumn::make('end_date')->date(),
            BadgeColumn::make('status')
                ->colors([
                    'danger' => 'closed',
                    'warning' => 'ongoing',
                    'secondary' => 'todo',
                    'success' => 'done',
                    // 'success' => fn ($state) => in_array($state, ['delivered', 'shipped']),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ProjectResource\RelationManagers\TasksRelationManager::class,
        ];
    }
}
