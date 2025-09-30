<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b">
            <h1 class="text-2xl font-bold text-gray-800">Assessment Templates</h1>
            <p class="text-gray-600 mt-1">Manage your assessment templates</p>
        </div>

        @if ($templates->isEmpty())
            <div class="p-12 text-center">
                <i class="fas fa-clipboard-list text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No templates yet</h3>
                <p class="text-gray-500 mb-6">Create your first assessment template to get started</p>
                <a href="{{ route('templates.create') }}"
                    class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-2"></i>Create Template
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Sections</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Created</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($templates as $template)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $template->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-500">{{ Str::limit($template->description, 50) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $template->sections_count }} sections
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $template->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $template->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $template->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('templates.show', $template->id) }}?print=1" target="_blank"
                                        class="text-gray-600 hover:text-gray-900 mr-3" title="Print">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <a href="{{ route('templates.downloadPdf', $template->id) }}"
                                        class="text-red-600 hover:text-red-900 mr-3" title="Download PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <a href="{{ route('templates.show', $template->id) }}"
                                        class="text-blue-600 hover:text-blue-900 mr-3" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('templates.edit', $template->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900 mr-3" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button wire:click="duplicate({{ $template->id }})"
                                        class="text-green-600 hover:text-green-900 mr-3" title="Duplicate">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                    <button wire:click="delete({{ $template->id }})"
                                        wire:confirm="Are you sure you want to delete this template?"
                                        class="text-red-600 hover:text-red-900" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t">
                {{ $templates->links() }}
            </div>
        @endif
    </div>
</div>
