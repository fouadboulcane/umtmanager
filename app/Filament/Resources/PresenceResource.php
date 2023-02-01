<?php

namespace App\Filament\Resources;

use App\Models\Presence;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use App\Filament\Resources\PresenceResource\Pages;

class PresenceResource extends Resource
{
    protected static ?string $model = Presence::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $recordTitleAttribute = 'note';
    
    protected static ?string $navigationGroup = 'HR';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    DateTimePicker::make('arrival_date')
                        ->rules(['required', 'date'])
                        ->placeholder('Arrival Date')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    DateTimePicker::make('departure_date')
                        ->rules(['required', 'date'])
                        ->placeholder('Departure Date')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    RichEditor::make('note')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Note')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    BelongsToSelect::make('user_id')
                        ->rules(['required', 'exists:users,id'])
                        ->relationship('teamMember', 'first_name')
                        ->getOptionLabelFromRecordUsing(function($record) {
                            return "{$record->first_name} {$record->last_name}";
                        })
                        ->searchable()
                        ->placeholder('Team Member')
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
                Tables\Columns\TextColumn::make('teamMember.fullname')->limit(50),
                Tables\Columns\TextColumn::make('arrival_date')->dateTime(),
                Tables\Columns\TextColumn::make('departure_date')->dateTime(),
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

                // MultiSelectFilter::make('user_id')->relationship(
                //     'teamMember',
                //     'name'
                // ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPresences::route('/'),
            'create' => Pages\CreatePresence::route('/create'),
            'edit' => Pages\EditPresence::route('/{record}/edit'),
        ];
    }
}
