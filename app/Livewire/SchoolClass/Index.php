<?php

namespace App\Livewire\SchoolClass;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Index extends Component
{
    public $classes = [];
    public $majors = [];
    public $academicYears = [];

    // data form
    public $classId, $name, $code, $major_id, $academic_year_id;
    public $isModalOpen = false;
    public $isDeleteModalOpen = false;
    public $deleteId = null;

    public $search = '';
    public $perPage = 10;
    public $currentPage = 1;
    public $total = 0;
    public $lastPage = 1;

    public function mount()
    {
        $this->loadClasses();
        $this->loadDropdownData();
    }

    public function updatingSearch()
    {
        $this->currentPage = 1;
        $this->loadClasses();
    }

    public function updatingPerPage()
    {
        $this->currentPage = 1;
        $this->loadClasses();
    }

    public function loadDropdownData()
    {
        $baseUrl = config('app.api_url');
        $token   = Session::get('token');

        // Ambil data Jurusan
        $responseMajors = Http::withToken($token)->get("{$baseUrl}/majors");
        if ($responseMajors->successful()) {
            // Asumsi responsnya memiliki struktur { "data": [...] }
            $this->majors = $responseMajors->json('data') ?? [];
        }

        // Ambil data Tahun Ajaran
        $responseAcademicYears = Http::withToken($token)->get("{$baseUrl}/academic-years");
        if ($responseAcademicYears->successful()) {
            // Asumsi responsnya memiliki struktur { "data": [...] }
            $this->academicYears = $responseAcademicYears->json('data') ?? [];
        }
    }

    public function loadClasses()
    {
        $baseUrl = config('app.api_url');
        $token   = Session::get('token');

        $response = Http::withToken($token)->get("{$baseUrl}/classes", [
            'search'   => $this->search,
            'per_page' => $this->perPage,
            'page'     => $this->currentPage,
        ]);

        if ($response->successful()) {
            // Ambil seluruh isi JSON dari response
            $result = $response->json();

            // Akses data sesuai dengan struktur JSON dari Postman
            $this->classes     = $result['data']['data'] ?? [];
            $this->currentPage = $result['data']['current_page'] ?? 1;
            $this->lastPage    = $result['data']['last_page'] ?? 1;
            $this->total       = $result['data']['total'] ?? 0;
        } else {
            // Jika API gagal, pastikan classes adalah array kosong
            $this->classes = [];
            session()->flash('error', 'Gagal memuat data kelas dari server.');
        }
    }

    public function goToPage($page)
    {
        if ($page >= 1 && $page <= $this->lastPage) {
            $this->currentPage = $page;
            $this->loadClasses();
        }
    }

    public function openModal($id = null)
    {
        $this->resetInput();
        if ($id) {
            $class = collect($this->classes)->firstWhere('id', $id);
            if ($class) {
                $this->classId          = $class['id'];
                $this->name             = $class['name'];
                $this->code             = $class['code'];
                $this->major_id         = $class['major_id'];
                $this->academic_year_id = $class['academic_year_id'];
            }
        }
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->classId = null;
        $this->name = '';
        $this->code = '';
        $this->major_id = '';
        $this->academic_year_id = '';
    }

    public function store()
    {
        $this->validate([
            'name'             => 'required|string',
            'code'             => 'required|string',
            'major_id'         => 'required|integer',
            'academic_year_id' => 'required|integer',
        ]);

        $baseUrl = config('app.api_url');
        $token   = Session::get('token');

        $payload = [
            'name'             => $this->name,
            'code'             => $this->code,
            'major_id'         => $this->major_id,
            'academic_year_id' => $this->academic_year_id,
        ];

        if ($this->classId) {
            $response = Http::withToken($token)->put("{$baseUrl}/classes/{$this->classId}", $payload);
        } else {
            $response = Http::withToken($token)->post("{$baseUrl}/classes", $payload);
        }

        if ($response->successful()) {
            $this->loadClasses();
            $this->closeModal();
        }
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->isDeleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->isDeleteModalOpen = false;
        $this->deleteId = null;
    }

    public function delete()
    {
        if (!$this->deleteId) return;

        $baseUrl = config('app.api_url');
        $token   = Session::get('token');

        Http::withToken($token)->delete("{$baseUrl}/classes/{$this->deleteId}");

        $this->loadClasses();
        $this->closeDeleteModal();

        session()->flash('success', 'Data kelas berhasil dihapus');
    }

    public function render()
    {
        return view('livewire.school-class.index', [
            'classes'     => $this->classes,
            'total'       => $this->total,
            'currentPage' => $this->currentPage,
            'lastPage'    => $this->lastPage,
        ]);
    }
}
