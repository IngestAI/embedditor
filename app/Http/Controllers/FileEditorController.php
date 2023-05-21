<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileUploadRequest;
use App\Models\LibraryFile;
use App\Services\Editors\FileChunksEditor;
use App\Services\Editors\FileChunksEmbeddedEditor;
use Illuminate\Http\Request;

class FileEditorController extends Controller
{
    private FileChunksEditor $fileChunksEditorService;
    private FileChunksEmbeddedEditor $fileChunksEmbeddedEditorService;

    public function __construct(FileChunksEditor $fileChunksEditor, FileChunksEmbeddedEditor $fileChunksEmbeddedEditor)
    {
        $this->fileChunksEditorService = $fileChunksEditor;
        $this->fileChunksEmbeddedEditorService = $fileChunksEmbeddedEditor;
    }

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


    public function chunksEdit(LibraryFile $libraryFile)
    {
        return view('file.chunks.edit', [
            'libraryFile' => $libraryFile,
            'chunks' => $this->fileChunksEditorService->getItemChunked($libraryFile),
        ]);
    }

    public function chunksUpdate(LibraryFile $libraryFile, Request $request)
    {
        $chunks = $chunkedList = [];
        $currentKey = 0;
        foreach ($request->chunks as $key => $chunk) {
            $chunks[$currentKey] = $chunk;
            if (isset($request->chunked_list[$key])) {
                $chunkedList[$currentKey] = (string)$currentKey;
            }
            $currentKey++;
        }

        $libraryFile->chunked_list = $chunkedList;
        $libraryFile->save();

        if (!$this->fileChunksEditorService->updateItemChunked($libraryFile, $chunks)) {
            return back()->with('status', 'file-updated-error');
        }

        $this->fileChunksEmbeddedEditorService->execute($libraryFile);
        return back()->with('status', 'file-updated-successfully');
    }
}
