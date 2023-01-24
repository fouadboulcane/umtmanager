<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Pages\Actions;
use Filament\Pages\Actions\ActionGroup;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProject extends ViewRecord
{
    protected static string $resource = ProjectResource::class;

    protected static string $view = 'filament.resources.project-resource.pages.project-view';

    // protected ?string $heading = 'resources.components.header.heading'

    // protected ?string $subheading = view('resources.components.header.subheading');

    protected $showSection = false;

    public function getActions(): array 
    {
        return [
            ActionGroup::make([
                Actions\Action::make('Edit')->color('secondary')->icon('heroicon-o-check-circle'),
                Actions\Action::make('Edit')->color('secondary')->icon('heroicon-o-check-circle'),
            ]),
            Actions\Action::make('Edit')->color('secondary')->icon('heroicon-o-check-circle'),
            Actions\Action::make('Table')->color('secondary')->icon('heroicon-o-users')->url(route('filament.resources.projects.index')),
            CreateAction::make('createProject'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            Widgets\CustomerOverview::class,
        ];
    }
}
