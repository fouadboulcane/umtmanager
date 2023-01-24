<?php

namespace App\Filament\Resources\InvoiceResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\{Form, Table};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\RelationManagers\HasManyRelationManager;

class PaymentsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $recordTitleAttribute = 'date';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 0])->schema([
                DatePicker::make('date')
                    ->rules(['required', 'date'])
                    ->placeholder('Date')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('amount')
                    ->rules(['required', 'numeric'])
                    ->numeric()
                    ->placeholder('Amount')
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

                Select::make('mode')
                    ->rules([
                        'required',
                        'in:cash,postal_check,bank_check,bank_transfer',
                    ])
                    ->searchable()
                    ->options([
                        'cash' => 'Cash',
                        'postal_check' => 'Postal check',
                        'bank_check' => 'Bank check',
                        'bank_transfer' => 'Bank transfer',
                    ])
                    ->placeholder('Mode')
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
                Tables\Columns\TextColumn::make('date')->date(),
                Tables\Columns\TextColumn::make('amount'),
                Tables\Columns\TextColumn::make('note')->limit(50),
                Tables\Columns\TextColumn::make('mode')->enum([
                    'cash' => 'Cash',
                    'postal_check' => 'Postal check',
                    'bank_check' => 'Bank check',
                    'bank_transfer' => 'Bank transfer',
                ]),
                Tables\Columns\TextColumn::make('invoice.billing_date')->limit(
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

                MultiSelectFilter::make('invoice_id')->relationship(
                    'invoice',
                    'billing_date'
                ),
            ]);
    }
}
