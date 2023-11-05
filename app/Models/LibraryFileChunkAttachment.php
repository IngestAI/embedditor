<?php
namespace App\Models;

use App\Services\Storage\Adapters\EmbeddedStepService;
use App\Services\Storage\Adapters\UploadedStepService;
use App\Services\Storage\Drivers\StorageDriver;
use Illuminate\Support\Facades\Storage;

trait LibraryFileChunkAttachment
{
    public function getPathToAttachments(): string
    {
        return 'public/'
            . self::DISK_CORE_PATH
            . '/'
            .  self::DISK_SUB_PATH_ATTACHMENTS
            . '/' . $this->library_id
            . '/'
            . $this->id;
    }

    public function saveFiles(array $files): bool
    {
        $embeddedStorage = new EmbeddedStepService();
        $embeddedFile = $this->getPathToSavingEmbeddedFile();
        if (!$embeddedStorage->exists($embeddedFile)) return false;

        $rawStorage = new UploadedStepService();

        $embeddedData = json_decode($embeddedStorage->get($embeddedFile), true);

        foreach ($files as $chunkNumber => $chunkFiles) {
            foreach ($chunkFiles as $index => $chunkFile) {
                $fileName = $chunkFile->getClientOriginalName();
                $path = $this->getPathToAttachments() . '/' . $chunkNumber . '/'. $index . '/' . $fileName;
                $rawStorage->upload($path, $chunkFile->getContent(), StorageDriver::VISIBILITY_PUBLIC);
                if (isset($embeddedData['meta']['chunks'][$chunkNumber]['images'][$index])) {
                    $path = $this->getPathToAttachments() . '/' . $index . '/'. $embeddedData['meta']['chunks'][$chunkNumber]['images'][$index];
                    $rawStorage->delete($path);
                }
                $embeddedData['meta']['chunks'][$chunkNumber]['images'][$index] = $fileName;
            }
        }

        $embeddedStorage->upload($embeddedFile, json_encode($embeddedData));

        return true;
    }

    public function getAttachments(): array
    {
        $storage = new EmbeddedStepService();
        $embeddedFile = $this->getPathToSavingEmbeddedFile();
        if (!$storage->exists($embeddedFile)) return [];

        $embeddedData = json_decode($storage->get($embeddedFile), true);

        $attachments = [];
        $chunks = $embeddedData['meta']['chunks'] ?? [];
        foreach ($chunks as $chunkNumber => $chunk) {
            foreach (($chunk['images'] ?? []) as $imageNumber => $imageName) {
                $path = $this->getPathToAttachments() . '/' . $chunkNumber . '/'. $imageNumber . '/' . $imageName;
                $attachments[$chunkNumber]['images'][$imageNumber] = $storage->url($path);
            }
            $attachments[$chunkNumber]['links'] = $chunk['links'] ?? [];;
        }

        return $attachments;
    }

    public function saveLinks(array $links): bool
    {
        $storage = new EmbeddedStepService();
        $embeddedFile = $this->getPathToSavingEmbeddedFile();
        if (!$storage->exists($embeddedFile)) return false;

        $embeddedData = json_decode($storage->get($embeddedFile), true);

        foreach ($links as $chunkNumber => $chunkLinks) {
            foreach ($chunkLinks as $indexNumber => $chunkLink) {
                $embeddedData['meta']['chunks'][$chunkNumber]['links'][$indexNumber] = $chunkLink;
            }
        }

        $storage->upload($embeddedFile, json_encode($embeddedData));

        return true;
    }
}
