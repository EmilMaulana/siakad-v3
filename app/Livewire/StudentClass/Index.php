<?php

namespace App\Livewire\StudentClass;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Index extends Component
{
    public $studentClasses = [];

    public $studentClassId, $student_id, $class_id;
    public $students = [];
    public $classes = [];
    public $academicYears = [];

    public $isModalOpen = false;
    public $isDeleteModalOpen = false;
    public $deleteId = null;

    public $search = '';
    public $perPage = 10;
    public $currentPage = 1;
    public $total = 0;
    public $lastPage = 1;
    public $perPageOptions = [5, 10, 25, 50];

    protected $queryString = [];

    public function mount()
    {
        $this->loadStudentClasses();
        $this->loadStudents();
        $this->loadClasses();
        $this->loadAcademicYears();
    }

    public function updatingSearch()
    {
        $this->currentPage = 1;
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->loadStudentClasses();
    }

    public function resetPage()
    {
        $this->currentPage = 1;
    }

    public function updatedPerPage()
    {
        $this->loadStudentClasses();
    }

    public function updatedCurrentPage()
    {
        $this->loadStudentClasses();
    }

    public function loadStudentClasses()
    {
        $baseUrl = config('app.api_url');
        $token   = Session::get('token');

        $queryParams = [
            'per_page' => $this->perPage,
            'page'     => $this->currentPage,
        ];

        if (!empty($this->search)) {
            $queryParams['search'] = $this->search;
        }

        $response = Http::withToken($token)->get("{$baseUrl}/student-classes", $queryParams);

        if ($response->successful()) {
            $result = $response->json('data') ?? [];
            $this->studentClasses = isset($result['data']) ? $result['data'] : $result;
            $this->currentPage = $result['current_page'] ?? 1;
            $this->total       = $result['total'] ?? count($this->studentClasses);
            $this->lastPage    = $result['last_page'] ?? 1;
        } else {
            $this->studentClasses = [];
            $this->currentPage = 1;
            $this->total = 0;
            $this->lastPage = 1;
        }
    }

    public function loadStudents()
    {
        $baseUrl = config('app.api_url');
        $token = Session::get('token');
        $response = Http::withToken($token)->get("{$baseUrl}/student", ['per_page' => 100]);
        $this->students = $response->successful() ? $response->json('data.data') ?? [] : [];
    }

    public function loadClasses()
    {
        $baseUrl = config('app.api_url');
        $token = Session::get('token');
        $response = Http::withToken($token)->get("{$baseUrl}/classes", ['per_page' => 100]);
        $this->classes = $response->successful() ? $response->json('data.data') ?? [] : [];
    }

    public function loadAcademicYears()
    {
        $baseUrl = config('app.api_url');
        $token = Session::get('token');
        $response = Http::withToken($token)->get("{$baseUrl}/academic-years", ['per_page' => 100]);
        $this->academicYears = $response->successful() ? $response->json('data.data') ?? [] : [];
    }

    public function goToPage($page)
    {
        $page = max(1, min($page, $this->lastPage));
        $this->currentPage = $page;
        $this->loadStudentClasses();
    }

    public function openModal($id = null)
    {
        $this->resetInput();

        if ($id) {
            $studentClass = collect($this->studentClasses)->firstWhere('id', $id);
            if ($studentClass) {
                $this->studentClassId = $studentClass['id'];
                $this->student_id = $studentClass['student_id'];
                $this->class_id = $studentClass['class_id'];
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
        $this->studentClassId = null;
        $this->student_id = '';
        $this->class_id = '';
    }

    public function store()
    {
        $this->validate([
            'student_id' => 'required|integer',
            'class_id'   => 'required|integer',
        ]);

        $baseUrl = config('app.api_url');
        $token   = Session::get('token');

        $payload = [
            'student_id' => $this->student_id,
            'class_id' => $this->class_id,
        ];

        if ($this->studentClassId) {
            $response = Http::withToken($token)->put("{$baseUrl}/student-classes/{$this->studentClassId}", $payload);
        } else {
            $response = Http::withToken($token)->post("{$baseUrl}/student-classes", $payload);
        }

        if ($response->successful()) {
            $this->loadStudentClasses();
            $this->closeModal();
            session()->flash('success', $this->studentClassId ? 'Penempatan siswa berhasil diperbarui.' : 'Penempatan siswa berhasil ditambahkan.');
        } else {
            $body = $response->json();
            if (isset($body['errors'])) {
                $firstError = collect($body['errors'])->flatten()->first();
                session()->flash('error', $firstError ?? 'Validasi gagal.');
            } else {
                session()->flash('error', $body['message'] ?? 'Gagal menyimpan penempatan siswa.');
            }
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

        $response = Http::withToken($token)->delete("{$baseUrl}/student-classes/{$this->deleteId}");

        if ($response->successful()) {
            session()->flash('success', 'Penempatan siswa berhasil dihapus.');
        } else {
            session()->flash('error', 'Gagal menghapus penempatan siswa.');
        }

        $this->loadStudentClasses();
        $this->closeDeleteModal();
    }

    public function render()
    {
        return view('livewire.student-class.index', [
            'studentClasses' => $this->studentClasses,
            'students' => $this->students,
            'classes' => $this->classes,
            'academicYears' => $this->academicYears,
            'total' => $this->total,
            'currentPage' => $this->currentPage,
            'lastPage' => $this->lastPage,
            'perPageOptions' => $this->perPageOptions,
        ]);
    }
}
