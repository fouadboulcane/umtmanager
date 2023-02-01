<?php

namespace App\Filament\Resources;

use App\Models\Task;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TaskResource\Pages;
use App\Models\User;
use Closure;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Tables\Columns\SpatieTagsColumn;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-list';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationGroup = 'Projects';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(12)->schema([
                TextInput::make('title')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Title')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                RichEditor::make('description')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Description')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                BelongsToSelect::make('project_id')
                    ->rules(['required', 'exists:projects,id'])
                    ->relationship('project', 'title')
                    ->searchable()
                    ->placeholder('Project')
                    ->columnSpan([
                        'default' => 6,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                BelongsToSelect::make('member_id')
                    ->rules(['required', 'exists:users,id'])
                    ->relationship('assignedMember', 'name')
                    ->options(function (Closure $get) {
                        Log::info(User::findMany($get('members')));
                        // return $get('members');
                        return  User::findMany($get('members'))->pluck('name', 'id');
                    })
                    // ->options(function () {
                    //     return User::whereHas('roles', function($role) {
                    //         $role->where('name', '=', 'team_member');
                    //     })->pluck('name', 'id');
                    // })
                    // ->searchable()
                    ->placeholder('Assigned Member')
                    ->columnSpan([
                        'default' => 6,
                        'md' => 6,
                        'lg' => 6,
                    ]),


                BelongsToSelect::make('members')
                    ->rules(['exists:users,id'])
                    ->relationship('collabMembers', 'name')
                    ->options(function () {
                        return User::whereHas('roles', function($role) {
                            $role->where('name', '=', 'team_member');
                        })->pluck('name', 'id');
                    })
                    // ->searchable()
                    ->label('Collaborators')
                    ->placeholder('Collaborators')
                    ->multiple()
                    ->reactive()
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                Select::make('status')
                    ->rules(['required', 'in:todo,ongoing,done,closed'])
                    ->searchable()
                    ->options([
                        'todo' => 'Todo',
                        'ongoing' => 'Ongoing',
                        'done' => 'Done',
                        'closed' => 'Closed',
                    ])
                    ->placeholder('Status')
                    ->columnSpan([
                        'default' => 6,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                Select::make('difficulty')
                    ->rules(['required', 'in:1,2,3,4,5'])
                    ->searchable()
                    ->options([
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                    ])
                    ->placeholder('Difficulty')
                    ->columnSpan([
                        'default' => 6,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                DatePicker::make('start_date')
                    ->rules(['required', 'date'])
                    ->placeholder('Start Date')
                    ->columnSpan([
                        'default' => 6,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                DatePicker::make('end_date')
                    ->rules(['required', 'date'])
                    ->placeholder('End Date')
                    ->columnSpan([
                        'default' => 6,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                SpatieTagsInput::make('tags')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ViewColumn::make('title')
                    ->sortable()->searchable(['title'])->view('tables.columns.title-with-tags')->toggleable(),
                Tables\Columns\TextColumn::make('start_date')->date()->toggleable(),
                Tables\Columns\TextColumn::make('end_date')->date()->toggleable(),
                Tables\Columns\TextColumn::make('project.title')->limit(50)->url(fn ($record) => route('filament.resources.projects.view', $record->project->id))->toggleable()->searchable(),
                // Tables\Columns\TextColumn::make('assignedMember.fullname')->label('Assigned To')->toggleable()->searchable()->sortable(),
                Tables\Columns\ViewColumn::make('assignedMember')->view('tables.columns.avatar-name')->toggleable(),
                // Tables\Columns\TextColumn::make('description')->limit(50),
                Tables\Columns\TextColumn::make('difficulty')->enum([
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ])->toggleable(isToggledHiddenByDefault:true),

                Tables\Columns\BadgeColumn::make('status')->enum([
                    'todo' => 'Todo',
                    'ongoing' => 'Ongoing',
                    'done' => 'Done',
                    'closed' => 'Closed',
                ])->toggleable(),
            ])
            ->filters([
                // Tables\Filters\Filter::make('created_at')
                //     ->form([
                //         Forms\Components\DatePicker::make('created_from'),
                //         Forms\Components\DatePicker::make('created_until'),
                //     ])
                //     ->query(function (Builder $query, array $data): Builder {
                //         return $query
                //             ->when(
                //                 $data['created_from'],
                //                 fn(
                //                     Builder $query,
                //                     $date
                //                 ): Builder => $query->whereDate(
                //                     'created_at',
                //                     '>=',
                //                     $date
                //                 )
                //             )
                //             ->when(
                //                 $data['created_until'],
                //                 fn(
                //                     Builder $query,
                //                     $date
                //                 ): Builder => $query->whereDate(
                //                     'created_at',
                //                     '<=',
                //                     $date
                //                 )
                //             );
                //     }),

                MultiSelectFilter::make('project_id')->label('Project')->relationship(
                    'project',
                    'title'
                ),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->modalWidth('xl'),
                Tables\Actions\DeleteAction::make()
            ]);
    }

    public static function getRelations(): array
    {
        // return [];
        return [TaskResource\RelationManagers\UsersRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTasks::route('/'),
            // 'index' => Pages\ListTasks::route('/'),
            // 'create' => Pages\CreateTask::route('/create'),
            // 'edit' => Pages\EditTask::route('/{record}/edit'),
            // 'kanban-tasks' => Pages\KanbanTasks::route('/kanban'),
            // 'handle' => Pages\HandleTasks::route('/handle')
        ];
    }

    // public static function route(string $path): array
    // {
    //     return [
    //         'class' => static::class,
    //         'route' => $path,
    //     ];
    // }
}
