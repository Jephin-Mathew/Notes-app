<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $note->title }}</h2>
            <div class="text-sm text-gray-500">Created {{ $note->created_at->format('M d, Y H:i') }}</div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6 prose max-w-none">
                {!! nl2br(e($note->content)) !!}
            </div>

            <div class="mt-6 flex gap-3">
                <a href="{{ route('notes.edit', $note) }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg font-medium transition-colors">
                    Edit
                </a>
                <form action="{{ route('notes.destroy', $note) }}" method="POST"
                      onsubmit="return confirm('Delete this note?')" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg font-medium transition-colors">
                        Delete
                    </button>
                </form>
                <a href="{{ route('notes.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 border border-gray-300 rounded-lg font-medium transition-colors">
                    Back
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
