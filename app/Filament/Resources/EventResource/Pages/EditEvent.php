<?php

namespace App\Filament\Resources\EventResource\Pages;

use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\EventResource;
use Filament\Pages\Actions\DeleteAction;
use Buildix\Timex\Traits\TimexTrait;
use Filament\Resources\Form;

class EditEvent extends EditRecord
{
    use TimexTrait;
    protected static string $resource = EventResource::class;

    public function form(Form $form): Form
    {
        return $form->schema(self::getResource()::getCreateEditForm());
    }

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
