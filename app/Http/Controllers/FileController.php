<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileUploadRequest;
use App\Models\LibraryFile;

class FileController extends Controller
{
    public function upload(FileUploadRequest $request)
    {
        $libraryFile = LibraryFile::create($request->only(['library_id', 'original_name', 'file_key', 'filename']));
        $libraryFile->saveRawFile($request->raw_content);


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

        return redirect('/');
    }
}
