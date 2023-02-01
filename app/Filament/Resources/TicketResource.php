<?php

namespace App\Filament\Resources;

use App\Models\Ticket;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TicketResource\Pages;
use App\Models\User;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Tables\Columns\SpatieTagsColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Str;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationGroup = 'Other';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(2)->schema([
                TextInput::make('title')->required()->columnSpan(2),

                BelongsToSelect::make('client_id')
                        ->rules(['required', 'exists:clients,id'])
                        ->relationship('client', 'name')
                        // ->getOptionLabelFromRecordUsing(function($record) {
                        //     return "{$record->first_name} {$record->last_name}";
                        // })
                        ->searchable()
                        ->placeholder('Client')
                        ->columnSpan(1),

                BelongsToSelect::make('user_id')
                        ->rules(['required', 'exists:users,id'])
                        ->relationship('teamMember', 'first_name')
                        ->getOptionLabelFromRecordUsing(function($record) {
                            return "{$record->first_name} {$record->last_name}";
                        })
                        ->searchable()
                        ->placeholder('Affect To')
                        ->columnSpan(1),

                Select::make('type')->columnSpan(2)
                    ->options([
                        'general_support' => 'General Support',
                    ]),
                Textarea::make('description')->required()
                    ->rows(2)->columnSpan(2),

                SpatieTagsInput::make('tags')->type('tickets')
                    ->columnSpan(2),

                FileUpload::make('attachments')->multiple()
                    ->columnSpan(2)
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->toggleable(),
            Tables\Columns\TextColumn::make('title')->limit(50)->toggleable()->searchable()->sortable(),
            Tables\Columns\TextColumn::make('client.name')->toggleable()->searchable()->sortable(),
            Tables\Columns\BadgeColumn::make('type')->formatStateUsing(fn($state) => Str::headline($state))->toggleable(),
            Tables\Columns\TextColumn::make('teamMember.fullname')->label('Assigned To')->toggleable()->searchable()->sortable(),
            SpatieTagsColumn::make('tags')->type('tickets')->toggleable(),
            Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'danger' => 'opened',
                    'success' => 'closed',
                    // 'success' => fn ($state) => in_array($state, ['delivered', 'shipped']),
                ])->toggleable(),
        ])->filters([
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
            SelectFilter::make('client')->relationship('client', 'name'),
            SelectFilter::make('teamMember')->relationship('teamMember', 'first_name'),
                // ->getOptionLabelFromRecordUsing(function($record) {
                //     return "{$record->first_name} {$record->last_name}";
                // }),
            SelectFilter::make('type')
                ->options([
                    'general_support' => 'General Support',
                ])
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTickets::route('/'),
            // 'index' => Pages\ListTickets::route('/'),
            // 'create' => Pages\CreateTicket::route('/create'),
            // 'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
