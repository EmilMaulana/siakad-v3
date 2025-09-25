<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Login;
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\AcademicYear\Index as AcademicYearIndex;
use App\Livewire\Major\Index as MajorIndex;
use App\Livewire\Teacher\Index as TeacherIndex;
use App\Livewire\Subject\Index as SubjectIndex;

Route::get('/', Login::class);

Route::get('/register', Register::class)->name('register');
Route::get('/login', Login::class)->name('login');

Route::get('/dashboard', DashboardIndex::class)->name('dashboard')->middleware('token');
Route::get('/academic-year', AcademicYearIndex::class)->name('academic-year.index')->middleware('token');
Route::get('/majors', MajorIndex::class)->name('major.index')->middleware('token');
Route::get('/teachers', TeacherIndex::class)->name('teacher.index')->middleware('token');
Route::get('/subjects', SubjectIndex::class)->name('subject.index')->middleware('token');
Route::get('/classes', App\Livewire\SchoolClass\Index::class)->name('class.index')->middleware('token');


