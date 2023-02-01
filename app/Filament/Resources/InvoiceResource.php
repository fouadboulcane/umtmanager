<?php

namespace App\Filament\Resources;

use App\Models\Invoice;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use App\Filament\Resources\InvoiceResource\Pages;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use Carbon\Carbon;
use Filament\Tables\Filters\SelectFilter;
use Webbingbrasil\FilamentDateFilter\DateFilter;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $recordTitleAttribute = 'billing_date';

    protected static ?string $navigationGroup = 'Finance';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    DatePicker::make('billing_date')
                        ->rules(['required', 'date'])
                        ->placeholder('Billing Date')
                        ->columnSpan([
                            'default' => 6,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    DatePicker::make('due_date')
                        ->rules(['required', 'date'])
                        ->placeholder('Due Date')
                        ->columnSpan([
                            'default' => 6,
                            'md' => 6,
                            'lg' => 6,
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
                            'default' => 6,
                            'md' => 6,
                            'lg' => 6,
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
                            'default' => 6,
                            'md' => 6,
                            'lg' => 6,
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

                    // Select::make('status')
                    //     ->rules(['required', 'in:paid,canceled,draft,late'])
                    //     ->searchable()
                    //     ->options([
                    //         'paid' => 'Paid',
                    //         'canceled' => 'Canceled',
                    //         'draft' => 'Draft',
                    //         'late' => 'Late',
                    //     ])
                    //     ->placeholder('Status')
                    //     ->columnSpan([
                    //         'default' => 12,
                    //         'md' => 12,
                    //         'lg' => 12,
                    //     ]),

                    
                ]),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->formatStateUsing(fn($state) => 'FA-' . sprintf('%04d', $state))->label('Invoice ID')->searchable(),
                Tables\Columns\TextColumn::make('project.title')
                    ->limit(50)->url(fn ($record) => route('filament.resources.projects.view', $record->project->id))
                    ->searchable()->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('client.name')
                    ->limit(50)->url(fn ($record) => route('filament.resources.clients.edit', $record->client->id))
                    ->searchable()->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('billing_date')->date()->toggleable(),
                Tables\Columns\TextColumn::make('due_date')->date()->toggleable(),
                Tables\Columns\TextColumn::make('total')->toggleable(),
                Tables\Columns\TextColumn::make('paid')->toggleable(),
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
                // Tables\Columns\BooleanColumn::make('reccurent'),
                Tables\Columns\BadgeColumn::make('status')->enum([
                    'paid' => 'Paid',
                    'canceled' => 'Canceled',
                    'draft' => 'Draft',
                    'late' => 'Late',
                ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
                SelectFilter::make('status')
                    ->options([
                        'paid' => 'Paid',
                        'canceled' => 'Canceled',
                        'draft' => 'Draft',
                        'late' => 'Late',
                    ]),

                MultiSelectFilter::make('project_id')->relationship(
                    'project',
                    'title'
                )->label('Project')->searchable(),

                MultiSelectFilter::make('client_id')->relationship(
                    'client',
                    'name'
                )->label('Client')->searchable(),

                DateFilter::make('created_at')
                    ->label(__('Created At'))
                    ->minDate(Carbon::today()->subMonth(1))
                    ->maxDate(Carbon::today()->addMonth(1))
                    ->timeZone('America/New_York')
                    ->range()
                    ->fromLabel(__('From'))
                    ->untilLabel(__('Until'))
            ])
            ->headerActions([
                Tables\Actions\Action::make('Status')
                ->form([
                    Select::make('status')
                    ->options([
                        'paid' => 'Paid',
                        'canceled' => 'Canceled',
                        'draft' => 'Draft',
                        'late' => 'Late',
                    ]),
                ])
                ->action(function ($livewire, $data) {
                    $livewire->tableFilters['status']['value'] = $data['status'];
                })->modalWidth('sm'),

                FilamentExportHeaderAction::make('export'),
            ])
            ->bulkActions([
                FilamentExportBulkAction::make('export'),
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            InvoiceResource\RelationManagers\ArticlesRelationManager::class,
            InvoiceResource\RelationManagers\PaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            // 'index' => Pages\ManageInvoices::route('/'),
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'view' => Pages\ViewInvoice::route('/{record}'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }


}
