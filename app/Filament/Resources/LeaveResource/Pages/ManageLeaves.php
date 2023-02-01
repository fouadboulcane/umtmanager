<?php

namespace App\Filament\Resources\LeaveResource\Pages;

use App\Filament\Resources\LeaveResource;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageLeaves extends ManageRecords
{
    protected static string $resource = LeaveResource::class;

    public function getActions(): array 
    {
        return [
            Action::make('leaveRequest')->label('Leave Request')->icon('heroicon-o-logout')->color('secondary')
                ->form([
                    Grid::make(2)->schema([
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
                            ->placeholder('Start Date')
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
                    ])
                ])
                ->action(function() {

                })
                ->modalWidth('xl'),
            CreateAction::make()->icon('heroicon-o-plus')->modalWidth('xl')
        ];
    }
}
