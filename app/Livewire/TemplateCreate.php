<?php

namespace App\Livewire;

use App\Models\Template;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class TemplateCreate extends Component
{
    public $name = '';
    public $description = '';
    public $sections = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'sections.*.title' => 'required|string|max:255',
        'sections.*.color' => 'required|string',
        'sections.*.has_ratings' => 'boolean',
        'sections.*.rating_columns.*.name' => 'required|string|max:255',
        'sections.*.rating_columns.*.max_rating' => 'required|integer|min:1|max:10',
        'sections.*.subsections.*.title' => 'required|string|max:255',
        'sections.*.subsections.*.has_ratings' => 'boolean',
        'sections.*.subsections.*.items.*.name' => 'required|string|max:255',
        'sections.*.subsections.*.items.*.has_ratings' => 'boolean',
    ];

    public function mount()
    {
        $this->addSection();
    }

    public function addSection()
    {
        $this->sections[] = [
            'title' => '',
            'color' => 'bg-cyan-100',
            'has_ratings' => true,
            'rating_columns' => [
                ['name' => 'Experience', 'max_rating' => 4],
                ['name' => 'Frequency', 'max_rating' => 4]
            ],
            'subsections' => []
        ];
    }

    public function removeSection($sectionIndex)
    {
        unset($this->sections[$sectionIndex]);
        $this->sections = array_values($this->sections);
    }

    public function addRatingColumn($sectionIndex)
    {
        $this->sections[$sectionIndex]['rating_columns'][] = [
            'name' => '',
            'max_rating' => 4
        ];
    }

    public function removeRatingColumn($sectionIndex, $columnIndex)
    {
        unset($this->sections[$sectionIndex]['rating_columns'][$columnIndex]);
        $this->sections[$sectionIndex]['rating_columns'] = array_values($this->sections[$sectionIndex]['rating_columns']);
    }

    public function addSubsection($sectionIndex)
    {
        $this->sections[$sectionIndex]['subsections'][] = [
            'title' => '',
            'has_ratings' => true,
            'items' => []
        ];
    }

    public function removeSubsection($sectionIndex, $subsectionIndex)
    {
        unset($this->sections[$sectionIndex]['subsections'][$subsectionIndex]);
        $this->sections[$sectionIndex]['subsections'] = array_values($this->sections[$sectionIndex]['subsections']);
    }

    public function addItem($sectionIndex, $subsectionIndex)
    {
        $this->sections[$sectionIndex]['subsections'][$subsectionIndex]['items'][] = [
            'name' => '',
            'has_ratings' => true
        ];
    }

    public function removeItem($sectionIndex, $subsectionIndex, $itemIndex)
    {
        unset($this->sections[$sectionIndex]['subsections'][$subsectionIndex]['items'][$itemIndex]);
        $this->sections[$sectionIndex]['subsections'][$subsectionIndex]['items'] =
            array_values($this->sections[$sectionIndex]['subsections'][$subsectionIndex]['items']);
    }

    // Ordering methods
    public function moveSectionUp($sectionIndex)
    {
        if ($sectionIndex > 0) {
            $temp = $this->sections[$sectionIndex];
            $this->sections[$sectionIndex] = $this->sections[$sectionIndex - 1];
            $this->sections[$sectionIndex - 1] = $temp;
        }
    }

    public function moveSectionDown($sectionIndex)
    {
        if ($sectionIndex < count($this->sections) - 1) {
            $temp = $this->sections[$sectionIndex];
            $this->sections[$sectionIndex] = $this->sections[$sectionIndex + 1];
            $this->sections[$sectionIndex + 1] = $temp;
        }
    }

    public function moveSubsectionUp($sectionIndex, $subsectionIndex)
    {
        if ($subsectionIndex > 0) {
            $temp = $this->sections[$sectionIndex]['subsections'][$subsectionIndex];
            $this->sections[$sectionIndex]['subsections'][$subsectionIndex] =
                $this->sections[$sectionIndex]['subsections'][$subsectionIndex - 1];
            $this->sections[$sectionIndex]['subsections'][$subsectionIndex - 1] = $temp;
        }
    }

    public function moveSubsectionDown($sectionIndex, $subsectionIndex)
    {
        $subsections = $this->sections[$sectionIndex]['subsections'];
        if ($subsectionIndex < count($subsections) - 1) {
            $temp = $this->sections[$sectionIndex]['subsections'][$subsectionIndex];
            $this->sections[$sectionIndex]['subsections'][$subsectionIndex] =
                $this->sections[$sectionIndex]['subsections'][$subsectionIndex + 1];
            $this->sections[$sectionIndex]['subsections'][$subsectionIndex + 1] = $temp;
        }
    }

    public function moveItemUp($sectionIndex, $subsectionIndex, $itemIndex)
    {
        if ($itemIndex > 0) {
            $temp = $this->sections[$sectionIndex]['subsections'][$subsectionIndex]['items'][$itemIndex];
            $this->sections[$sectionIndex]['subsections'][$subsectionIndex]['items'][$itemIndex] =
                $this->sections[$sectionIndex]['subsections'][$subsectionIndex]['items'][$itemIndex - 1];
            $this->sections[$sectionIndex]['subsections'][$subsectionIndex]['items'][$itemIndex - 1] = $temp;
        }
    }

    public function moveItemDown($sectionIndex, $subsectionIndex, $itemIndex)
    {
        $items = $this->sections[$sectionIndex]['subsections'][$subsectionIndex]['items'];
        if ($itemIndex < count($items) - 1) {
            $temp = $this->sections[$sectionIndex]['subsections'][$subsectionIndex]['items'][$itemIndex];
            $this->sections[$sectionIndex]['subsections'][$subsectionIndex]['items'][$itemIndex] =
                $this->sections[$sectionIndex]['subsections'][$subsectionIndex]['items'][$itemIndex + 1];
            $this->sections[$sectionIndex]['subsections'][$subsectionIndex]['items'][$itemIndex + 1] = $temp;
        }
    }

    public function save()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $template = Template::create([
                'name' => $this->name,
                'description' => $this->description,
                'is_active' => true,
            ]);

            foreach ($this->sections as $sectionOrder => $sectionData) {
                $section = $template->sections()->create([
                    'title' => $sectionData['title'],
                    'color' => $sectionData['color'],
                    'order' => $sectionOrder,
                    'has_ratings' => $sectionData['has_ratings'],
                ]);

                // Save rating columns
                foreach ($sectionData['rating_columns'] as $columnOrder => $columnData) {
                    $section->ratingColumns()->create([
                        'name' => $columnData['name'],
                        'max_rating' => $columnData['max_rating'],
                        'order' => $columnOrder,
                    ]);
                }

                foreach ($sectionData['subsections'] as $subsectionOrder => $subsectionData) {
                    $subsection = $section->subsections()->create([
                        'title' => $subsectionData['title'],
                        'order' => $subsectionOrder,
                        'has_ratings' => $subsectionData['has_ratings'],
                    ]);

                    foreach ($subsectionData['items'] as $itemOrder => $itemData) {
                        $subsection->items()->create([
                            'name' => $itemData['name'],
                            'order' => $itemOrder,
                            'has_ratings' => $itemData['has_ratings'],
                        ]);
                    }
                }
            }

            DB::commit();
            session()->flash('success', 'Template created successfully!');
            return redirect()->route('templates.show', $template->id);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error creating template: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.template-create')->layout('layouts.app');
    }
}
