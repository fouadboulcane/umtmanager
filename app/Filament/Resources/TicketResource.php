<?php

namespace App\Filament\Resources;

use App\Models\Ticket;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TicketResource\Pages;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationGroup = 'Other';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([Grid::make(['default' => 0])->schema([])]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([])->filters([
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
