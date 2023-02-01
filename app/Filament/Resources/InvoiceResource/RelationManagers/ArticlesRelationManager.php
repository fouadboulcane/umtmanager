<?php

namespace App\Filament\Resources\InvoiceResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Tables;
use Filament\Resources\{Form, Table};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;
use Filament\Tables\Actions\AttachAction;
use Illuminate\Contracts\View\View;

class ArticlesRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'articles';

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

                TextInput::make('price')
                    ->rules(['required', 'numeric'])
                    ->numeric()
                    ->placeholder('Price')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('unit')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Unit')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('quantity')
                    ->rules(['required', 'numeric'])
                    ->numeric()
                    ->placeholder('Quantity')
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
                // Tables\Columns\TextColumn::make('description')->limit(50),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\TextColumn::make('unit')->limit(50),
                Tables\Columns\TextColumn::make('quantity'),
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
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function($livewire) {
                        $livewire->emit('refreshComponent');
                    }),
                Tables\Actions\DetachAction::make()
                    ->after(function($livewire) {
                        $livewire->emit('refreshComponent');
                    }),
            ])
            ->headerActions([
                AttachAction::make()
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect()->preload(),
                        Forms\Components\TextInput::make('quantity')->default(1)->numeric()
                    ])
                    ->after(function($livewire) {
                        $livewire->emit('refreshComponent');
                    })
                ]);
            // ->reorderable('order_column');
    }
    
    // protected function getTableContentFooter(): ?View
    // {
    //     return view('tables.rows.invoice-total');
    // }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }
}