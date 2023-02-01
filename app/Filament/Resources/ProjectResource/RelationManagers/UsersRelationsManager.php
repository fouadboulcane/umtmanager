<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\{Form, Table};
use Livewire\Component;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Task;
use App\Models\User;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\HtmlString;

class UsersRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'projectMembers';
    // protected static string $relationship = 'tasks';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 0])->schema([
                TextInput::make('name')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Name')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('email')
                    ->rules(['required', 'email'])
                    ->unique('users', 'email', fn(?Model $record) => $record)
                    ->email()
                    ->placeholder('Email')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn($state) => \Hash::make($state))
                    // ->required(
                    //     fn(Component $livewire) => $livewire instanceof Pages\CreateUser)
                    ->placeholder('Password')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                // BelongsToSelect::make('team_member_id')
                //     ->rules(['nullable', 'exists:team_members,id'])
                //     ->relationship('teamMember', 'job_title')
                //     ->searchable()
                //     ->placeholder('Team Member')
                //     ->columnSpan([
                //         'default' => 12,
                //         'md' => 12,
                //         'lg' => 12,
                //     ]),
            ]),
        ]);
    }

    protected function getTableQuery(): Builder
    {
        $task_ids = Task::where('project_id', $this->ownerRecord->id)->pluck('id');
        $user_ids = DB::table('task_user')->whereIn('task_id', $task_ids)->pluck('user_id');
        return User::whereIn('id', $user_ids);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('name')->limit(50)
                //     ->formatStateUsing(
                //         fn (string $state): string => $state
                //     ),
                Tables\Columns\TextColumn::make('name')->limit(50),
                Tables\Columns\TextColumn::make('teamMember.job_title')->limit(
                    50
                ),
                ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '>=',
                                    $date
                                )
                            )
                            ->when(
                                $data['created_until'],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '<=',
                                    $date
                                )
                            );
                    }),

                MultiSelectFilter::make('team_member_id')->relationship(
                    'teamMember',
                    'job_title'
                ),
            ])
            // ->actions([])
            // ->headerActions([])
            ;

    }
}
