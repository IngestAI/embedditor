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
        $library = Library::first();
        $library->temperature = $request->temperature;
        $library->save();

        return redirect('/');
    }
}
