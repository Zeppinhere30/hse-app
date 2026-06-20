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
        $query = Incident::query();

        // Operator hanya melihat statistik dari laporan miliknya sendiri,
        // sedangkan super_admin melihat keseluruhan data (sama seperti di IncidentResource)
        if (!auth()->user()->hasRole('super_admin')) {
            $query->where('reporter_id', auth()->id());
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Laporan',
                    'data' => [
                        (clone $query)->where('tingkat_keparahan', 'Kritis')->count(),
                        (clone $query)->where('tingkat_keparahan', 'Tinggi')->count(),
                        (clone $query)->where('tingkat_keparahan', 'Sedang')->count(),
                        (clone $query)->where('tingkat_keparahan', 'Rendah')->count(),
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