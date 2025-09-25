<?php

namespace App\Livewire\Subject;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Index extends Component
{
    public $subjects = [];

    // form data
    public $subjectId, $name, $code, $hours;
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
        $this->loadSubjects();
    }

    public function updatingSearch()
    {
        $this->currentPage = 1;
        $this->loadSubjects();
    }

    public function updatingPerPage()
    {
        $this->currentPage = 1;
        $this->loadSubjects();
    }

    public function loadSubjects()
    {
        $baseUrl = config('app.api_url');
        $token   = Session::get('token');

        $response = Http::withToken($token)->get("{$baseUrl}/subjects", [
            'search'   => $this->search,
            'per_page' => $this->perPage,
            'page'     => $this->currentPage,
        ]);

        if ($response->successful()) {
            $result = $response->json('data') ?? [];

            $this->subjects    = $result['data'] ?? [];
            $this->currentPage = $result['current_page'] ?? 1;
            $this->total       = $result['total'] ?? 0;
            $this->lastPage    = $result['last_page'] ?? 1;
        }
    }

    public function goToPage($page)
    {
        if ($page >= 1 && $page <= $this->lastPage) {
            $this->currentPage = $page;
            $this->loadSubjects();
        }
    }

    public function openModal($id = null)
    {
        $this->resetInput();
        if ($id) {
            $subject = collect($this->subjects)->firstWhere('id', $id);
            if ($subject) {
                $this->subjectId = $subject['id'];
                $this->name      = $subject['name'];
                $this->code      = $subject['code'];
                $this->hours     = $subject['hours'];
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
        $this->subjectId = null;
        $this->name      = '';
        $this->code      = '';
        $this->hours     = '';
    }

    public function store()
    {
        $this->validate([
            'name'  => 'required|string',
            'code'  => 'required|string',
            'hours' => 'required|integer',
        ]);

        $baseUrl = config('app.api_url');
        $token   = Session::get('token');

        $payload = [
            'name'  => $this->name,
            'code'  => $this->code,
            'hours' => $this->hours,
        ];

        if ($this->subjectId) {
            $response = Http::withToken($token)->put("{$baseUrl}/subjects/{$this->subjectId}", $payload);
        } else {
            $response = Http::withToken($token)->post("{$baseUrl}/subjects", $payload);
        }

        if ($response->successful()) {
            $this->loadSubjects();
            $this->closeModal();
            session()->flash('success', 'Data mata pelajaran berhasil disimpan');
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

        $response = Http::withToken($token)->delete("{$baseUrl}/subjects/{$this->deleteId}");


        if ($response->successful()) {
            session()->flash('success', 'Data mata pelajaran berhasil dihapus');
        } else {
            session()->flash('error', 'Gagal menghapus mata pelajaran');
        }

        $this->loadSubjects();
        $this->closeDeleteModal();
    }

    public function render()
    {
        return view('livewire.subject.index', [
            'subjects'    => $this->subjects,
            'total'       => $this->total,
            'currentPage' => $this->currentPage,
            'lastPage'    => $this->lastPage,
        ]);
    }
}
