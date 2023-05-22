<?php

namespace App\Http\Controllers;

use App\Http\Requests\LibrarySaveRequest;
use App\Models\Library;

class LibraryController extends Controller
{
    public function index()
    {
        $library = Library::default();
        return view('library.index', ['library' => $library]);
    }

    public function save(LibrarySaveRequest $request)
    {
        $library = Library::default();
        $library->temperature = $request->temperature;
        $library->chunk_separator = $request->chunk_separator ?? null;
        $library->save();

        return redirect('/');
    }
}
