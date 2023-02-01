<?php

namespace App\Filament\Resources;

use App\Models\Devi;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DeviResource\Pages;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;

class DeviResource extends Resource
{
    protected static ?string $model = Devi::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'start_date';

    protected static ?string $navigationGroup = 'Devis';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(12)->schema([
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

                Select::make('tax')
                    ->rules(['nullable', 'in:dt,tva_19%,tva_9%'])
                    ->searchable()
                    ->options([
                        'dt' => 'DT',
                        'tva_19%' => 'TVA 19',
                        'tva_9%' => 'TVA 9',
                    ])
                    ->placeholder('Tax')
                    ->columnSpan([
                        'default' => 6,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                Select::make('tax2')
                    ->rules(['nullable', 'in:dt,tva_19%,tva_9%'])
                    ->searchable()
                    ->options([
                        'dt' => 'DT',
                        'tva_19%' => 'TVA 19',
                        'tva_9%' => 'TVA 9',
                    ])
                    ->placeholder('Tax2')
                    ->columnSpan([
                        'default' => 6,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                BelongsToSelect::make('client_id')
                    ->rules(['required', 'exists:clients,id'])
                    ->relationship('client', 'name')
                    ->searchable()
                    ->placeholder('Client')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                RichEditor::make('note')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Note')
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
                Tables\Columns\TextColumn::make('id')->formatStateUsing(fn($state) => 'DEVIS-#' . $state)->label('Invoice ID')->searchable()
                    ->url(fn($record) => route('filament.resources.devis.view', $record->id)),
                Tables\Columns\TextColumn::make('client.name')->limit(50)
                    ->url(fn($record) => route('filament.resources.clients.edit', $record->client->id)), 
                Tables\Columns\TextColumn::make('start_date')->date(),
                Tables\Columns\TextColumn::make('end_date')->date(),
                Tables\Columns\TextColumn::make('total'),
                Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'danger' => 'denied',
                    'success' => 'sent',
                    'warning' => 'draft'
                    // 'success' => fn ($state) => in_array($state, ['delivered', 'shipped']),
                ]),
                // Tables\Columns\TextColumn::make('tax')->enum([
                //     'dt' => 'Dt',
                //     'tva_19%' => 'Tva 19',
                //     'tva_9%' => 'Tva 9',
                // ]),
                // Tables\Columns\TextColumn::make('tax2')->enum([
                //     'dt' => 'Dt',
                //     'tva_19%' => 'Tva 19',
                //     'tva_9%' => 'Tva 9',
                // ]),
                // Tables\Columns\TextColumn::make('note')->limit(50),
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

                MultiSelectFilter::make('client_id')->relationship(
                    'client',
                    'name'
                ),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->modalWidth('xl'),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [DeviResource\RelationManagers\ArticlesRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDevis::route('/'),
            // 'index' => Pages\ListDevis::route('/'),
            // 'create' => Pages\CreateDevi::route('/create'),
            'view' => Pages\ViewDevi::route('/{record}'),
            // 'edit' => Pages\EditDevi::route('/{record}/edit'),
        ];
    }
}
