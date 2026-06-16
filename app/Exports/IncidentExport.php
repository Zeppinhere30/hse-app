<?php

namespace App\Exports;

use App\Models\Incident;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class IncidentExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithStyles
{
    public function collection()
    {
        return Incident::with(['area', 'category'])
            ->get()
            ->map(function ($incident) {
                return [
                    $incident->kode_laporan,
                    date('d-m-Y', strtotime($incident->tanggal_kejadian)),
                    $incident->area?->nama_area,
                    $incident->category?->nama_kategori,
                    $incident->lokasi_spesifik,
                    $incident->tingkat_keparahan,
                    $incident->status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Kode Laporan',
            'Tanggal Kejadian',
            'Area',
            'Kategori',
            'Lokasi',
            'Tingkat Keparahan',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
            ],
        ];
    }
}