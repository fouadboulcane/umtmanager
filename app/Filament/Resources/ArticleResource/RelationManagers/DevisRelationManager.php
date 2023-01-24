<?php

namespace App\Filament\Resources\ArticleResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\{Form, Table};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;

class DevisRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'devis';

    protected static ?string $recordTitleAttribute = 'start_date';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 0])->schema([
                DatePicker::make('start_date')
                    ->rules(['required', 'date'])
                    ->placeholder('Start Date')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                DatePicker::make('end_date')
                    ->rules(['required', 'date'])
                    ->placeholder('End Date')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                Select::make('tax')
                    ->rules(['nullable', 'in:dt,tva_19%,tva_9%'])
                    ->searchable()
                    ->options([
                        'dt' => 'Dt',
                        'tva_19%' => 'Tva 19',
                        'tva_9%' => 'Tva 9',
                    ])
                    ->placeholder('Tax')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                Select::make('tax2')
                    ->rules(['nullable', 'in:dt,tva_19%,tva_9%'])
                    ->searchable()
                    ->options([
                        'dt' => 'Dt',
                        'tva_19%' => 'Tva 19',
                        'tva_9%' => 'Tva 9',
                    ])
                    ->placeholder('Tax2')
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
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('start_date')->date(),
                Tables\Columns\TextColumn::make('end_date')->date(),
                Tables\Columns\TextColumn::make('tax')->enum([
                    'dt' => 'Dt',
                    'tva_19%' => 'Tva 19',
                    'tva_9%' => 'Tva 9',
                ]),
                Tables\Columns\TextColumn::make('tax2')->enum([
                    'dt' => 'Dt',
                    'tva_19%' => 'Tva 19',
                    'tva_9%' => 'Tva 9',
                ]),
                Tables\Columns\TextColumn::make('note')->limit(50),
                Tables\Columns\TextColumn::make('client.name')->limit(50),
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

                MultiSelectFilter::make('client_id')->relationship(
                    'client',
                    'name'
                ),
            ]);
    }
}
