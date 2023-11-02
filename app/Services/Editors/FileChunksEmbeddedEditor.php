<?php

namespace App\Services\Editors;

use App\Models\LibraryFile;
use App\Services\Ai\AiService;
use App\Services\Editors\Filters\Chains\ChunkEditorFilterChain;
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

        $client = AiService::createEmbeddingFactory();
        $texts = [];
        $vectors = [];
        foreach ($embeddedFile->html as $key => $chunk) {

            // 1. Filter chunk by checkboxes
            if (isset($libraryFile->chunked_list) && !in_array($key, $libraryFile->chunked_list)) {
                $texts[] = '';
                $vectors[] = [];
                continue;
            }

            // 2. Filter chunk content by colors
            $texts[$key] = ChunkEditorFilterChain::make(self::prepareCustomChunk($chunk), $libraryFile)->handle();

            if (empty($texts[$key])) {
                $vectors[] = [];
                continue;
            }

            $vectors[$key] = [];
            try {
                $response = $client->send($texts[$key], $libraryFile->library->embedded_model);
                if (!empty($response)) {
                    $vectors[$key] = $response;
                }
            } catch (\Exception $e) {
                Log::error($e->getMessage() . ' ' . $e->getTraceAsString());
            }
        }

        $embeddedFile->texts    = $texts;
        $embeddedFile->vectors  = $vectors;
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
     * @param LibraryFile $library
     * @return int
     */
    public static function prepareCustomChunk($chunk)
    {
        // removed hidden (red) text
        $chunk = preg_replace('/<span style="background-color: rgb\(230, 0, 0\);">([^<]+)<\/span>/', '', $chunk);

        return strip_tags(trim($chunk));
    }
}
