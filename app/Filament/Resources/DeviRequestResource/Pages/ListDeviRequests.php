<?php

namespace App\Filament\Resources\DeviRequestResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\DeviRequestResource;
use App\Forms\Components\ItemsList;
use App\Models\Manifest;
use Closure;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\Action;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\HtmlString;

class ListDeviRequests extends ListRecords
{
    protected static string $resource = DeviRequestResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('newDeviRequest')
                ->action(fn () => $this->record->advance())
                ->modalActions([])
                ->form([
                    // BelongsToSelect::make('manifest_id')
                    //     ->rules(['required', 'exists:manifests,id'])
                    //     ->relationship('manifest', 'title')
                    //     ->searchable()
                    //     ->placeholder('Manifest')
                    //     ->columnSpan([
                    //         'default' => 12,
                    //         'md' => 12,
                    //         'lg' => 12,
                    //     ])
                    //     ->preload(),

                    Grid::make()->schema([
                        ItemsList::make('manifestList')->items(Manifest::take(6)->get()->toArray()),
                    ])->columns(1),
                ])
        ];
    }

    public function openSettingsModal(): void
    {
        $this->dispatchBrowserEvent('open-settings-modal');
    }
}
