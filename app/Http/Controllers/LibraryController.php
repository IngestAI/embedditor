<?php

namespace App\Http\Controllers;

use App\Http\Requests\LibrarySaveRequest;
use App\Models\Library;

class LibraryController extends Controller
{
    public function index()
    {
        $library = Library::first();
        return view('library.index', ['library' => $library]);
    }

    public function save(LibrarySaveRequest $request)
    {
        $data = $request->only(['name', 'temperature', 'chunk_size']);
        $library = empty($request->id) ? new Library() : Library::first();
        $library->fill($data);
        $library->save();

        return redirect('/');
    }
}
