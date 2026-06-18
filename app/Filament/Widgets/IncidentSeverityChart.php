<?php

namespace App\Filament\Widgets;

use App\Models\Incident; // Jangan lupa ini wajib ada agar bisa memanggil database
use Filament\Widgets\ChartWidget;

class IncidentSeverityChart extends ChartWidget
{
    // Mengubah judul widget
    protected static ?string $heading = 'Rasio Tingkat Keparahan';
    
    // Mengatur urutan agar tampil sejajar atau di bawah grafik sebelumnya
    protected static ?int $sort = 3; 

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Total Laporan',
                    'data' => [
                        Incident::where('tingkat_keparahan', 'Kritis')->count(),
                        Incident::where('tingkat_keparahan', 'Tinggi')->count(), 
                        Incident::where('tingkat_keparahan', 'Sedang')->count(),
                        Incident::where('tingkat_keparahan', 'Rendah')->count(),
                    ],
                    'backgroundColor' => [
                        '#ef4444', // Merah (Kritis)
                        '#f97316', // Oranye (Tinggi)
                        '#eab308', // Kuning (Sedang)
                        '#3b82f6', // Biru (Rendah)
                    ],
                    'borderWidth' => 0, // Dihilangkan agar terlihat lebih elegan
                ],
            ],
            'labels' => ['Kritis', 'Tinggi', 'Sedang', 'Rendah'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}