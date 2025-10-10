<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Login extends Component
{
    public $email;
    public $name;
    public $password;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        try {

            $baseUrl = config('app.api_url');

            $response = Http::post("{$baseUrl}/login", [
                'email' => $this->email,
                'password' => $this->password,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                Session::put('token', $data['token'] ?? null);

                Session::put('user', [
                    'name' => $this->name, 
                    'email' => $this->email, 
                ]);

                return redirect()->route('dashboard')->with('successMessage', 'Login berhasil selamat datang ' . $this->email);
            } else {
                $this->addError('email', 'Email atau password salah.');
            }
        } catch (\Exception $e) {
            $this->addError('email', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.guest', ['title' => 'Login']);
    }
}
