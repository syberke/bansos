<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login'); // misalnya ada view login.blade.php
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Kirim request ke Google Apps Script
        $response = Http::asForm()->post('https://script.google.com/macros/s/AKfycbznOvrrQNDBlxQ1wlhMekYI-3TUomUaRmZSUJG3-k1GF7EcoZCCzqV40C6CpbqdqdFq/exec', [
            'action' => 'login',
            'username' => $request->username,
            'password' => $request->password,
        ]);

        // Handle response
        if ($response->successful()) {
            $result = $response->json();

            if ($result['success']) {
                // Login berhasil → Simpan ke session (jika perlu)
                session(['username' => $result['username']]);

                return redirect()->route('penerima.index')->with('success', 'Login berhasil sebagai ' . $result['username']);
            } else {
                return back()->withErrors(['login' => $result['message']]);
            }
        } else {
            return back()->withErrors(['login' => 'Gagal terhubung ke server login']);
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'Berhasil logout');
    }
}
