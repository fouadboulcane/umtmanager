<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\ActionGroup;
use Filament\Pages\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;

    protected $listeners = ['refreshComponent' => '$refresh'];

    protected static string $view = 'filament.resources.invoice-resource.pages.view-invoice';

    public function getActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('sendEmail')->label('Send to Email')->icon('heroicon-o-at-symbol'),
                Action::make('download')->label('Download PDF')->icon('heroicon-o-document-download')
                 ->action(function($livewire) {
                    // dd($livewire->getRecord());
                    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('filament.resources.invoice-resource.pages.invoice', ['record' =>$livewire->getRecord()])->setPaper('A4', 'landscape');;
                    return response()->streamDownload(fn () => print($pdf->output()), "invoice.pdf");
                    // return $pdf->download('filament.resources.invoice-resource.pages.invoice');
                 }),
                Action::make('printInvoice')->label('Print Invoice')->icon('heroicon-o-printer'),
            ])
            ->label('Actions')
            ->color('secondary'),
            // ->icon('heroicon-o-trash'),
            EditAction::make(),
        ];
    }
}
