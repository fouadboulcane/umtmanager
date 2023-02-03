<?php

namespace App\Filament\Resources;

use App\Models\Client;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use App\Filament\Resources\ClientResource\Pages;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'Other';

    public function hasCombinedRelationManagersWithForm(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    TextInput::make('name')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Name')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('address')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Address')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('city')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('City')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('state')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('State')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('zipcode')
                        ->rules(['required', 'max:255'])
                        ->placeholder('Zipcode')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('website')
                        ->rules(['nullable', 'max:255', 'string'])
                        ->placeholder('Website')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('tva_number')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Tva Number')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    BelongsToSelect::make('currency_id')
                        ->rules(['nullable', 'exists:currencies,id'])
                        ->relationship('currency', 'name')
                        ->searchable()
                        ->placeholder('Currency')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('rc')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Rc')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('nif')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Nif')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('art')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Art')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Toggle::make('online_payment')
                        ->rules(['required', 'boolean'])
                        ->default('1')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Company Name')->limit(50)->searchable()->toggleable(),
                Tables\Columns\ViewColumn::make('mainContact')->label('Main Contact')->view('tables.columns.contact')->toggleable(),
                Tables\Columns\ViewColumn::make('contacts')->view('tables.columns.contacts')->toggleable(),
                Tables\Columns\BadgeColumn::make('projects_count')->label('Projects')->toggleable(),
                Tables\Columns\TextColumn::make('invoiceTotal')
                        ->label('Invoice Amount')
                        ->toggleable()->formatStateUsing(fn($record) => $record->invoiceAmount()),
                Tables\Columns\TextColumn::make('paidTotal')
                        ->label('Paid')
                        ->toggleable()->formatStateUsing(fn($record) => $record->paidAmount()),
                Tables\Columns\TextColumn::make('unpaidTotal')
                        ->label('Unpaid')
                        ->toggleable()->formatStateUsing(fn($record) => $record->unpaidAmount()),
                // Tables\Columns\TextColumn::make('paidAmount')->toggleable(),
                // Tables\Columns\TextColumn::make('unpaidAmount')->toggleable(),
                // Tables\Columns\TextColumn::make('city')->limit(50),
                // Tables\Columns\TextColumn::make('state')->limit(50),
                // Tables\Columns\TextColumn::make('zipcode')->limit(50),
                // Tables\Columns\TextColumn::make('website')->limit(50),
                // Tables\Columns\TextColumn::make('tva_number')->limit(50),
                // Tables\Columns\TextColumn::make('currency.name')->limit(50),
                Tables\Columns\TextColumn::make('rc')->limit(50)->toggleable(isToggledHiddenByDefault:true),
                Tables\Columns\TextColumn::make('nif')->limit(50)->toggleable(isToggledHiddenByDefault:true),
                Tables\Columns\TextColumn::make('art')->limit(50)->toggleable(isToggledHiddenByDefault:true),
                // Tables\Columns\BooleanColumn::make('online_payment'),
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

                MultiSelectFilter::make('currency_id')->relationship(
                    'currency',
                    'name'
                ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ClientResource\RelationManagers\ContactsRelationManager::class,
            ClientResource\RelationManagers\ProjectsRelationManager::class,
            ClientResource\RelationManagers\DevisRelationManager::class,
            ClientResource\RelationManagers\EventsRelationManager::class,
            ClientResource\RelationManagers\TicketsRelationManager::class,
            ClientResource\RelationManagers\InvoicesRelationManager::class,
            ClientResource\RelationManagers\DeviRequestsRelationManager::class,
            // ClientResource\RelationManagers\UsersRelationManager::class,
            ClientResource\RelationManagers\NotesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withCount('projects');
    }

    // public static function getLabel(): ?string 
    // {
    //     return __('Client');
    // }

    // public static function getPluralLabel(): ?string 
    // {
    //     return __('clients.name');
    // }
}
