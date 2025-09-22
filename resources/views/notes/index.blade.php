<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Your Notes
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg border border-green-200">
                    {{ session('status') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <form method="GET" class="flex gap-3">
                    <input name="q" value="{{ request('q') }}" placeholder="Search title..."
                           class="border border-gray-300 rounded-lg px-4 py-2 w-64 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                    <button class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-black rounded-lg font-medium shadow-sm transition-colors">
                        Search
                    </button>
                </form>
                <a href="{{ route('notes.create') }}"
                   class="inline-flex items-center px-6 py-2 bg-green-600 text-black rounded-lg hover:bg-green-700 font-medium shadow-lg transition-all hover:scale-105">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Note
                </a>
            </div>

            <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                <ul class="divide-y divide-gray-200">
                    @forelse ($notes as $note)
                        <li class="p-6 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <a href="{{ route('notes.show', $note) }}"
                                       class="font-semibold text-lg text-gray-900 hover:text-indigo-600 hover:underline">
                                        {{ $note->title }}
                                    </a>
                                    <div class="text-sm text-gray-500 mt-1">
                                        Created {{ $note->created_at->format('M d, Y H:i') }}
                                    </div>
                                </div>
                                <div class="flex items-center gap-4 ml-6">
                                    <a href="{{ route('notes.edit', $note) }}"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-black hover:bg-blue-700 rounded-lg font-medium transition-all shadow-md hover:shadow-lg">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('notes.destroy', $note) }}" method="POST"
                                          onsubmit="return confirm('Delete this note?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="inline-flex items-center px-4 py-2 bg-red-600 text-white hover:bg-red-700 rounded-lg font-medium transition-all shadow-md hover:shadow-lg">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="p-8 text-center text-gray-500">
                            <div class="text-lg">No notes yet.</div>
                            <p class="mt-2">Create your first note to get started!</p>
                        </li>
                    @endforelse
                </ul>
            </div>

            <div class="mt-4">
                {{ $notes->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
