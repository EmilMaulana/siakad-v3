<?php

namespace App\Livewire\AcademicYear;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Index extends Component
{
    public $academicYears = [];

    // form
    public $academicYearId;
    public $year;
    public $is_active = false;

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

        $response = Http::withToken($token)->get("{$baseUrl}/academic-years");

        if ($response->successful()) {
            $this->academicYears = $response->json('data') ?? [];
        }
    }

    public function openModal($id = null)
    {
        $this->resetForm();
        $this->isModalOpen = true;

        if ($id) {
            $this->academicYearId = $id;

            $year = collect($this->academicYears)->firstWhere('id', $id);
            if ($year) {
                $this->year      = $year['year'];
                $this->is_active = $year['is_active'];
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
            'year' => 'required|string|max:20',
        ]);

        $baseUrl = config('app.api_url');
        $token   = Session::get('token');

        $payload = [
            'year'      => $this->year,
            'is_active' => $this->is_active,
        ];

        if ($this->academicYearId) {
            // Update
            $response = Http::withToken($token)->put("{$baseUrl}/academic-years/{$this->academicYearId}", $payload);
        } else {
            // Create
            $response = Http::withToken($token)->post("{$baseUrl}/academic-years", $payload);
        }

        if ($response->successful()) {
            $this->fetchData();
            $this->closeModal();
            session()->flash('success', 'Data tahun akademik berhasil disimpan.');
        } else {
            session()->flash('error', 'Gagal menyimpan data tahun akademik.');
        }
    }

    private function resetForm()
    {
        $this->academicYearId = null;
        $this->year           = '';
        $this->is_active      = false;
    }

    public function render()
    {
        return view('livewire.academic-year.index', [
            'academicYears' => $this->academicYears
        ]);
    }
}
