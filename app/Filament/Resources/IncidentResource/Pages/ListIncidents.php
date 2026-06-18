<?php

namespace App\Filament\Resources\IncidentResource\Pages;

use App\Exports\IncidentExport;
use App\Filament\Resources\IncidentResource;
use App\Models\Incident;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListIncidents extends ListRecords
{
    protected static string $resource = IncidentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Actions\Action::make('export')
                ->label('Export Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {
                    return Excel::download(
                        new IncidentExport(),
                        'laporan-hse-' . now()->format('Y-m-d') . '.xlsx'
                    );
                }),

            Actions\Action::make('pdf')
                ->label('Export PDF')
                ->color('danger')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {

                    $incidents = Incident::with([
                        'area',
                        'category',
                    ])->get();

                    $pdf = Pdf::loadView(
                        'pdf.incidents',
                        compact('incidents')
                    );

                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        'laporan-hse-' . now()->format('Y-m-d') . '.pdf'
                    );
                }),
        ];
    }
}