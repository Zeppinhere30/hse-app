<?php

namespace App\Filament\Widgets;

use App\Models\Incident;
use Filament\Widgets\ChartWidget;

class IncidentChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Statistik Laporan Berdasarkan Status';

    // Mengatur agar grafik tampil tepat di bawah kotak statistik
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $query = Incident::query();

        // Operator hanya melihat statistik dari laporan miliknya sendiri,
        // sedangkan super_admin melihat keseluruhan data
        if (!auth()->user()->hasRole('super_admin')) {
            $query->where('reporter_id', auth()->id());
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Temuan',
                    'data' => [
                        (clone $query)->where('status', 'Baru')->count(),
                        (clone $query)->where('status', 'Dalam Peninjauan')->count(),
                        (clone $query)->where('status', 'Sedang Diperbaiki')->count(),
                        (clone $query)->where('status', 'Menunggu Validasi')->count(),
                        (clone $query)->where('status', 'Selesai')->count(),
                    ],
                    // Warna batang grafik yang elegan
                    'backgroundColor' => ['#9CA3AF', '#FBBF24', '#38BDF8', '#818CF8', '#34D399'],
                ],
            ],
            // Label di bagian bawah grafik
            'labels' => ['Baru', 'Peninjauan', 'Diperbaiki', 'Validasi', 'Selesai'],
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Menggunakan jenis grafik batang (bar chart)
    }
}