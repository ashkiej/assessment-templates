<form wire:submit.prevent="update" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Edit Template</h1>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Template Name *</label>
            <input type="text" wire:model="name"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Enter template name">
            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea wire:model="description" rows="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Enter template description"></textarea>
            @error('description')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <button type="button" wire:click="addSection"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>Add Section
        </button>
    </div>

    @foreach ($sections as $sectionIndex => $section)
        <div class="bg-white rounded-lg shadow-sm mb-4 overflow-hidden" wire:key="section-{{ $sectionIndex }}">
            <div class="{{ $section['color'] }} p-4">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2 flex-1">
                        <div class="flex flex-col gap-1">
                            <button type="button" wire:click="moveSectionUp({{ $sectionIndex }})"
                                class="p-1 bg-white rounded hover:bg-gray-100 {{ $sectionIndex === 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $sectionIndex === 0 ? 'disabled' : '' }}>
                                <i class="fas fa-chevron-up text-xs"></i>
                            </button>
                            <button type="button" wire:click="moveSectionDown({{ $sectionIndex }})"
                                class="p-1 bg-white rounded hover:bg-gray-100 {{ $sectionIndex === count($sections) - 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $sectionIndex === count($sections) - 1 ? 'disabled' : '' }}>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                        </div>
                        <input type="text" wire:model="sections.{{ $sectionIndex }}.title"
                            class="text-lg font-semibold bg-white bg-opacity-70 border-none rounded px-3 py-1 outline-none flex-1"
                            placeholder="Section title">
                    </div>

                    <div class="flex gap-2 items-center">
                        <label class="flex items-center gap-2 bg-transparent px-3 py-1 rounded text-sm">
                            <input type="checkbox" wire:model="sections.{{ $sectionIndex }}.has_ratings"
                                class="rounded">
                            <span>Show Ratings</span>
                        </label>
                        <button type="button" wire:click="removeSection({{ $sectionIndex }})"
                            class="p-2 bg-transparent text-red-600 rounded hover:bg-red-200">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                @error("sections.{$sectionIndex}.title")
                    <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
                @enderror

                @if ($section['has_ratings'])
                    <div class="bg-white bg-opacity-80 rounded p-3 mt-3">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-semibold text-sm text-gray-700">Rating Columns</h4>
                            <button type="button" wire:click="addRatingColumn({{ $sectionIndex }})"
                                class="text-xs px-3 py-1 bg-green-100 text-green-700 rounded hover:bg-green-200">
                                <i class="fas fa-plus mr-1"></i>Add Column
                            </button>
                        </div>
                        <div class="space-y-2">
                            @foreach ($section['rating_columns'] as $columnIndex => $column)
                                <div class="flex items-center gap-2"
                                    wire:key="rating-col-{{ $sectionIndex }}-{{ $columnIndex }}">
                                    <input type="text"
                                        wire:model="sections.{{ $sectionIndex }}.rating_columns.{{ $columnIndex }}.name"
                                        class="flex-1 px-3 py-1 border border-gray-300 rounded text-sm"
                                        placeholder="Column name (e.g., Experience)">
                                    <input type="number"
                                        wire:model="sections.{{ $sectionIndex }}.rating_columns.{{ $columnIndex }}.max_rating"
                                        class="w-20 px-3 py-1 border border-gray-300 rounded text-sm" min="1"
                                        max="10" placeholder="Max">
                                    <span class="text-xs text-gray-500">ratings</span>
                                    <button type="button"
                                        wire:click="removeRatingColumn({{ $sectionIndex }}, {{ $columnIndex }})"
                                        class="p-1 text-red-600 hover:bg-red-50 rounded">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                @error("sections.{$sectionIndex}.rating_columns.{$columnIndex}.name")
                                    <div class="text-red-500 text-xs">{{ $message }}</div>
                                @enderror
                                @error("sections.{$sectionIndex}.rating_columns.{$columnIndex}.max_rating")
                                    <div class="text-red-500 text-xs">{{ $message }}</div>
                                @enderror
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="p-4">
                <button type="button" wire:click="addSubsection({{ $sectionIndex }})"
                    class="mb-3 px-3 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 text-sm">
                    <i class="fas fa-plus mr-1"></i>Add Subsection
                </button>

                @forelse($section['subsections'] as $subsectionIndex => $subsection)
                    <div class="mb-4 border rounded-lg overflow-hidden"
                        wire:key="subsection-{{ $sectionIndex }}-{{ $subsectionIndex }}">
                        <div class="bg-gray-50 p-3 flex items-center justify-between border-b">
                            <div class="flex items-center gap-2 flex-1">
                                <div class="flex flex-col gap-1">
                                    <button type="button"
                                        wire:click="moveSubsectionUp({{ $sectionIndex }}, {{ $subsectionIndex }})"
                                        class="p-0.5 bg-white rounded hover:bg-gray-100 text-xs {{ $subsectionIndex === 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ $subsectionIndex === 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-chevron-up"></i>
                                    </button>
                                    <button type="button"
                                        wire:click="moveSubsectionDown({{ $sectionIndex }}, {{ $subsectionIndex }})"
                                        class="p-0.5 bg-white rounded hover:bg-gray-100 text-xs {{ $subsectionIndex === count($section['subsections']) - 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ $subsectionIndex === count($section['subsections']) - 1 ? 'disabled' : '' }}>
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <input type="text"
                                    wire:model="sections.{{ $sectionIndex }}.subsections.{{ $subsectionIndex }}.title"
                                    class="font-medium bg-white border rounded px-3 py-1 outline-none flex-1"
                                    placeholder="Subsection title">
                            </div>

                            <div class="flex gap-2 items-center">
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="checkbox"
                                        wire:model="sections.{{ $sectionIndex }}.subsections.{{ $subsectionIndex }}.has_ratings"
                                        class="rounded">
                                    <span>Ratings</span>
                                </label>
                                <button type="button"
                                    wire:click="addItem({{ $sectionIndex }}, {{ $subsectionIndex }})"
                                    class="px-3 py-1 bg-white text-gray-700 rounded border hover:bg-gray-100 text-sm">
                                    Add Item
                                </button>
                                <button type="button"
                                    wire:click="removeSubsection({{ $sectionIndex }}, {{ $subsectionIndex }})"
                                    class="p-1 text-red-600 hover:bg-red-50 rounded">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        @error("sections.{$sectionIndex}.subsections.{$subsectionIndex}.title")
                            <div class="px-3 py-2 bg-red-50 text-red-500 text-sm">{{ $message }}</div>
                        @enderror

                        @if (count($subsection['items']) > 0)
                            <div class="p-3">
                                @foreach ($subsection['items'] as $itemIndex => $item)
                                    <div class="flex items-center gap-2 mb-2"
                                        wire:key="item-{{ $sectionIndex }}-{{ $subsectionIndex }}-{{ $itemIndex }}">
                                        <div class="flex flex-col gap-1">
                                            <button type="button"
                                                wire:click="moveItemUp({{ $sectionIndex }}, {{ $subsectionIndex }}, {{ $itemIndex }})"
                                                class="p-0.5 bg-gray-100 rounded hover:bg-gray-200 text-xs {{ $itemIndex === 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                {{ $itemIndex === 0 ? 'disabled' : '' }}>
                                                <i class="fas fa-chevron-up"></i>
                                            </button>
                                            <button type="button"
                                                wire:click="moveItemDown({{ $sectionIndex }}, {{ $subsectionIndex }}, {{ $itemIndex }})"
                                                class="p-0.5 bg-gray-100 rounded hover:bg-gray-200 text-xs {{ $itemIndex === count($subsection['items']) - 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                {{ $itemIndex === count($subsection['items']) - 1 ? 'disabled' : '' }}>
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                        </div>
                                        <input type="text"
                                            wire:model="sections.{{ $sectionIndex }}.subsections.{{ $subsectionIndex }}.items.{{ $itemIndex }}.name"
                                            class="flex-1 px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Item name">
                                        <label class="flex items-center gap-2 text-sm whitespace-nowrap">
                                            <input type="checkbox"
                                                wire:model="sections.{{ $sectionIndex }}.subsections.{{ $subsectionIndex }}.items.{{ $itemIndex }}.has_ratings"
                                                class="rounded">
                                            <span>Ratings</span>
                                        </label>
                                        <button type="button"
                                            wire:click="removeItem({{ $sectionIndex }}, {{ $subsectionIndex }}, {{ $itemIndex }})"
                                            class="p-2 text-red-600 hover:bg-red-50 rounded">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    @error("sections.{$sectionIndex}.subsections.{$subsectionIndex}.items.{$itemIndex}.name")
                                        <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
                                    @enderror
                                @endforeach
                            </div>
                        @else
                            <div class="p-3 text-center text-gray-500">
                                No items yet. Click "Add Item" to get started.
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-8">
                        No subsections yet. Click "Add Subsection" to get started.
                    </div>
                @endforelse
            </div>
        </div>
    @endforeach

    <div class="bg-white rounded-lg shadow-sm p-6 flex justify-between">
        <a href="{{ route('templates.show', $templateId) }}"
            class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
            Cancel
        </a>
        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            <i class="fas fa-save mr-2"></i>Update Template
        </button>
    </div>
</form>
