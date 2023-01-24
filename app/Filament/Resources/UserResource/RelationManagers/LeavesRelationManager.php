<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\{Form, Table};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\RelationManagers\HasManyRelationManager;

class LeavesRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'leaves';

    protected static ?string $recordTitleAttribute = 'start_date';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 0])->schema([
                Select::make('type')
                    ->rules(['required', 'in:casual_leave,maternity_leave'])
                    ->searchable()
                    ->options([
                        'Casual Leave' => 'Casual leave',
                        'Maternity Leave' => 'Maternity leave',
                    ])
                    ->placeholder('Type')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                Select::make('duration')
                    ->rules(['required', 'in:one_day,multiple_days,hours'])
                    ->searchable()
                    ->options([
                        'One Day' => 'One day',
                        'Multiple Days' => 'Multiple days',
                        'Hours' => 'Hours',
                    ])
                    ->placeholder('Duration')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

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

                RichEditor::make('reason')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Reason')
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
                Tables\Columns\TextColumn::make('type')->enum([
                    'Casual Leave' => 'Casual leave',
                    'Maternity Leave' => 'Maternity leave',
                ]),
                Tables\Columns\TextColumn::make('duration')->enum([
                    'One Day' => 'One day',
                    'Multiple Days' => 'Multiple days',
                    'Hours' => 'Hours',
                ]),
                Tables\Columns\TextColumn::make('start_date')->date(),
                Tables\Columns\TextColumn::make('end_date')->date(),
                Tables\Columns\TextColumn::make('reason')->limit(50),
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
            ]);
    }
}
