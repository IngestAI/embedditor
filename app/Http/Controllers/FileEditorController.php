<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChunkUpdateRequest;
use App\Http\Requests\FileUploadRequest;
use App\Models\LibraryFile;
use App\Services\Editors\FileChunksEditor;
use App\Services\Editors\FileChunksEmbeddedEditor;
use App\Services\Storage\Adapters\UploadedStepService;
use App\Services\Storage\Drivers\StorageDriver;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $optimizePercentage = $libraryFile->total_embedded_words
            ? round(100 - 100 * (($libraryFile->total_words - ($libraryFile->total_words - $libraryFile->total_embedded_words)) / $libraryFile->total_words))
            : 0;

        return view('file.chunks.edit', [
            'libraryFile' => $libraryFile,
            'chunks' => $this->fileChunksEditorService->getItemChunked($libraryFile),
            'optimize_percentage' => $optimizePercentage,
        ]);
    }

    public function chunksUpdate(LibraryFile $libraryFile, ChunkUpdateRequest $request)
    {
        $data = $this->fileChunksEditorService->reorderDataKeys($request->chunks, $request->chunked_list);

        $chunkSeparator = $libraryFile->library->chunk_separator ?? LibraryFile::DEFAULT_CHUNK_SEPARATOR;
        $data = $this->fileChunksEditorService->splitDataBySeparator($data, $chunkSeparator);

        $libraryFile->stop_word = (bool) ($request->optimize ?? false);
        $libraryFile->lowercase = (bool) ($request->optimize ?? false);
        $libraryFile->strip_tag = (bool) ($request->optimize ?? false);
        $libraryFile->strip_punctuation = (bool) ($request->optimize ?? false);
        $libraryFile->strip_special_char = (bool) ($request->optimize ?? false);
        $libraryFile->chunked_list = $data['chunkedList'];
        $libraryFile->save();
        $libraryFile->saveFiles($request->images);
        $libraryFile->saveLinks($request->links);

        if (!$this->fileChunksEditorService->updateItemChunked($libraryFile, $data['chunks'])) {
            return back()->with('status', 'file-updated-error');
        }

        $this->fileChunksEmbeddedEditorService->execute($libraryFile);

        $libraryFile->total_words = $libraryFile->getTotalRawWords();
        $libraryFile->total_embedded_words = $libraryFile->getTotalEmbeddedWords();
        $libraryFile->save();

        return back()->with('status', 'file-updated-successfully');
    }
}
