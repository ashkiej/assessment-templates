<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="p-6 border-b flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $template->name }}</h1>
                @if ($template->description)
                    <p class="text-gray-600 mt-1">{{ $template->description }}</p>
                @endif
            </div>
            <div class="flex gap-2 print:hidden">
                <a href="{{ route('templates.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Back
                </a>
                <a href="{{ route('templates.edit', $template->id) }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
            </div>
        </div>
    </div>

    @foreach ($template->sections as $section)
        <div class="bg-white rounded-lg shadow-sm mb-4 overflow-hidden">
            <table class="w-full">
                <thead class="{{ $section->color }}">
                    <tr>
                        <th class="text-left p-4 text-lg font-semibold text-gray-800 w-2/5">
                            {{ 'Section ' . $section->order + 1 }}
                        </th>

                        @foreach ($section->ratingColumns as $column)
                            <th class="p-4 font-medium text-gray-800 text-center">
                                {{ $column->name }}
                            </th>
                        @endforeach

                    </tr>
                </thead>
                <tbody class="divide-y
                                divide-gray-200">
                    <tr class="bg-gray-100">
                        <td class="p-3 pl-6 font-medium">
                            {{ $section->title }} (Overall)
                        </td>
                        @if ($section->has_ratings)
                            @foreach ($section->ratingColumns as $column)
                                <td class="p-3">
                                    <div class="flex gap-1 justify-center">
                                        @for ($i = 1; $i <= $column->max_rating; $i++)
                                            <button type="button"
                                                class="w-8 h-8 rounded bg-gray-200 text-gray-700 hover:bg-blue-500 hover:text-white transition">
                                                {{ $i }}
                                            </button>
                                        @endfor
                                        <button type="button"
                                            class="w-8 h-8 rounded bg-gray-200 text-gray-700 hover:bg-gray-400 hover:text-white transition">
                                            NA
                                        </button>
                                    </div>
                                </td>
                            @endforeach
                        @else
                            <td class="p-3 text-center text-gray-400" colspan="{{ count($section->ratingColumns) }}">-
                            </td>
                        @endif
                    </tr>

                    @foreach ($section->subsections as $subsection)
                        <tr class="bg-gray-50">
                            <td class="p-3 pl-6 font-medium">
                                {{ $subsection->title }}
                                @if (!$subsection->has_ratings && $section->has_ratings)
                                    <span class="text-xs bg-gray-200 px-2 py-1 rounded ml-2">No Ratings</span>
                                @endif
                            </td>
                            @if ($subsection->has_ratings)
                                @foreach ($section->ratingColumns as $column)
                                    <td class="p-3">
                                        <div class="flex gap-1 justify-center ">
                                            @for ($i = 1; $i <= $column->max_rating; $i++)
                                                <button type="button"
                                                    class="w-8 h-8 rounded bg-gray-200 text-gray-700 hover:bg-blue-500 hover:text-white transition">
                                                    {{ $i }}
                                                </button>
                                            @endfor
                                            <button type="button"
                                                class="w-8 h-8 rounded bg-gray-200 text-gray-700 hover:bg-gray-400 hover:text-white transition">
                                                NA
                                            </button>
                                        </div>
                                    </td>
                                @endforeach
                            @else
                                <td class="p-3 text-center text-gray-400"
                                    colspan="{{ count($section->ratingColumns) }}">-</td>
                            @endif
                        </tr>

                        @foreach ($subsection->items as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 pl-12">
                                    {{ $item->name }}
                                    @if (!$item->has_ratings)
                                        <span class="text-xs bg-gray-200 px-2 py-1 rounded ml-2">No
                                            Ratings</span>
                                    @endif
                                </td>
                                @if ($item->has_ratings)
                                    @foreach ($section->ratingColumns as $column)
                                        <td class="p-3">
                                            <div class="flex gap-1 justify-center">
                                                @for ($i = 1; $i <= $column->max_rating; $i++)
                                                    <button type="button"
                                                        class="w-8 h-8 rounded bg-gray-200 text-gray-700 hover:bg-blue-500 hover:text-white transition">
                                                        {{ $i }}
                                                    </button>
                                                @endfor
                                                <button type="button"
                                                    class="w-8 h-8 rounded bg-gray-200 text-gray-700 hover:bg-gray-400 hover:text-white transition">
                                                    NA
                                                </button>
                                            </div>
                                        </td>
                                    @endforeach
                                @else
                                    @foreach ($section->ratingColumns as $column)
                                        <td class="p-3 text-center text-gray-400">-</td>
                                    @endforeach
                                @endif
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
</div>

@if (request()->query('print'))
    <script>
        window.onload = function() {
            window.print();
            setTimeout(function() {
                window.close();
            }, 1);
        }
    </script>
@endif
