<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

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

class ExpensesRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'expenses';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 0])->schema([
                TextInput::make('title')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Title')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                RichEditor::make('description')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Description')
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

                DatePicker::make('date')
                    ->rules(['required', 'date'])
                    ->placeholder('Date')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                Select::make('category')
                    ->rules(['required', 'in:miscellaneous_expense'])
                    ->searchable()
                    ->options([
                        'Miscellaneous Expense' => 'Miscellaneous expense',
                    ])
                    ->placeholder('Category')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                Select::make('tax')
                    ->rules(['required', 'in:dt,tva_19%,tva_9%'])
                    ->searchable()
                    ->options([
                        'DT' => 'Dt',
                        'TVA 19%' => 'Tva 19',
                        'TVA 9%' => 'Tva 9',
                    ])
                    ->placeholder('Tax')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                Select::make('tax2')
                    ->rules(['required', 'in:dt,tva_19%,tva_9%'])
                    ->searchable()
                    ->options([
                        'DT' => 'Dt',
                        'TVA 19%' => 'Tva 19',
                        'TVA 9%' => 'Tva 9',
                    ])
                    ->placeholder('Tax2')
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
                Tables\Columns\TextColumn::make('title')->limit(50),
                Tables\Columns\TextColumn::make('description')->limit(50),
                Tables\Columns\TextColumn::make('amount'),
                Tables\Columns\TextColumn::make('date')->date(),
                Tables\Columns\TextColumn::make('category')->enum([
                    'Miscellaneous Expense' => 'Miscellaneous expense',
                ]),
                Tables\Columns\TextColumn::make('tax')->enum([
                    'DT' => 'Dt',
                    'TVA 19%' => 'Tva 19',
                    'TVA 9%' => 'Tva 9',
                ]),
                Tables\Columns\TextColumn::make('tax2')->enum([
                    'DT' => 'Dt',
                    'TVA 19%' => 'Tva 19',
                    'TVA 9%' => 'Tva 9',
                ]),
                Tables\Columns\TextColumn::make('project.title')->limit(50),
                Tables\Columns\TextColumn::make('teamMember.name')->limit(50),
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

                MultiSelectFilter::make('user_id')->relationship(
                    'teamMember',
                    'name'
                ),
            ]);
    }
}
