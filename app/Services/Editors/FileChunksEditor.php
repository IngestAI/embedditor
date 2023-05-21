<?php

namespace App\Services\Editors;

use App\Models\LibraryFile;

class FileChunksEditor extends BaseFileChunks
{
    public function getItemChunked(LibraryFile $libraryFile)
    {
        $embeddedFilePath = $libraryFile->getPathToSavingEmbeddedFile();

        $embeddedFileHtml = [];
        if ($this->embeddedStorageService->exists($embeddedFilePath)) {
            $embeddedFile = json_decode($this->embeddedStorageService->get($embeddedFilePath));

            if (!empty($embeddedFile->html)) {
                foreach ($embeddedFile->html as $value) {
                    $embeddedFileHtml[] = str_replace(PHP_EOL, '<br>', $value);
                }
            }
        }

        return [
            'html' => $embeddedFileHtml,
            'texts' => $embeddedFile->texts,
        ];
    }

    public function updateItemChunked(LibraryFile $libraryFile, $aFileData)
    {
        $embeddedFilePath = $libraryFile->getPathToSavingEmbeddedFile();
        $embeddedFile = json_decode($this->embeddedStorageService->get($embeddedFilePath));
        $embeddedFile->html = $aFileData;

        return $this->embeddedStorageService->upload($embeddedFilePath, json_encode($embeddedFile));
    }
}
