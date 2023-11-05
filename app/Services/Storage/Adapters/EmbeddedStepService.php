<?php

namespace App\Services\Storage\Adapters;


use App\Services\Storage\Events\Copy\CopyEmbeddedStorageEvent;
use App\Services\Storage\Events\Delete\DeleteEmbeddedStorageEvent;
use App\Services\Storage\Events\Download\DownloadEmbeddedStorageEvent;
use App\Services\Storage\Events\Exists\ExistsEmbeddedStorageEvent;
use App\Services\Storage\Events\Get\GetEmbeddedStorageEvent;
use App\Services\Storage\Events\Path\PathEmbeddedStorageEvent;
use App\Services\Storage\Events\Upload\UploadEmbeddedStorageEvent;
use App\Services\Storage\Events\UploadStream\UploadStreamEmbeddedStorageEvent;
use App\Services\Storage\Events\Url\UrlEmbeddedStorageEvent;

class EmbeddedStepService implements StorageStepService
{
    public function upload(string $path, string $file, string $visibility = ''): bool
    {
        $event = new UploadEmbeddedStorageEvent($path, $file, $visibility);

        return $event->exec()->getResult();
    }

    public function uploadFromStream(string $path, $sourceStream): mixed
    {
        $event = new UploadStreamEmbeddedStorageEvent($path, $sourceStream);

        return $event->exec()->getResult();
    }

    public function copy(string $path, string $existedFile): bool
    {
        $event = new CopyEmbeddedStorageEvent($path, $existedFile);

        return $event->exec()->getResult();
    }

    public function download(string $path, string $originalName)
    {
        $event = new DownloadEmbeddedStorageEvent($path, $originalName);

        return $event->exec()->getResult();
    }

    public function exists(string $path): bool
    {
        $event = new ExistsEmbeddedStorageEvent($path);

        return $event->exec()->getResult();
    }

    public function get(string $path): string
    {
        $event = new GetEmbeddedStorageEvent($path);

        return $event->exec()->getResult();
    }

    public function delete(string $path): bool
    {
        $event = new DeleteEmbeddedStorageEvent($path);

        return $event->exec()->getResult();
    }

    public function url(string $path): string
    {
        $event = new UrlEmbeddedStorageEvent($path);
        return $event->exec()->getResult();
    }

    public function path(string $path): string
    {
        $event = new PathEmbeddedStorageEvent($path);

        return $event->exec()->getResult();
    }
}
