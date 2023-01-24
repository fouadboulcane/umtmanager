<?php

namespace App\Filament\Resources\ManifestResource\RelationManagers;

use App\Filament\Resources\DeviRequestResource;
use App\Models\DeviRequest;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\{Form, Table};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Tables\Actions\EditAction;

class DeviRequestsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'deviRequests';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 0])->schema([
                KeyValue::make('content')->columnSpan([
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

                BelongsToSelect::make('user_id')
                    ->rules(['required', 'exists:users,id'])
                    ->relationship('assignedMember', 'name')
                    ->searchable()
                    ->placeholder('Assigned Member')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                Select::make('status')
                    ->rules(['required', 'in:pending,canceled,estimated,draft'])
                    ->searchable()
                    ->options([
                        'pending' => 'Pending',
                        'canceled' => 'Canceled',
                        'estimated' => 'Estimated',
                        'draft' => 'Draft',
                    ])
                    ->placeholder('Status')
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
                Tables\Columns\TextColumn::make('manifest.title')->limit(50),
                Tables\Columns\TextColumn::make('client.name')->limit(50),
                Tables\Columns\TextColumn::make('assignedMember.name')->limit(
                    50
                ),
                Tables\Columns\TextColumn::make('status')->enum([
                    'pending' => 'Pending',
                    'canceled' => 'Canceled',
                    'estimated' => 'Estimated',
                    'draft' => 'Draft',
                ]),
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

                MultiSelectFilter::make('manifest_id')->relationship(
                    'manifest',
                    'title'
                ),

                MultiSelectFilter::make('client_id')->relationship(
                    'client',
                    'name'
                ),

                MultiSelectFilter::make('user_id')->relationship(
                    'assignedMember',
                    'name'
                ),
            ])
            ->actions([
                EditAction::make()->url(fn (DeviRequest $record): string => DeviRequestResource::getUrl('edit', $record))
            ]);
    }
}
