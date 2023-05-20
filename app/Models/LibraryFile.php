<?php

namespace App\Models;

use App\Services\Storage\Adapters\UploadedStepService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryFile extends Model
{
    use HasFactory;

    const DISK_CORE_PATH = 'libraries';
    const DISK_SUB_PATH_RAW = 'raw';
    const DISK_SUB_PATH_DB = 'db';

    protected $fillable = ['library_id', 'original_name', 'file_key', 'filename'];

    private function getPathForSavingRawFile(): string
    {
        return self::DISK_CORE_PATH
            . '/'
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
        $service = new UploadedStepService();
        $filePath = $this->getPathForSavingRawFile();
        $service->delete($filePath);
    }

    private function getPathToLibraryEmbeddedFile() : string
    {
        return self::DISK_CORE_PATH
            . '/'
            .  self::DISK_SUB_PATH_DB
            . '/' . round($this->library_id/10000, 0)
            . '/' . round($this->library_id/1000, 0)
            . '/lib'
            . $this->library_id
            . '.json';
    }
}
