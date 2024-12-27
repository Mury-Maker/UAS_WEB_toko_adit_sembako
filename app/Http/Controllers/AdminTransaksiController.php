<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AdminTransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = [
            'title'     => 'Manajemen Transaksi',
            'transaksi'  => Transaksi::orderBy('created_at', 'DESC')->paginate(12),
            'content'   => 'admin/transaksi/index'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = [
            'user_id'   => Auth::user()->id,
            'kasir_name'=> Auth::user()->name,
            'total' => 0,
        ];
        $transaksi = Transaksi::create($data);
        return redirect('/admin/transaksi/' . $transaksi->id.'/edit');
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaksi = Transaksi::with('details')->findOrFail($id); // Memastikan detail juga dimuat
        
        $data = [
            'title' => 'Detail Transaksi',
            'transaksi' => $transaksi,
            'content' => 'admin/transaksi/show',  // Pastikan view ini ada
            ];
            
            return view('admin.layouts.wrapper', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produk = Produk::get(); // Ambil semua produk
        $produk_id = request('produk_id'); // Dapatkan produk_id yang dipilih
        $p_detail = Produk::find($produk_id); // Ambil detail produk berdasarkan produk_id
    
        // Ambil detail transaksi
        $transaksi_detail = TransaksiDetail::whereTransaksiId($id)->get();
    
        // Cek apakah ada perubahan qty (menambah atau mengurangi)
        $act = request('act');
        $qty = request('qty');
        if($act == 'min') {
            if($qty <= 1) {
                $qty = 1;
            }else {
                $qty = $qty - 1;
            }
        } else {
            $qty = $qty + 1;
        }
    
        // Hitung subtotal
        $subtotal = 0;
        if ($p_detail) {
            $subtotal = $qty * $p_detail->harga;
        }
    
        // Ambil transaksi terkait
        $transaksi = Transaksi::find($id);
    
        // Perhitungan kembalian
        $dibayarkan = request('dibayarkan');
        $kembalian = $dibayarkan - $transaksi->total;
    
        // Mengurangi stok produk
        if ($p_detail) {
            // Pastikan stok cukup sebelum mengurangi
            if ($p_detail->stok >= $qty) {
                $p_detail->stok -= $qty; // Kurangi stok produk
                $p_detail->save(); // Simpan perubahan stok
            } else {
                Alert::error('Stok Tidak Cukup', 'Stok produk tidak cukup untuk transaksi ini');
                return redirect()->back(); // Jika stok tidak cukup, kembalikan ke halaman sebelumnya
            }
        }
    
        // Data untuk dikirim ke view
        $data = [
            'title'     => 'Manajemen Transaksi',
            'produk'    => $produk,
            'p_detail'  => $p_detail,
            'qty'       => $qty,
            'subtotal'  => $subtotal,
            'transaksi_detail' => $transaksi_detail,
            'transaksi' => $transaksi,
            'kembalian' => $kembalian,
            'content'   => 'admin/transaksi/create'
        ];
        return view('admin.layouts.wrapper', $data);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
