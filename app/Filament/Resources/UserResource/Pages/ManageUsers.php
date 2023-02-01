<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Forms\Components\BelongsToManyMultiSelect;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Component;

class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('inviteMember')->label('Invite New Members')
                    ->form([
                        Repeater::make('emails')->schema([
                            TextInput::make('email')->disableLabel()->email()->placeholder('Email')
                        ])
                        ->createItemButtonLabel('Add More')
                        ->collapsible()
                        ->itemLabel(fn (array $state): ?string => $state['email'] ?? 'text')
                        ->disableLabel(),

                    ])
                    ->action(function() {
                        return '';
                    })
                    ->color('secondary')
                    ->icon('heroicon-o-mail'),

            CreateAction::make()
                ->after(function() {
                    // Notification::make()
                    //     ->title('New Task Created')
                    //     ->success();
                })
                ->icon('heroicon-o-user-add')
                ->steps([
                    Step::make('General Infos')
                        ->description('Name, Address and Phone')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    TextInput::make('first_name'),
                                    TextInput::make('last_name'),
                                ]),
                            Grid::make(2)
                                ->relationship('userMeta')
                                ->schema([
                                    TextInput::make('address')->columnSpan(2),
                                    TextInput::make('phone'),
                                    Select::make('gender')
                                        ->options([
                                            'male' => 'Male',
                                            'female' => 'Female',
                                        ]),
                                    ]),
                        ]),
                        Step::make('Job Info')
                            ->description('Job, Salary, Recruitment Date')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('job_title'),
                                        TextInput::make('salary')->numeric(),
                                        TextInput::make('conditions'),
                                        DatePicker::make('recruitment_date'),
                                        TextInput::make('n_ss')->numeric()
                                    ])
                                    ->relationship('teamMember')
                            ]),
                        
                        Step::make('Account Settings')
                            ->description('Email, Password, Roles')
                            ->schema([
                                Hidden::make('avatar_url'),
                                TextInput::make('email')
                                    ->rules(['required', 'email'])
                                    ->unique(
                                        'users',
                                        'email',
                                        fn(?Model $record) => $record
                                    )
                                    ->email()
                                    ->placeholder('Email'),
                                TextInput::make('password')
                                    ->password()
                                    ->dehydrateStateUsing(fn($state) => \Hash::make($state))
                                    // ->required(fn(Component $livewire) => $livewire instanceof
                                    //         Pages\CreateUser
                                    // )
                                    ->placeholder('Password'),
                                BelongsToManyMultiSelect::make('roles')
                                    ->rules(['required', 'exists:roles,id'])
                                    ->relationship('roles', 'name')
                                    // ->searchable()
                                    // ->multiple()
                                    ->placeholder('Role')
                            ])
                    ]),
                
        ];
    }
}
