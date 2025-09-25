<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Logout extends Component
{
    public function logout()
    {
        $token = Session::get('token');
        $baseUrl = config('app.api_url');

        try {
            $response = Http::withToken($token)->post($baseUrl . '/logout');

            if ($response->successful()) {
                Session::forget(['user', 'token']);
                Session::flush();

                return redirect()->route('login')->with('successMessage', 'Logout berhasil');
            } else {
                return back()->with('error', 'Gagal logout: ' . $response->body());
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.auth.logout');
    }
}
