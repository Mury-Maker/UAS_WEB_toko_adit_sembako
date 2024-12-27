<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanTransaksiExport; // Import kelas export

class AdminLaporanController extends Controller
{
    /**
     * Menampilkan daftar laporan transaksi dengan filter.
     */
    public function index(Request $request)
    {
        // Menyaring berdasarkan tanggal, kasir, dan status
        $query = Transaksi::query();

        if ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) {
            $query->whereBetween('created_at', [
                $request->input('tanggal_awal'),
                $request->input('tanggal_akhir'),
            ]);
        }

        if ($request->has('kasir')) {
            $query->where('user_id', $request->input('kasir'));
        }

        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        $laporan = $query->orderBy('created_at', 'desc')->paginate(10);

        // Kirim data ke view
        $data = [
            'title'    => 'Laporan Transaksi',
            'laporan'  => $laporan,
            'kasirs'   => \App\Models\User::all(),
            'content'  => 'admin/laporan/index',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    /**
     * Menampilkan detail transaksi.
     */
    public function show($id)
    {
        $transaksi = Transaksi::with('details')->findOrFail($id); // Ambil transaksi beserta detailnya
        
        $data = [
            'title' => 'Detail Laporan Transaksi',
            'transaksi' => $transaksi,
            'content' => 'admin/laporan/show',
        ];
        
        return view('admin.layouts.wrapper', $data);
    }

    /**
     * Menampilkan penghasilan bulanan.
     */
    public function penghasilanBulanan()
    {
        // Query untuk menghitung total penghasilan per bulan
        $penghasilan = \DB::table('transaksis')
            ->selectRaw('DATE_FORMAT(created_at, "%M %Y") as bulan, SUM(total) as total_penghasilan')
            ->where('status', 'selesai') // Hanya menghitung transaksi yang selesai
            ->groupBy('bulan')
            ->orderByRaw('YEAR(created_at), MONTH(created_at)') // Urut berdasarkan tahun dan bulan
            ->get();

        // Data untuk Chart.js
        $chartData = [
            'labels' => $penghasilan->pluck('bulan'), // Label berupa nama bulan (Januari, Februari, dll.)
            'data' => $penghasilan->pluck('total_penghasilan'), // Data berupa total penghasilan
        ];

        // Kirim data ke view
        $data = [
            'title'        => 'Penghasilan Bulanan',
            'penghasilan'  => $penghasilan, // Data untuk tabel (opsional)
            'chartData'    => $chartData, // Data untuk chart
            'content'      => 'admin/laporan/bulanan',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    /**
     * Menampilkan laporan transaksi dalam format PDF.
     */
    public function exportPdf(Request $request)
    {
        // Menyaring transaksi berdasarkan filter yang diterapkan (jika ada)
        $query = Transaksi::query();
    
        if ($request->has('bulan')) {
            // Filter berdasarkan bulan dan tahun yang dipilih
            $query->whereMonth('created_at', date('m', strtotime($request->input('bulan'))))
                  ->whereYear('created_at', date('Y', strtotime($request->input('bulan'))));
        }
    
        if ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) {
            $query->whereBetween('created_at', [
                $request->input('tanggal_awal'),
                $request->input('tanggal_akhir'),
            ]);
        }
    
        if ($request->has('kasir')) {
            $query->where('user_id', $request->input('kasir'));
        }
    
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }
    
        // Ambil data transaksi yang sesuai dengan filter
        $laporan = $query->orderBy('created_at', 'desc')->get();
    
        // Mengambil data penghasilan bulanan
        $penghasilanBulanan = \DB::table('transaksis')
            ->selectRaw('DATE_FORMAT(created_at, "%M %Y") as bulan, SUM(total) as total_penghasilan')
            ->where('status', 'selesai') // Hanya menghitung transaksi yang selesai
            ->groupBy('bulan')
            ->orderByRaw('YEAR(created_at), MONTH(created_at)') // Urut berdasarkan tahun dan bulan
            ->get();
    
        // Siapkan data untuk PDF
        $data = [
            'laporan' => $laporan,
            'kasirs'  => \App\Models\User::all(),
            'penghasilanBulanan' => $penghasilanBulanan,
        ];
    
        // Render view menjadi PDF
        $pdf = Pdf::loadView('admin.laporan.pdf', $data);
    
        // Download PDF dengan nama file 'laporan_transaksi.pdf'
        return $pdf->download('laporan_transaksi.pdf');
    }

    /**
     * Menampilkan laporan transaksi dalam format Excel.
     */
    public function exportExcel(Request $request)
    {
        // Menyaring transaksi berdasarkan filter yang diterapkan (jika ada)
        $query = Transaksi::query();

        if ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) {
            $query->whereBetween('created_at', [
                $request->input('tanggal_awal'),
                $request->input('tanggal_akhir'),
            ]);
        }

        if ($request->has('kasir')) {
            $query->where('user_id', $request->input('kasir'));
        }

        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        // Ambil data transaksi yang sesuai dengan filter
        $laporan = $query->orderBy('created_at', 'desc')->get();

        // Mengambil data penghasilan bulanan
        $penghasilanBulanan = \DB::table('transaksis')
            ->selectRaw('DATE_FORMAT(created_at, "%M %Y") as bulan, SUM(total) as total_penghasilan')
            ->where('status', 'selesai') // Hanya menghitung transaksi yang selesai
            ->groupBy('bulan')
            ->orderByRaw('YEAR(created_at), MONTH(created_at)') // Urut berdasarkan tahun dan bulan
            ->get();

        // Siapkan data untuk eksport Excel
        $data = [
            'laporan' => $laporan,
            'kasirs'  => \App\Models\User::all(),
            'penghasilanBulanan' => $penghasilanBulanan,
        ];

        // Ekspor data ke file Excel menggunakan class export
        return Excel::download(new LaporanTransaksiExport($data), 'laporan_transaksi.xlsx');
    }
}
