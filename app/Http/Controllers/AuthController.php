<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validasi input dari pengguna
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Membuat pengguna baru dengan password terenkripsi
        $user = User::create([
            'name' => 'Kevin Nugroho',
            'email' => 'kevinnugroho121@gmail.com',
            'password' => Hash::make('desajajar123'),  // Menggunakan bcrypt
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // Kembalikan respons berhasil
        return response()->json(['message' => 'User created successfully!']);
    }
}
