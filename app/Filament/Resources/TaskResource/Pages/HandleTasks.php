<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use App\Models\Task;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\Page;
use Filament\Resources\Table;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\TextColumn;

class HandleTasks extends Page
{
    protected static string $resource = TaskResource::class;

    protected static string $view = 'filament.resources.task-resource.pages.handle-tasks';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    Grid::make()
                        ->schema([
                            Grid::make()
                                ->schema([
                                    // SpatieMediaLibraryImageColumn::make('image')
                                    //     ->collection('images')
                                    //     ->height('200px')
                                    //     ->extraAttributes([
                                    //         'style' => app()->getLocale() == 'ar' ? 'margin:-12px -16px 0px -40px' : 'margin:-12px -40px 0px -16px',
                                    //     ])
                                    //     ->extraImgAttributes([
                                    //         'class' => 'object-cover h-fit rounded-t-xl w-full',
                                    //     ]),
                                ])
                                ->columns(1),

                            Grid::make()
                                ->schema([
                                    TextColumn::make('name')
                                        ->searchable()
                                        ->extraAttributes([
                                            'class' => 'text-gray-500 dark:text-gray-300 text-xs'
                                        ])
                                        ->columnSpan(2),

                                    TextColumn::make('created_at')
                                        ->since()
                                        ->sortable()
                                        ->extraAttributes([
                                            'class' => 'text-gray-500 dark:text-gray-300 text-xs'
                                        ])
                                        ->alignEnd(),
                                ])
                                ->extraAttributes([
                                    'class' => 'mt-2 -mr-6 rtl:-ml-6 rtl:mr-0'
                                ])
                                ->columns(3),

                            Grid::make()
                                ->schema([
                                    TextColumn::make('created_by')
                                        ->default('Admin')
                                        ->extraAttributes([
                                            'class' => 'text-gray-500 dark:text-gray-300 text-xs'
                                        ])
                                        ->alignEnd(),
                                ])
                                ->extraAttributes([
                                    'class' => '-mr-6 rtl:-ml-6 rtl:mr-0'
                                ])
                                ->columns(1),

                            Grid::make()
                                ->schema([
                                    TextColumn::make('description')
                                        ->extraAttributes([
                                            'class' => 'text-gray-700 dark:text-gray-300 text-xs'
                                        ])
                                        ->alignJustify(),
                                ])
                                ->columns(1)
                                ->extraAttributes([
                                    'class' => 'mb-3 -mr-6 rtl:-ml-6 rtl:mr-0'
                                ]),
                        ])
                        ->columns(1),
                ]),
            ])
            ->defaultSort('created_by','desc')
            ->contentGrid([
                'md' => 2,
                'xl' => 4,
                '2xl' => 5,
            ]);
    }

}
