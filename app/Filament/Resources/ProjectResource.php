<?php

namespace App\Filament\Resources;

use App\Models\Project;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use App\Filament\Resources\ProjectResource\Pages;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Tables\Columns\SpatieTagsColumn;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use RyanChandler\FilamentProgressColumn\ProgressColumn;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-view-boards';

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

                BelongsToSelect::make('client_id')
                    ->rules(['required', 'exists:clients,id'])
                    ->relationship('client', 'name')
                    ->searchable()
                    ->placeholder('Client')
                    ->columnSpan([
                        'default' => 6,
                        'md' => 6,
                        'lg' => 6,
                    ])->allowHtml(),

                TextInput::make('price')
                    ->rules(['required', 'numeric'])
                    ->numeric()
                    ->placeholder('Price')
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


                RichEditor::make('description')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Description')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
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
                // Tables\Columns\TextColumn::make('id'),
                Tables\Columns\ViewColumn::make('title')
                    ->sortable()->searchable(['title'])->view('tables.columns.title-with-tags')->toggleable(),
                Tables\Columns\TextColumn::make('client.name')->limit(50)->searchable()->toggleable()
                    ->url(fn ($record) => route('filament.resources.clients.edit', $record->client->id)),
                Tables\Columns\TextColumn::make('price')->toggleable(),
                // Tables\Columns\TextColumn::make('description')->limit(50),
                Tables\Columns\TextColumn::make('start_date')->date()->toggleable(),
                Tables\Columns\TextColumn::make('end_date')->date()->toggleable(),
                ProgressColumn::make('progress'),
                // SpatieTagsColumn::make('tags'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'danger' => 'closed',
                        'warning' => 'ongoing',
                        'secondary' => 'todo',
                        'success' => 'done',
                        // 'success' => fn ($state) => in_array($state, ['delivered', 'shipped']),
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

                MultiSelectFilter::make('client_id')->label('Client')->relationship(
                    'client',
                    'name'
                ),
                SelectFilter::make('status')
                    ->options([
                        'closed' => 'Closed',
                        'ongoing' => 'Ongoing',
                        'todo' => 'Todo',
                        'done' => 'Done',
                    ])
            ])
            ->actions([
                ViewAction::make()->iconButton(),
                EditAction::make()->modalWidth('xl')->iconButton(),
                DeleteAction::make()->iconButton(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // ProjectResource\RelationManagers\UsersRelationManager::class,
            ProjectResource\RelationManagers\TasksRelationManager::class,
            ProjectResource\RelationManagers\ExpensesRelationManager::class,
            ProjectResource\RelationManagers\InvoicesRelationManager::class,
            ProjectResource\RelationManagers\NotesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProjects::route('/'),
            // 'index' => Pages\ListProjects::route('/'),
            // 'view' => Pages\ProjectView::route('/view'),
            // 'create' => Pages\CreateProject::route('/create'),
            'view' => Pages\ViewProject::route('/{record}'),
            // 'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
