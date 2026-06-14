<?php

namespace App\Filament\Resources\IncidentResource\Pages;

use App\Filament\Resources\IncidentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIncident extends CreateRecord
{
    protected static string $resource = IncidentResource::class;

    // Tambahkan fungsi ini agar reporter_id otomatis terisi
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['reporter_id'] = auth()->id();

        return $data;
    }
}