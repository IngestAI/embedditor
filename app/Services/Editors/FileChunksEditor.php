<?php

namespace App\Services\Editors;

use App\Models\LibraryFile;

class FileChunksEditor extends BaseFileChunks
{
    public function getItemChunked(LibraryFile $libraryFile)
    {
        $embeddedFilePath = $libraryFile->getPathToSavingEmbeddedFile();

        $embeddedFileHtml = '';
        if ($this->embeddedStorageService->exists($embeddedFilePath)) {
            $embeddedFile = json_decode($this->embeddedStorageService->get($embeddedFilePath));
            if (!empty($embeddedFile->html)) {
                $embeddedFileHtml = str_replace("\n", '<br>', $embeddedFile->html);
            }
        }

        return $embeddedFileHtml;
    }

    public function updateItemChunked(LibraryFile $libraryFile, $aFileData)
    {
        $embeddedFilePath = $libraryFile->getPathToSavingEmbeddedFile();
        $embeddedFile = json_decode($this->embeddedStorageService->get($embeddedFilePath));
        $embeddedFile->html = $aFileData;

        return $this->embeddedStorageService->upload($embeddedFilePath, json_encode($embeddedFile));
    }
}
