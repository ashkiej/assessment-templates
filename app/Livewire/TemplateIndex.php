<?php

namespace App\Livewire;

use App\Models\Template;
use Livewire\Component;
use Livewire\WithPagination;

class TemplateIndex extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.template-index', [
            'templates' => Template::withCount('sections')->latest()->paginate(10)
        ])->layout('layouts.app');
    }

    public function delete($templateId)
    {
        $template = Template::findOrFail($templateId);
        $template->delete();

        session()->flash('success', 'Template deleted successfully!');
    }

    public function duplicate($templateId)
    {
        $template = Template::with(['sections.subsections.items'])->findOrFail($templateId);

        $newTemplate = $template->replicate();
        $newTemplate->name = $template->name . ' (Copy)';
        $newTemplate->save();

        foreach ($template->sections as $section) {
            $newSection = $section->replicate();
            $newSection->template_id = $newTemplate->id;
            $newSection->save();

            foreach ($section->subsections as $subsection) {
                $newSubsection = $subsection->replicate();
                $newSubsection->section_id = $newSection->id;
                $newSubsection->save();

                foreach ($subsection->items as $item) {
                    $newItem = $item->replicate();
                    $newItem->subsection_id = $newSubsection->id;
                    $newItem->save();
                }
            }
        }

        session()->flash('success', 'Template duplicated successfully!');
        return redirect()->route('templates.edit', $newTemplate->id);
    }
}
