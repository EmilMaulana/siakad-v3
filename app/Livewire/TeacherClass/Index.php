<?php

namespace App\Livewire\TeacherClass;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Index extends Component
{
    public $teacherClasses = [];

    public $teacherClassId, $teacher_id, $class_id;
    public $teachers = [];
    public $classes = [];

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
        $this->loadTeacherClasses();
        $this->loadTeachers();
        $this->loadClasses();
    }

    public function updatingSearch()
    {
        $this->currentPage = 1;
    }

    public function updatingPerPage()
    {
        $this->currentPage = 1;
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->loadTeacherClasses();
    }

    public function resetPage()
    {
        $this->currentPage = 1;
    }

    public function updatedPerPage()
    {
        $this->loadTeacherClasses();
    }

    public function updatedCurrentPage()
    {
        $this->loadTeacherClasses();
    }

    public function loadTeacherClasses()
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

        $response = Http::withToken($token)->get("{$baseUrl}/teacher-classes", $queryParams);

        if ($response->successful()) {
            $result = $response->json('data') ?? [];
            $this->teacherClasses = isset($result['data']) ? $result['data'] : $result;
            $this->currentPage = $result['current_page'] ?? 1;
            $this->total       = $result['total'] ?? count($this->teacherClasses);
            $this->lastPage    = $result['last_page'] ?? 1;
        } else {
            $this->teacherClasses = [];
            $this->currentPage = 1;
            $this->total = 0;
            $this->lastPage = 1;
        }
    }


    public function loadTeachers()
    {
        $baseUrl = config('app.api_url');
        $token = Session::get('token');
        $response = Http::withToken($token)->get("{$baseUrl}/teachers", ['per_page' => 100]);
        $this->teachers = $response->successful() ? $response->json('data.data') ?? [] : [];
    }

    public function loadClasses()
    {
        $baseUrl = config('app.api_url');
        $token = Session::get('token');
        $response = Http::withToken($token)->get("{$baseUrl}/classes", ['per_page' => 100]);
        $this->classes = $response->successful() ? $response->json('data.data') ?? [] : [];
    }

    public function goToPage($page)
    {
        $page = max(1, min($page, $this->lastPage));
        $this->currentPage = $page;
        $this->loadTeacherClasses();
    }

    public function openModal($id = null)
    {
        $this->resetInput();

        if ($id) {
            $teacherClass = collect($this->teacherClasses)->firstWhere('id', $id);
            if ($teacherClass) {
                $this->teacherClassId = $teacherClass['id'];
                $this->teacher_id = $teacherClass['teacher_id'];
                $this->class_id = $teacherClass['class_id'];
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
        $this->teacherClassId = null;
        $this->teacher_id = '';
        $this->class_id = '';
    }

    public function store()
    {
        $this->validate([
            'teacher_id' => 'required|integer',
            'class_id'   => 'required|integer',
        ]);

        $baseUrl = config('app.api_url');
        $token   = Session::get('token');

        $payload = [
            'teacher_id' => $this->teacher_id,
            'class_id'   => $this->class_id,
        ];

        if ($this->teacherClassId) {
            $response = Http::withToken($token)->put("{$baseUrl}/teacher-classes/{$this->teacherClassId}", $payload);
        } else {
            $response = Http::withToken($token)->post("{$baseUrl}/teacher-classes", $payload);
        }

        if ($response->successful()) {
            $this->loadTeacherClasses();
            $this->closeModal();
            session()->flash('success', $this->teacherClassId ? 'Penugasan guru berhasil diperbarui.' : 'Penugasan guru berhasil ditambahkan.');
        } else {
            $body = $response->json();
            if (isset($body['errors'])) {
                $firstError = collect($body['errors'])->flatten()->first();
                session()->flash('error', $firstError ?? 'Validasi gagal.');
            } else {
                session()->flash('error', $body['message'] ?? 'Gagal menyimpan penugasan guru.');
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

        $response = Http::withToken($token)->delete("{$baseUrl}/teacher-classes/{$this->deleteId}");

        if ($response->successful()) {
            session()->flash('success', 'Penugasan guru berhasil dihapus.');
        } else {
            session()->flash('error', 'Gagal menghapus penugasan guru.');
        }

        $this->loadTeacherClasses();
        $this->closeDeleteModal();
    }

    public function render()
    {
        return view('livewire.teacher-class.index', [
            'teacherClasses' => $this->teacherClasses,
            'teachers' => $this->teachers,
            'classes' => $this->classes,
            'total' => $this->total,
            'currentPage' => $this->currentPage,
            'lastPage' => $this->lastPage,
            'perPageOptions' => $this->perPageOptions,
        ]);
    }
}
