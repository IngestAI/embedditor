<?php

namespace App\Services\Storage\Events\Download;

use App\Services\Storage\Drivers\LocalStorageDriver;
use App\Services\Storage\Events\BaseDownloadStorageEvent;
use App\Services\Storage\Handlers\Download\DownloadEmbeddedLocalStorageHandler;

class DownloadEmbeddedStorageEvent extends BaseDownloadStorageEvent
{
    protected function setConsumers(string $path, string $originalName): void
    {
        $this->consumers = [
            new DownloadEmbeddedLocalStorageHandler(new LocalStorageDriver(), $path, $originalName),
        ];
    }
}
