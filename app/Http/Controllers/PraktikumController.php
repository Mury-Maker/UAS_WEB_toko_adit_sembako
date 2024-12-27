<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PraktikumController extends Controller
{
    //
    public function product(){
        return view('Produk');
    }

    public function Home(){
        return view('Home');
    }

    
    public function transaksi(){
        return view('Transaksi');
    }

    
    public function laporan(){
        return view('Laporan');
    }
}
