<?php

namespace App\Livewire;

use App\Models\Template;
use Livewire\Component;

class TemplateShow extends Component
{
    public $template;

    public function mount($id)
    {
        $this->template = Template::with(['sections.subsections.items'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.template-show')->layout('layouts.app');
    }
}
