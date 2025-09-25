<?php

namespace App\Livewire\Major;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Index extends Component
{
    public $majors = [];

    // form
    public $majorId;
    public $name;
    public $code;

    // modal state
    public $isModalOpen = false;

    public function mount()
    {
        $this->fetchData();
    }

    public function fetchData()
    {
        $baseUrl = config('app.api_url');
        $token   = Session::get('token');

        $response = Http::withToken($token)->get("{$baseUrl}/majors");

        if ($response->successful()) {
            $this->majors = $response->json('data') ?? [];
        }
    }

    public function openModal($id = null)
    {
        $this->resetForm();
        $this->isModalOpen = true;

        if ($id) {
            $this->majorId = $id;
            $major = collect($this->majors)->firstWhere('id', $id);

            if ($major) {
                $this->name = $major['name'];
                $this->code = $major['code'];
            }
        }
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->isModalOpen = false;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20',
        ]);

        $baseUrl = config('app.api_url');
        $token   = Session::get('token');

        $payload = [
            'name' => $this->name,
            'code' => $this->code,
        ];

        if ($this->majorId) {
            // Update
            $response = Http::withToken($token)->put("{$baseUrl}/majors/{$this->majorId}", $payload);
        } else {
            // Create
            $response = Http::withToken($token)->post("{$baseUrl}/majors", $payload);
        }

        if ($response->successful()) {
            $this->fetchData();
            $this->closeModal();
            session()->flash('success', 'Data jurusan berhasil disimpan.');
        } else {
            session()->flash('error', 'Gagal menyimpan data jurusan.');
        }
    }

    private function resetForm()
    {
        $this->majorId = null;
        $this->name    = '';
        $this->code    = '';
    }

    public function render()
    {
        return view('livewire.major.index', [
            'majors' => $this->majors,
            'title'  => 'Manajemen Jurusan',
        ]);
    }
}
