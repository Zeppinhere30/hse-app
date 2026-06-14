<?php

namespace App\Filament\Resources\IncidentResource\Pages;

use App\Filament\Resources\IncidentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder; // Pastikan import ini ada

class ListIncidents extends ListRecords
{
    protected static string $resource = IncidentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // INI YANG PALING PENTING: Filter data di sini
    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();

        // Cek jika user login dan memiliki role operator
        if (auth()->check() && auth()->user()->hasRole('operator')) {
            return $query->where('reporter_id', auth()->id());
        }

        return $query;
    }
}