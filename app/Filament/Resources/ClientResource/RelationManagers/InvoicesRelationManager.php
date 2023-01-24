<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\{Form, Table};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\RelationManagers\HasManyRelationManager;

class InvoicesRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'invoices';

    protected static ?string $recordTitleAttribute = 'billing_date';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 0])->schema([
                DatePicker::make('billing_date')
                    ->rules(['required', 'date'])
                    ->placeholder('Billing Date')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                DatePicker::make('due_date')
                    ->rules(['required', 'date'])
                    ->placeholder('Due Date')
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

                Toggle::make('reccurent')
                    ->rules(['required', 'boolean'])
                    ->default('0')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                Select::make('status')
                    ->rules(['required', 'in:paid,canceled,draft,late'])
                    ->searchable()
                    ->options([
                        'paid' => 'Paid',
                        'canceled' => 'Canceled',
                        'draft' => 'Draft',
                        'late' => 'Late',
                    ])
                    ->placeholder('Status')
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
                Tables\Columns\TextColumn::make('billing_date')->date(),
                Tables\Columns\TextColumn::make('due_date')->date(),
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
                Tables\Columns\BooleanColumn::make('reccurent'),
                Tables\Columns\TextColumn::make('status')->enum([
                    'paid' => 'Paid',
                    'canceled' => 'Canceled',
                    'draft' => 'Draft',
                    'late' => 'Late',
                ]),
                Tables\Columns\TextColumn::make('project.title')->limit(50),
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

                MultiSelectFilter::make('project_id')->relationship(
                    'project',
                    'title'
                ),

                MultiSelectFilter::make('client_id')->relationship(
                    'client',
                    'name'
                ),
            ]);
    }
}
