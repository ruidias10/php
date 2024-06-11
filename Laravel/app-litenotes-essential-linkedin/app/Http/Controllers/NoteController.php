<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /*
            // All notes
            //$userId = Auth::user()->id;
            $userId = Auth::id();

            // Using Eloquent
            // user_id = tabela user, campo id
            $notes = Note::where('user_id', $userId)->latest('updated_at')->get();

            // each() é um método do Collection
            // $notes->each(function($note){
            //     dump($note->title);
            // });

            #dd($notes);

            // return view('notes.index', $notes);
            return view('notes.index')->with('notes', $notes);
        */

        // // Paginate
        // $userId = Auth::id();
        // $notes = Note::where('user_id', $userId)->latest('updated_at')->paginate(5);
        // return view('notes.index')->with('notes', $notes);


        // Using Eloquent e relacionamento de 1:N hasMany e belongsTo
        // $notes = Auth::user()->notes()->latest('updated_at')->paginate(5);
        // return view('notes.index')->with('notes', $notes);


        // Using Eloquent e relacionamento de 1:N hasMany e belongsTo Laravel >= 8
        $notes = Note::whereBelongsTo(Auth::user())->latest('updated_at')->paginate(5);

        return view('notes.index')->with('notes', $notes);
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
        $request->validate([
            'title' => 'required|max:120',
            'body' => 'required'
        ]);

        // $note = new Note([
        //     'user_id' => Auth::id(),
        //     'title' => $request->title,
        //     'text' => $request->text
        // ]);

        // $note->save();

        // Note::create([
        //     'uuid' => Str::uuid(), // 'uuid' => 'uuid_generate_v4()
        //     'user_id' => Auth::id(),
        //     'title' => $request->title,
        //     'text' => $request->text
        // ]);

        // Using Eloquent e relacionamento de 1:N hasMany e belongsTo
        Auth::user()->notes()->create([
            'uuid' => Str::uuid(),
            'title' => $request->title,
            'text' => $request->text
        ]);

        return to_route('notes.index');
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $uuid)
    // {
    //     $note = Note::where('uuid', $uuid)->where('user_id', Auth::id())->firstOrFail();

    //     return view('notes.show')->with('note', $note);
    // }

    public function show(Note $note)
    {
        // if ($note->user_id != Auth::id()) {
        //     return abort(403);
        // }

        if (!$note->user->is(Auth::user())) {
            return abort(403);
        }

        return view('notes.show')->with('note', $note);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    // }

    public function edit(Note $note)
    {
        // if ($note->user_id != Auth::id()) {
        //     return abort(403);
        // }

        if (!$note->user->is(Auth::user())) {
            return abort(403);
        }

        return view('notes.edit')->with('note', $note);
    }

    /**
     * Update the specified resource in storage.
     */
    /*
    public function update(Request $request, string $id)
    {
    }
    */

    public function update(Request $request, Note $note)
    {
        // if ($note->user_id != Auth::id()) {
        //     return abort(403);
        // }

        if (!$note->user->is(Auth::user())) {
            return abort(403);
        }

        $request->validate([
            'title' => 'required|max:120',
            'body' => 'required'
        ]);

        $note->update([
            'title' => $request->title,
            'text' => $request->text
        ]);

        return to_route('notes.show', $note)->with('success', 'Note updated successfully');
    }



    /**
     * Remove the specified resource from storage.
     */
    /*
    public function destroy(string $id)
    {
    }
    */

    public function destroy(Note $note)
    {
        // if ($note->user_id != Auth::id()) {
        //     return abort(403);
        // }

        if (!$note->user->is(Auth::user())) {
            return abort(403);
        }

        $note->delete();

        return to_route('notes.index')->with('success', 'Note moved to trash');
    }
}
