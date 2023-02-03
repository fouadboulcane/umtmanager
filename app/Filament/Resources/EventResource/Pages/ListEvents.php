<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Resources\Pages\ListRecords;
use Buildix\Timex\Traits\TimexTrait;
use Filament\Pages\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;

class ListEvents extends ListRecords
{
    use TimexTrait;
    protected static string $resource = EventResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        if (in_array('participants',\Schema::getColumnListing(self::getEventTableName()))){
            return parent::getTableQuery()
                ->where('organizer','=',\Auth::id())
                ->orWhereJsonContains('participants', \Auth::id());
        }else{
            return parent::getTableQuery();
        }
    }
}
