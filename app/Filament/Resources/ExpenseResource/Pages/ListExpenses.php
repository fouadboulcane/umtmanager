<?php

namespace App\Filament\Resources\ExpenseResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ExpenseResource;

class ListExpenses extends ListRecords
{
    protected static string $resource = ExpenseResource::class;
}
