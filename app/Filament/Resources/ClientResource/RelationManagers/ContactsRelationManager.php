<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

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
use App\Filament\Resources\ClientResource\Pages;
use Awcodes\FilamentBadgeableColumn\Components\Badge;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;
use Awcodes\FilamentBadgeableColumn\Components\BadgeableColumn;
use Awcodes\FilamentBadgeableColumn\Components\BadgeField;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Radio;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\DetachAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Phpsa\FilamentPasswordReveal\Password;

class ContactsRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'contacts';

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
                    ->required(
                        fn(Component $livewire) => $livewire instanceof
                            Pages\CreateUser
                    )
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                BadgeableColumn::make('name')->limit(50)
                ->badges([
                    Badge::make('mainContact')
                        ->label('Main Contact')
                        ->color('success')
                        ->visible(fn ($record): bool => $record->main_contact == 1),
                ]),
                Tables\Columns\BadgeColumn::make('teamMember.job_title')->label('Job Title'),
                Tables\Columns\TextColumn::make('email')->limit(50),
                Tables\Columns\TextColumn::make('userMeta.phone')->label('Phone'),
                Tables\Columns\TextColumn::make('teamMember.job_title')->limit(
                    50
                ),
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

                // MultiSelectFilter::make('team_member_id')->relationship(
                //     'teamMember',
                //     'job_title'
                // ),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->icon('heroicon-o-mail')->modalWidth('xl')
                    ->form([
                        Grid::make(2)->schema([
                            TextInput::make('first_name')->required()
                                ->columnSpan(1),
                            TextInput::make('last_name')->required()
                                ->columnSpan(1),
                            TextInput::make('email')->email()->required()
                                ->columnSpan(2),
                            Grid::make(2)->schema([
                                TextInput::make('phone')
                                    ->columnSpan(1), 
                                Select::make('gender')
                                    ->options([
                                        'male' => 'Male',
                                        'female' => 'Female'
                                    ])
                                    ->default('male'),
                            ])->relationship('userMeta'),
                            Grid::make(1)->schema([
                                TextInput::make('job_title')
                                ->columnSpan(1),
                            ])->relationship('teamMember'),
                            
                            Password::make('password')->autocomplete('new_password')
                                ->copyable()->generatable()->columnSpan(2),
                            Checkbox::make('send_info')->label('Send login informations to this user')
                                ->columnSpan(2)
                        ])

                    ]),
                Tables\Actions\AttachAction::make()
                    ->label('Attach Contact')
                    // ->recordSelectOptionsQuery(function() {
                    //     return User::doctors();
                    // })
                    ->preloadRecordSelect()
                    ->form(fn (AttachAction $action): array  => [
                        $action->getRecordSelect(),
                        Toggle::make('main_contact')->label('Main Contact')
                    ])
                    ->icon('heroicon-o-plus')
                    ->before(function($data, $livewire) {
                        if($data['main_contact'] == true) {
                            DB::table('client_user')
                                ->where('client_id', $livewire->ownerRecord->id)
                                ->update(['main_contact' => 0]);
                        }
                    })
                ])
            ->actions([
                DetachAction::make()->label('Remove'),
                Action::make('setAsMain')->label('Set as Main')
                    ->action(function($livewire, $record) {
                        DB::table('client_user')
                                    ->where('client_id', $livewire->ownerRecord->id)
                                    ->update(['main_contact' => 0]);
                        DB::table('client_user')
                                    ->where('client_id', $livewire->ownerRecord->id)
                                    ->where('user_id', $record->user_id)
                                    ->update(['main_contact' => 1]);
                    })->icon('heroicon-o-user')
                // ActionGroup::make([
                    
                // ])
            ]);
    }
}
