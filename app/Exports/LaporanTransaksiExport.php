<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanTransaksiExport implements FromArray, WithTitle, WithStyles, WithEvents
{
    protected $data;

    // Konstruktor untuk menerima data yang dikirim dari controller
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    // Fungsi ini akan mengembalikan array yang berisi data yang akan diekspor
    public function array(): array
    {
        $laporan = $this->data['laporan']; // Data laporan transaksi
        $penghasilan = $this->data['penghasilanBulanan']; // Data penghasilan bulanan

        // Inisialisasi array yang akan diekspor ke Excel
        $exportData = [
            ['TOKO ADIT SEMBAKO'], // Menambahkan header Toko Adit Sembako
            [], // Baris kosong untuk pemisah
            ['Laporan Transaksi'], // Judul bagian laporan transaksi
            ['No', 'Tanggal Transaksi', 'Kasir', 'Status', 'Total Transaksi'],
        ];

        // Menambahkan data transaksi ke dalam array export
        foreach ($laporan as $item) {
            $exportData[] = [
                $item->id,
                $item->created_at,
                $item->kasir_name,
                $item->status,
                'Rp. ' . number_format($item->total, 0, ',', '.'), // Format rupiah
            ];
        }

        // Menambahkan data penghasilan bulanan ke dalam array export
        $exportData[] = [];
        $exportData[] = ['Penghasilan Bulanan']; // Judul bagian penghasilan bulanan
        $exportData[] = ['Bulan', 'Total Penghasilan'];

        foreach ($penghasilan as $item) {
            $exportData[] = [
                $item->bulan,
                'Rp. ' . number_format($item->total_penghasilan, 0, ',', '.'), // Format rupiah
            ];
        }

        return $exportData; // Mengembalikan data dalam bentuk array
    }

    // Menambahkan judul untuk sheet Excel
    public function title(): string
    {
        return 'Laporan Transaksi';
    }

    // Fungsi untuk menambahkan style pada Excel
    public function styles($sheet)
    {
        $sheet->mergeCells('A1:E1'); // Menggabungkan sel A1 sampai E1 untuk header "TOKO ADIT SEMBAKO"
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Menempatkan teks di tengah
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14); // Mengubah font menjadi bold dan ukuran 14
    }

    // Menambahkan event AfterSheet untuk memodifikasi sheet setelah data diekspor
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Mengubah posisi teks "TOKO ADIT SEMBAKO" agar muncul di tengah atas sheet
                $event->sheet->mergeCells('A1:E1');
                $event->sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
            },
        ];
    }
}
