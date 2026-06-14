<?php

namespace App\Filament\Widgets;

use App\Models\Incident;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class IncidentStatsWidget extends BaseWidget
{
    // Mengatur urutan agar widget ini tampil paling atas di dashboard
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Laporan Masuk', Incident::count())
                ->description('Seluruh temuan bahaya')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),
                
            Stat::make('Laporan Selesai', Incident::where('status', 'Selesai')->count())
                ->description('Telah ditangani dengan aman')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
                
            Stat::make('Kondisi Kritis', Incident::where('tingkat_keparahan', 'Kritis')->count())
                ->description('Membutuhkan perhatian segera')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
        ];
    }
}