<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileUploadRequest;
use App\Models\LibraryFile;

class FileController extends Controller
{
    public function upload(FileUploadRequest $request)
    {
        set_time_limit(600);
        $libraryFile = LibraryFile::create($request->only(['library_id', 'original_name', 'file_key', 'filename']));
        $libraryFile->saveRawFile($request->raw_content);
        $libraryFile->saveConvertedFile();
        $libraryFile->saveEmbeddedFile();

        return redirect('/');
    }

    public function download(string $fileKey)
    {
        $libraryFile = LibraryFile::where('file_key', $fileKey)->first();
        if (!$libraryFile) {
            return redirect('/');
        }

        return $libraryFile->downloadRawFile();
    }

    public function delete(LibraryFile $libraryFile)
    {
        $libraryFile->delete();
        $libraryFile->deleteRawFile();
        $libraryFile->deleteConvertedFile();
        $libraryFile->deleteEmbeddedFile();

        return response()->json(['result' => 1]);
    }

//    public function view(LibraryFile $libraryFile)
//    {
//        return response()->json(['result' => 1, 'name' => $libraryFile->original_name, 'content' => $libraryFile->getConvertedFile()]);
//    }

    public function chunks(LibraryFile $libraryFile)
    {
        return view('library.index');
    }
}
