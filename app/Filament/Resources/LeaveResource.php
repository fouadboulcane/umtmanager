<?php

namespace App\Filament\Resources;

use App\Models\Leave;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LeaveResource\Pages;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\Action;

class LeaveResource extends Resource
{
    protected static ?string $model = Leave::class;

    protected static ?string $navigationIcon = 'heroicon-o-logout';

    protected static ?string $recordTitleAttribute = 'start_date';

    protected static ?string $navigationGroup = 'HR';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(2)->schema([
                BelongsToSelect::make('user_id')
                    ->rules(['required', 'exists:users,id'])
                    ->relationship('teamMember', 'first_name')
                    ->getOptionLabelFromRecordUsing(function($record) {
                        return "{$record->first_name} {$record->last_name}";
                    })
                    ->label('Team Member')
                    ->placeholder('Member')
                    ->columnSpan(2),


                Select::make('type')
                    ->rules(['required', 'in:casual_leave,maternity_leave'])
                    ->searchable()
                    ->options([
                        'casual_leave' => 'Casual leave',
                        'maternity_leave' => 'Maternity leave',
                    ])
                    ->placeholder('Type')
                    ->columnSpan(2),

                Radio::make('duration')
                    ->rules(['required', 'in:one_day,multiple_days,hours'])
                    ->options([
                        'one_day' => 'One day',
                        'multiple_days' => 'Multiple days',
                        // 'hours' => 'Hours',
                    ])
                    ->default('one_day')
                    ->inline()
                    ->columnSpan(2)
                    ->reactive(),

                DatePicker::make('start_date')
                    ->rules(['required', 'date'])
                    ->label(fn($get) => $get('duration') == 'one_day' ? 'Date' : 'Start Date')
                    // ->hidden(fn($get) => $get('duration') != 'multiple_days')
                    ->placeholder(fn($get) => $get('duration') == 'one_day' ? 'Date' : 'Start Date')
                    ->columnSpan(fn($get) => $get('duration') == 'one_day' ? 2 : 1),

                DatePicker::make('end_date')
                    ->rules(['required', 'date'])
                    ->hidden(fn($get) => $get('duration') != 'multiple_days')
                    ->placeholder('End Date')
                    ->columnSpan(1),

                Textarea::make('reason')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Reason')
                    ->rows(2)
                    ->columnSpan(2),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('teamMember.fullname')->label('Applicant'),
                Tables\Columns\BadgeColumn::make('type')->enum([
                    'casual_leave' => 'Casual leave',
                    'maternity_leave' => 'Maternity leave',
                ]),
                Tables\Columns\TextColumn::make('duration')->enum([
                    'one_day' => 'One day',
                    'multiple_days' => 'Multiple days',
                    'hours' => 'Hours',
                ]),
                Tables\Columns\TextColumn::make('start_date')->date(),
                Tables\Columns\TextColumn::make('end_date')->date(),
                Tables\Columns\ToggleColumn::make('status')
                // Tables\Columns\TextColumn::make('reason')->limit(50),
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
            ])
            ->headerActions([
                Action::make('allRequests')->label('All Requests'),
                Action::make('validatedRequests')->label('Validated Leaves'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageLeaves::route('/'),
            // 'index' => Pages\ListLeaves::route('/'),
            // 'create' => Pages\CreateLeave::route('/create'),
            // 'edit' => Pages\EditLeave::route('/{record}/edit'),
        ];
    }

    
}
