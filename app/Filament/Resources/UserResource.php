<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Livewire\Component;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Filament\Forms\Components\BelongsToManyMultiSelect;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Tables\Filters\SelectFilter;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(12)->schema([
                FileUpload::make('avatar_url')->disableLabel()
                    ->extraAttributes(['class' => 'rounded-full w-16 h-16 mx-auto']),
                TextInput::make('first_name')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Name')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ])->inlineLabel(),

                TextInput::make('last_name')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Name')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ])->inlineLabel(),

                TextInput::make('email')
                    ->rules(['required', 'email'])
                    ->unique(
                        'users',
                        'email',
                        fn(?Model $record) => $record
                    )
                    ->email()
                    ->placeholder('Email')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ])->inlineLabel(),

                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn($state) => \Hash::make($state))
                    ->required(
                        fn(Component $livewire) => $livewire instanceof
                            Pages\CreateUser
                    )
                    ->placeholder('Password')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ])->inlineLabel(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('id'),
                // Tables\Columns\ImageColumn::make('avatar_url'),
                // Tables\Columns\TextColumn::make('fullname')->searchable()->sortable(),
                Tables\Columns\ViewColumn::make('name')->view('tables.columns.user-cell')->searchable(['first_name', 'last_name', 'email']),
                // Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\BadgeColumn::make('teamMember.job_title')->label('Job Title')->toggleable(),
                Tables\Columns\TextColumn::make('userMeta.phone')->label('Phone')->toggleable(),
                // Tables\Columns\TextColumn::make('teamMember.job_title')->limit(50),
                Tables\Columns\TagsColumn::make('roles.name')->limit(3),
                    // ->getStateUsing(fn ($state): string => $state->map(fn ($tag) => Str::headline($tag))),
                Tables\Columns\ToggleColumn::make('enable_login'),
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

                SelectFilter::make('roles')->relationship('roles', 'name')
                    ->options([
                        'user' => 'user'
                    ])

            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()->modalWidth('xl'),
                    Action::make('updateRoles')
                        ->label('Update Roles')
                        ->mountUsing(fn (Forms\ComponentContainer $form, User $record) => $form->fill([]))
                        ->action(function (User $record, array $data): void {
                            // $record->author()->associate($data['authorId']);
                            // $record->save();
                        })
                        ->form([
                            // Select::make('roles')
                            BelongsToManyMultiSelect::make('roles')
                            ->rules(['required', 'exists:roles,id'])
                            ->relationship('roles', 'name')
                            // ->searchable()
                            // ->multiple()
                            ->placeholder('Role')
                            ->columnSpan([
                                'default' => 12,
                                'md' => 12,
                                'lg' => 12,
                            ]),
                        ])
                        ->icon('heroicon-o-user'),
                    
                    // Tables\Actions\AttachAction::make()
                    // Action::make('newDeviRequest')
                    // ->action(fn ($record) => $record->advance())
                    // ->modalActions([]),
                    // Tables\Actions\EditAction::make('Attach role')
                    // ->label('Edit Role')
                    // ->form(fn (Tables\Actions\AttachAction $action): array => [
                    //     $action->getRecordSelect(),
                        
                    //     Forms\Components\Select::make('roles.name')->required(),
                    // ]),
                    

                    // Tables\Actinos\AttachAction::make()
                    // ->preloadRecordSelect(true)
                    // ->recordSelect(function (Select $select, RolesRelationManager $livewire) {
                    //     $excludedNames = collect([
                    //         /** Only superadmin can attach another superadmin */
                    //         \Auth::user()->hasRole('super_admin') ? null : 'super_admin',
                    //         /** Exclude already attached roles */
                    //         ...$livewire->getRelationship()->getParent()->roles->pluck('name')
                    //     ])->filter();

                    //     return $select
                    //         ->options(Role::whereNotIn('name', $excludedNames)->pluck('name', 'id'))
                    //         ->getSearchResultsUsing(fn ($search) => Role::query()
                    //             ->whereNotIn('name', $excludedNames)
                    //             ->where('name', 'like', "%{$search}%")
                    //             ->pluck('name', 'id '));
                    // }),
                    Tables\Actions\DeleteAction::make()
                ])
            ]);
    }

    public static function getRelations(): array
    {
        return [
            UserResource\RelationManagers\LeavesRelationManager::class,
            UserResource\RelationManagers\TicketsRelationManager::class,
            UserResource\RelationManagers\ExpensesRelationManager::class,
            UserResource\RelationManagers\EventsRelationManager::class,
            UserResource\RelationManagers\NotesRelationManager::class,
            UserResource\RelationManagers\PresencesRelationManager::class,
            UserResource\RelationManagers\AnouncementsRelationManager::class,
            UserResource\RelationManagers\SocialLinksRelationManager::class,
            UserResource\RelationManagers\UserMetasRelationManager::class,
            UserResource\RelationManagers\TasksRelationManager::class,
            UserResource\RelationManagers\DeviRequestsRelationManager::class,
            UserResource\RelationManagers\EventsRelationManager::class,
            UserResource\RelationManagers\ClientsRelationManager::class,
            UserResource\RelationManagers\TasksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
            'view' => Pages\ViewUser::route('/{record}'),
            // 'index' => Pages\ListUsers::route('/'),
            // 'create' => Pages\CreateUser::route('/create'),
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
