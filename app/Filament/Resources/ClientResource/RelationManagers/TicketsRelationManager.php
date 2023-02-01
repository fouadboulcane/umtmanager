<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\FileUpload;
use Filament\Tables;
use Filament\Resources\{Form, Table};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Tables\Columns\SpatieTagsColumn;
use Illuminate\Support\Str;

class TicketsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'tickets';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([Grid::make(2)->schema([
            TextInput::make('title')->required()->columnSpan(2),

            BelongsToSelect::make('user_id')
                    ->rules(['required', 'exists:users,id'])
                    ->relationship('teamMember', 'first_name')
                    ->getOptionLabelFromRecordUsing(function($record) {
                        return "{$record->first_name} {$record->last_name}";
                    })
                    ->searchable()
                    ->placeholder('Affect To')
                    ->columnSpan(1),

            Select::make('type')->columnSpan(1)
                ->options([
                    'general_support' => 'General Support',
                ]),
            Textarea::make('description')->required()
                ->rows(2)->columnSpan(2),

            SpatieTagsInput::make('tags')->type('tickets')
                ->columnSpan(2),

            FileUpload::make('attachments')->multiple()
                ->columnSpan(2)
        ])]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id'),
            Tables\Columns\TextColumn::make('title')->limit(50)->searchable(),
            Tables\Columns\BadgeColumn::make('type')->formatStateUsing(fn($state) => Str::headline($state)),
            Tables\Columns\TextColumn::make('teamMember.fullname')->label('Assigned To'),
            Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'danger' => 'opened',
                    'success' => 'closed',
                    // 'success' => fn ($state) => in_array($state, ['delivered', 'shipped']),
                ])
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
        ])
        ->headerActions([
            Tables\Actions\CreateAction::make()->icon('heroicon-o-plus')->modalWidth('xl')
        ]);
    }
}
