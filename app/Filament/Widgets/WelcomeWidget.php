<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class WelcomeWidget extends Widget
{
    // 1. UBAH JALUR VIEW INI SESUAI FOLDERMU
    // (Jika nama foldermu tanpa 's', gunakan 'component.welcome-widget')
    protected static string $view = 'components.welcome-widget';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = -2;

    // 2. TAMBAHKAN BARIS INI
    // Ini memaksa widget dimuat langsung. Kalau ada error, dia akan berteriak, bukan sembunyi!
    protected static bool $isLazy = false;

    // 3. PASTIKAN FUNGSI INI ADA
    public static function canView(): bool
    {
        return true;
    }
    /**
     * Daftar tips K3. Tambah/kurangi sesuka hati — tips akan
     * otomatis berganti setiap hari berdasarkan tanggal saat ini,
     * jadi semua orang yang login di hari yang sama lihat tips yang sama.
     */
    protected function tips(): array
    {
        return [
            'Selalu gunakan APD (Alat Pelindung Diri) yang sesuai sebelum memasuki area kerja berisiko.',
            'Laporkan setiap kondisi tidak aman sekecil apapun, jangan menunggu sampai terjadi insiden.',
            'Pastikan jalur evakuasi selalu bebas dari hambatan dan mudah diakses.',
            'Periksa kondisi alat dan mesin sebelum digunakan, jangan abaikan suara atau getaran yang tidak biasa.',
            'Jangan pernah melepas atau menonaktifkan alat pengaman (safety guard) tanpa izin.',
            'Komunikasikan bahaya yang Anda temukan kepada rekan kerja di sekitar area tersebut.',
            'Istirahat yang cukup sebelum bekerja — kelelahan adalah salah satu penyebab utama kecelakaan kerja.',
            'Pastikan area kerja bersih dan rapi (housekeeping) untuk mengurangi risiko tersandung atau terpeleset.',
            'Gunakan alat sesuai fungsinya, jangan memaksakan alat untuk pekerjaan yang bukan peruntukannya.',
            'Pahami prosedur tanggap darurat di area kerja Anda sebelum dibutuhkan.',
            'Jangan bekerja di ketinggian tanpa pengaman tubuh (body harness) yang terpasang dengan benar.',
            'Periksa label dan MSDS sebelum menangani bahan kimia yang belum Anda kenal.',
            'Selalu lakukan briefing K3 (safety talk) sebelum memulai pekerjaan berisiko tinggi.',
            'Jangan ragu menghentikan pekerjaan (stop work authority) jika Anda merasa kondisi tidak aman.',
            'Pastikan pencahayaan area kerja cukup, terutama untuk pekerjaan yang membutuhkan ketelitian.',
            'Gunakan tangga sesuai standar, jangan berdiri di anak tangga paling atas.',
            'Simpan bahan mudah terbakar jauh dari sumber panas atau percikan api.',
            'Laporkan insiden secepat mungkin agar investigasi dan pencegahan dapat dilakukan dengan cepat.',
            'Jangan mengoperasikan alat berat tanpa sertifikasi dan izin yang sesuai.',
            'Budaya K3 yang baik dimulai dari kepedulian setiap individu, bukan hanya dari aturan tertulis.',
        ];
    }

    public function getTipOfTheDay(): array
    {
        $tips = $this->tips();
        $index = now()->dayOfYear % count($tips);

        return [
            'text' => $tips[$index],
            'number' => $index + 1,
            'total' => count($tips),
        ];
    }
}