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

    /**
     * @param array $requestChunks
     * @param array $requestChunkedList
     * @return array[]
     */
    public function reorderDataKeys(array $requestChunks, array $requestChunkedList) : array
    {
        $chunks = $chunkedList = [];
        $currentKey = 0;
        foreach ($requestChunks as $key => $chunk) {
            $chunks[$currentKey] = $chunk;
            if (isset($requestChunkedList[$key])) {
                $chunkedList[$currentKey] = (string)$currentKey;
            }
            $currentKey++;
        }

        return [
            'chunks'        => $chunks,
            'chunkedList'   => $chunkedList,
        ];
    }

    /**
     * @param array $chunks
     * @param string $chunkSeparator
     * @return array[]
     */
    public function splitDataBySeparator(array $data, string $chunkSeparator) : array
    {
        $chunksBySeparators = $chunkedListBySeparators = [];
        $currentKey = 0;

        foreach ($data['chunks'] as $key => $chunk) {
            $currentChunkedListStatus = isset($data['chunkedList'][$key]);

            $chunkParts = explode($chunkSeparator, $chunk);

            if (count($chunkParts) == 1) {
                $chunksBySeparators[$currentKey] = $chunk;
                if ($currentChunkedListStatus) {
                    $chunkedListBySeparators[$currentKey] = (string)$currentKey;
                }
                $currentKey++;
                continue;
            }

            foreach ($chunkParts as $value) {
                $chunksBySeparators[$currentKey] = $value;
                if ($currentChunkedListStatus) {
                    $chunkedListBySeparators[$currentKey] = (string)$currentKey;
                }
                $currentKey++;
            }
        }

        return [
            'chunks'        => $chunksBySeparators,
            'chunkedList'   => $chunkedListBySeparators,
        ];
    }
}
