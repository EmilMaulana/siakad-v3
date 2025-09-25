<?php

namespace App\Livewire\Teacher;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Index extends Component
{
    public $teachers = [];

    public $teacherId, $user_id, $name, $nip, $gender, $phone, $role_position_id;
    public $isModalOpen = false;
    public $isDeleteModalOpen = false;
    public $deleteId = null;

    public $search = '';
    public $perPage = 10;
    public $currentPage = 1;
    public $total = 0;
    public $lastPage = 1;
    public $perPageOptions = [5, 10, 25, 50];

    protected $queryString = [
        'search' => ['except' => ''],
        'currentPage' => ['except' => 1],
    ];

    public function mount()
    {
        $this->loadTeachers();
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
        $this->loadTeachers();
    }

    public function updatedPerPage()
    {
        $this->loadTeachers();
    }

    public function updatedCurrentPage()
    {
        $this->loadTeachers();
    }

    public function loadTeachers()
    {
        $baseUrl = config('app.api_url');
        $token   = Session::get('token');

        $response = Http::withToken($token)->get("{$baseUrl}/teachers", [
            'search'   => $this->search,
            'per_page' => $this->perPage,
            'page'     => $this->currentPage,
        ]);

        if ($response->successful()) {
            $result = $response->json('data') ?? [];
            $this->teachers   = $result['data'] ?? [];
            $this->currentPage = $result['current_page'] ?? 1;
            $this->total       = $result['total'] ?? 0;
            $this->lastPage    = $result['last_page'] ?? 1;
        } else {
            $this->teachers   = [];
            $this->currentPage = 1;
            $this->total       = 0;
            $this->lastPage    = 1;
        }
    }

    public function goToPage($page)
    {
        $page = max(1, min($page, $this->lastPage));
        $this->currentPage = $page;
        $this->loadTeachers();
    }

    public function openModal($id = null)
    {
        $this->resetInput();

        if ($id) {
            $teacher = collect($this->teachers)->firstWhere('id', $id);
            if ($teacher) {
                $this->teacherId        = $teacher['id'];
                $this->user_id          = $teacher['user_id'];
                $this->name             = $teacher['name'];
                $this->nip              = $teacher['nip'];
                $this->gender           = $teacher['gender'];
                $this->phone            = $teacher['phone'];
                $this->role_position_id = $teacher['role_position_id'];
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
        $this->teacherId = null;
        $this->user_id = '';
        $this->name = '';
        $this->nip = '';
        $this->gender = 'L';
        $this->phone = '';
        $this->role_position_id = '';
    }

    public function store()
    {
        $this->validate([
            'user_id'          => 'required|integer',
            'name'             => 'required|string',
            'nip'              => 'required|string',
            'gender'           => 'required|in:L,P',
            'phone'            => 'required|string',
            'role_position_id' => 'required|integer',
        ]);

        $baseUrl = config('app.api_url');
        $token   = Session::get('token');

        $payload = [
            'user_id'          => $this->user_id,
            'name'             => $this->name,
            'nip'              => $this->nip,
            'gender'           => $this->gender,
            'phone'            => $this->phone,
            'role_position_id' => $this->role_position_id,
        ];

        if ($this->teacherId) {
            $response = Http::withToken($token)->put("{$baseUrl}/teachers/{$this->teacherId}", $payload);
        } else {
            $response = Http::withToken($token)->post("{$baseUrl}/teachers", $payload);
        }

        if ($response->successful()) {
            $this->loadTeachers();
            $this->closeModal();
            session()->flash('success', $this->teacherId ? 'Data guru berhasil diperbarui' : 'Data guru berhasil ditambahkan');
        } else {
            session()->flash('error', 'Gagal menyimpan data guru');
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

        $response = Http::withToken($token)->delete("{$baseUrl}/teachers/{$this->deleteId}");

        if ($response->successful()) {
            session()->flash('success', 'Data guru berhasil dihapus');
        } else {
            session()->flash('error', 'Gagal menghapus data guru');
        }

        $this->loadTeachers();
        $this->closeDeleteModal();
    }

    public function render()
    {
        return view('livewire.teacher.index', [
            'teachers' => $this->teachers,
            'total'    => $this->total,
            'currentPage' => $this->currentPage,
            'lastPage'    => $this->lastPage,
            'perPageOptions' => $this->perPageOptions,
        ]);
    }
}
