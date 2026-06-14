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
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Temuan',
                    'data' => [
                        Incident::where('status', 'Baru')->count(),
                        Incident::where('status', 'Dalam Peninjauan')->count(),
                        Incident::where('status', 'Sedang Diperbaiki')->count(),
                        Incident::where('status', 'Menunggu Validasi')->count(),
                        Incident::where('status', 'Selesai')->count(),
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