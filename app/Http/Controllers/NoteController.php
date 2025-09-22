<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $notes = Note::where('user_id', Auth::id())
    //         // ->oldest()
    //         ->latest()
    //         ->paginate(10);

    //     return view('notes.index', compact('notes'));
    // }

public function index()
{
    $q = trim((string) request('q'));

    $notes = Note::where('user_id', Auth::id())
        ->when($q !== '', function ($query) use ($q) {
            $query->where('title', 'like', '%' . $q . '%');
        })
        // ->oldest()
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('notes.index', compact('notes'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'   => ['required', 'string', 'max:100'],
            'content' => ['required', 'string'],
        ]);

        Auth::user()->notes()->create($data);

        return redirect()->route('notes.index')->with('status', 'Note created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        $this->authorizeNote($note);
        return view('notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        $this->authorizeNote($note);
        return view('notes.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        $this->authorizeNote($note);

        $data = $request->validate([
            'title'   => ['required', 'string', 'max:100'],
            'content' => ['required', 'string'],
        ]);

        $note->update($data);

        return redirect()->route('notes.index')->with('status', 'Note updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        $this->authorizeNote($note);
        $note->delete();

        return redirect()->route('notes.index')->with('status', 'Note deleted.');
    }

    private function authorizeNote(Note $note): void
    {
        abort_if($note->user_id !== auth()->id(), 403);
    }
}
