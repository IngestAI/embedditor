<?php

namespace App\Models;

use App\Services\Ai\AiService;
use App\Services\Converters\ConverterResolver;
use App\Services\Storage\Adapters\EmbeddedStepService;
use App\Services\Storage\Adapters\UploadedStepService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibraryFile extends Model
{
    use HasFactory;

    const DISK_CORE_PATH = 'libraries';
    const DISK_SUB_PATH_RAW = 'raw';
    const DISK_SUB_PATH_DB = 'db';

    protected $fillable = ['library_id', 'original_name', 'file_key', 'filename'];

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class, 'library_id');
    }

    private function getPathForSavingRawFile(): string
    {
        return self::DISK_CORE_PATH
            . '/' . self::DISK_SUB_PATH_RAW
            . '/' . round($this->library_id/10000, 0)
            . '/' . round($this->library_id/1000, 0)
            . '/' . $this->filename;
    }

    public function saveRawFile(string $content)
    {
        $storage = new UploadedStepService();
        $filePath = $this->getPathForSavingRawFile();
        $storage->upload($filePath, $content);
        if ($storage->exists($filePath)) {
            $this->uploaded = true;
            $this->save();
        }
    }

    public function downloadRawFile(): mixed
    {
        $uploadedService = new UploadedStepService();
        return $uploadedService->download($this->getPathForSavingRawFile(), $this->original_name);
    }

    public function deleteRawFile()
    {
        $storage = new UploadedStepService();
        $filePath = $this->getPathForSavingRawFile();
        $storage->delete($filePath);
    }

    public function saveConvertedFile()
    {
        $rawFilePath = $this->getPathForSavingRawFile();
        $convertedFilePath = $this->getPathToSavingConvertedFile();
        ConverterResolver::make($rawFilePath)->resolve()->handle($convertedFilePath);
    }

    public function deleteConvertedFile()
    {
        $storage = new UploadedStepService();
        $filePath = $this->getPathToSavingConvertedFile();
        $storage->delete($filePath);
    }

    public function saveEmbeddedFile()
    {
        $rawStorage = new UploadedStepService();
        $embeddedStorage = new EmbeddedStepService();
        $embeddedFilePath = $this->getPathToSavingEmbeddedFile();
        $convertedFilePath = $this->getPathToSavingConvertedFile();

        $chunks = [];

        $parts = explode("\n", $rawStorage->get($convertedFilePath));
        $k = 0;
        foreach ($parts as $part) {
            if (!empty($part)) {
                if (!empty($chunks[$k])) {
                    $chunks[$k] .= "\n";
                }
                if (empty($chunks[$k])) {
                    $chunks[$k] = $part;
                } else {
                    $chunks[$k] .= $part;
                }
                if (strlen($chunks[$k]) > $this->library->chunk_size) {
                    $k++;
                }
            }
        }
        if (!empty($chunks)) {
            if (!$embeddedStorage->exists($embeddedFilePath)) {
                $embeddedStorage->upload($embeddedFilePath, '');
            }
            $client = AiService::createEmbeddingFactory();
            $texts = $vectors = [];
            foreach ($chunks as $key => $chunk) {
                $chunk = trim($chunk);
                $texts[$key] = $chunk;
                try {
                    $response = $client->send($chunk, $this->library->embedded_model);
                    if (!empty($response)) {
                        $vectors[$key] = $response;
                    }
                } catch (\Exception $e) {
                    $vectors[$key] = [];
                }
            }
            if (!empty($texts) && !empty($vectors)) {
                $embeddedStorage->upload($embeddedFilePath, json_encode(['texts' => $texts, 'vectors' => $vectors]));
            }
        }
    }

    public function deleteEmbeddedFile()
    {
        $storage = new EmbeddedStepService();
        $filePath = $this->getPathToSavingEmbeddedFile();
        $storage->delete($filePath);
    }

    private function getPathToSavingConvertedFile() : string
    {
        return self::DISK_CORE_PATH
            . '/'
            .  self::DISK_SUB_PATH_DB
            . '/' . round($this->library_id/10000, 0)
            . '/' . round($this->library_id/1000, 0)
            . '/'
            . $this->id
            . '.txt';
    }

    private function getPathToSavingEmbeddedFile() : string
    {
        return self::DISK_CORE_PATH
            . '/'
            .  self::DISK_SUB_PATH_DB
            . '/' . round($this->library_id/10000, 0)
            . '/' . round($this->library_id/1000, 0)
            . '/'
            . $this->id
            . '.embd';
    }
}
