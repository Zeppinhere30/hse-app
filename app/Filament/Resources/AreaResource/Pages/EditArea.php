<?php

namespace App\Filament\Resources\AreaResource\Pages;

use App\Filament\Resources\AreaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArea extends EditRecord
{
    protected static string $resource = AreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // Tambahkan fungsi ini agar setelah Edit kembali ke tabel
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}