<?php

namespace App\Services\Editors;

use App\Http\Helpers\EmbedHelper;
use App\Models\LibraryFile;
use App\Services\Ai\AiService;
use App\Services\Ai\Mappers\StripAiMapper;
use Log;

class FileChunksEmbeddedEditor extends BaseFileChunks
{
    private LibraryFile $libraryFile;

    public function execute(LibraryFile $libraryFile)
    {
        $libraryFile->chunked = LibraryFile::STATUS_CHUNKED_PROCESSING;
        $libraryFile->save();

        $embeddedFilePath = $libraryFile->getPathToSavingEmbeddedFile();
        $embeddedFile = json_decode($this->embeddedStorageService->get($embeddedFilePath));
        if (empty($embeddedFile->html)) {
            return $this->handleSuccessResult($libraryFile);
        }

        $chunks = self::filterChunksByList($embeddedFile->html, $libraryFile->chunked_list);
        if (empty($chunks)) {
            return $this->handleSuccessResult($libraryFile);
        }

        $data = $this->getTextsAndVectors($libraryFile, $chunks);
        if (empty($data['texts']) || empty($data['vectors'])) {
            return $this->handleSuccessResult($libraryFile);
        }

        $embeddedFile->texts    = $data['texts'];
        $embeddedFile->vectors  = $data['vectors'];
        $this->embeddedStorageService->upload($embeddedFilePath, json_encode($embeddedFile));

        return $this->handleSuccessResult($libraryFile);
    }

    /**
     * @param LibraryFile $libraryFile
     * @return bool
     */
    private function handleSuccessResult(LibraryFile $libraryFile) : bool
    {
        $libraryFile->chunked = LibraryFile::STATUS_CHUNKED_OK;
        $libraryFile->save();
        return true;
    }

    /**
     * @param array $chunks
     * @return array[]
     */
    private function getTextsAndVectors(LibraryFile $libraryFile, array $chunks) : array
    {
        $client = AiService::createEmbeddingFactory();

        $texts = array();
        $vectors = array();
        foreach ($chunks as $key => $chunk) {

            $texts[$key] = StripAiMapper::make(self::prepareCustomChunk($chunk))->handle()->getResult();
            try {
                $response = $client->send($texts[$key], $libraryFile->library->embedded_model);
                if (!empty($response)) {
                    $vectors[$key] = $response;
                }

            } catch (\Exception $e) {
                Log::error($e->getMessage() . ' ' . $e->getTraceAsString());
                $vectors[$key] = [];
            }
        }

        return [
            'texts' => $texts,
            'vectors' => $vectors,
        ];
    }

    public static function filterChunksByList(array $chunks, array $chunkedList)
    {
        if (!isset($chunkedList)) {
            return $chunks;
        }

        $chunksByChunkedList = [];
        foreach ($chunks as $key => $chunk) {
            if (!in_array($key, $chunkedList)) continue;
            $chunksByChunkedList[] = $chunk;
        }

        return $chunksByChunkedList;
    }

    /**
     * @param LibraryFile $library
     * @return int
     */
    public static function prepareCustomChunk($chunk)
    {
        // removed hidden (red) text
        $chunk = preg_replace('/<span style="background-color: rgb\(230, 0, 0\);">([^<]+)<\/span>/', '', $chunk);

        // get keywords (green) text
        preg_match_all('/<span style="background-color: rgb\(0, 138, 0\);">([^<]+)<\/span>/', $chunk, $matches);
        $keyWords = !empty($matches[1]) ? implode(',', $matches[1]) : '';

        // chunkRequest
        return $keyWords ?: strip_tags(trim($chunk));
    }
}
