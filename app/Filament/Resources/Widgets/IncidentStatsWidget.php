<?php

namespace App\Filament\Widgets;

use App\Models\Incident;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class IncidentStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

     protected function getStats(): array
    {
    $currentUserId = auth()->id();

    // 1. Jika bukan super admin, filter berdasarkan ID user yang sedang aktif saat ini
    if (!auth()->user()->hasRole('super_admin')) {
        $query = Incident::where('reporter_id', $currentUserId);
    } else {
        $query = Incident::query();
    }

        // 3. Gunakan $query untuk menghitung data di setiap stat
        return [
            Stat::make('Total Laporan Masuk', (clone $query)->count())
                ->description('Seluruh temuan bahaya')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),
                
            Stat::make('Laporan Selesai', (clone $query)->where('status', 'Selesai')->count())
                ->description('Telah ditangani dengan aman')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
                
            Stat::make('Kondisi Kritis', (clone $query)->where('tingkat_keparahan', 'Kritis')->count())
                ->description('Membutuhkan perhatian segera')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
        ];
    }
}