<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileUploadRequest;
use App\Models\LibraryFile;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function upload(FileUploadRequest $request)
    {
        $file = $request->file('file');

        $libraryFile = new LibraryFile;
        $libraryFile->library_id = $request->library_id;
        $libraryFile->original_name = $file->getClientOriginalName();
        $libraryFile->file_key = Str::random(rand(32, 64));
        $checkKey = LibraryFile::where('file_key', $libraryFile->file_key)->first();
        while (!empty($checkKey->id)) {
            $libraryFile->file_key = Str::random(rand(32, 64));
            $checkKey = LibraryFile::where('file_key', $libraryFile->file_key)->first();
        }
        $libraryFile->filename = time() . $file->getClientOriginalName();
        $libraryFile->save();

        dd($file);
        $file->move($destinationPath,$file->getClientOriginalName());


        return view('library.index');
    }

    public function download()
    {
        return view('library.index');
    }
}
