<?php

namespace App\Services\Storage\Adapters;

use App\Services\Storage\Events\Copy\CopyRawStorageEvent;
use App\Services\Storage\Events\Delete\DeleteRawStorageEvent;
use App\Services\Storage\Events\Download\DownloadRawStorageEvent;
use App\Services\Storage\Events\Exists\ExistsRawStorageEvent;
use App\Services\Storage\Events\Get\GetRawStorageEvent;
use App\Services\Storage\Events\Upload\UploadRawStorageEvent;
use App\Services\Storage\Events\UploadStream\UploadStreamRawStorageEvent;
use App\Services\Storage\Events\Path\PathRawStorageEvent;
use App\Services\Storage\Events\Url\UrlRawStorageEvent;

class UploadedStepService implements StorageStepService
{
    public function upload(string $path, string $file, string $visibility = ''): bool
    {
        $event = new UploadRawStorageEvent($path, $file, $visibility);

        return $event->exec()->getResult();
    }

    public function uploadFromStream(string $path, $sourceStream): mixed
    {
        $event = new UploadStreamRawStorageEvent($path, $sourceStream);

        return $event->exec()->getResult();
    }

    public function copy(string $path, string $existedFile): bool
    {
        $event = new CopyRawStorageEvent($path, $existedFile);

        return $event->exec()->getResult();
    }

    public function download(string $path, string $originalName)
    {
        $event = new DownloadRawStorageEvent($path, $originalName);

        return $event->exec()->getResult();
    }

    public function exists(string $path): bool
    {
        $event = new ExistsRawStorageEvent($path);

        return $event->exec()->getResult();
    }

    public function get(string $path): string
    {
        $event = new GetRawStorageEvent($path);

        return $event->exec()->getResult();
    }

    public function delete(string $path): bool
    {
        $event = new DeleteRawStorageEvent($path);

        return $event->exec()->getResult();
    }

    public function url(string $path): string
    {
        $event = new UrlRawStorageEvent($path);

        return $event->exec()->getResult();
    }

    public function path(string $path): string
    {
        $event = new PathRawStorageEvent($path);

        return $event->exec()->getResult();
    }
}
