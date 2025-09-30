<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\TemplateIndex;
use App\Livewire\TemplateCreate;
use App\Livewire\TemplateEdit;
use App\Livewire\TemplateShow;
use App\Http\Controllers\TemplateController;

Route::get('/', function () {
    return redirect()->route('templates.index');
});

Route::get('/templates', TemplateIndex::class)->name('templates.index');
Route::get('/templates/create', TemplateCreate::class)->name('templates.create');
Route::get('/templates/{id}', TemplateShow::class)->name('templates.show');
Route::get('/templates/{id}/edit', TemplateEdit::class)->name('templates.edit');
Route::get('/templates/{template}/download-pdf', [TemplateController::class, 'downloadPdf'])->name('templates.downloadPdf');
