<?php

namespace App\Services\Storage\Drivers;

use Illuminate\Support\Facades\Storage;

class LocalStorageDriver implements StorageDriver
{
    const DISK_LOCAL = 'local';

    public function upload(string $path, $file, string $visibility = ''): bool
    {
        $visibility = $visibility ?: [];
        return Storage::disk(self::DISK_LOCAL)->put($path, $file, $visibility);
    }

    public function uploadFromStream(string $path, $sourceStream): mixed
    {
        Storage::disk(self::DISK_LOCAL)->getDriver()->writeStream($path, $sourceStream);
        return $this->exists($path);
    }

    public function copy(string $path, $existedFile): bool
    {
        return Storage::disk(self::DISK_LOCAL)->put($path, $existedFile);
    }

    public function download(string $path, $originalName): mixed
    {
        return Storage::disk(self::DISK_LOCAL)->download($path, $originalName);
    }

    public function exists(string $path) : bool
    {
        return Storage::disk(self::DISK_LOCAL)->exists($path);
    }

    public function get(string $path): mixed
    {
        return Storage::disk(self::DISK_LOCAL)->get($path);
    }

    public function delete(string $path): bool
    {
        return Storage::disk(self::DISK_LOCAL)->delete($path);
    }

    public function url(string $path): string
    {
        return Storage::disk(self::DISK_LOCAL)->url($path);
    }

    public function path(string $path): string
    {
        return Storage::disk(self::DISK_LOCAL)->path($path);
    }
}
