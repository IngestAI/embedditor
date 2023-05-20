<?php

namespace App\Services\Storage\Events\Path;

use App\Services\Storage\Drivers\LocalStorageDriver;
use App\Services\Storage\Events\BaseGetStorageEvent;
use App\Services\Storage\Handlers\Path\PathEmbeddedLocalStorageHandler;


class PathEmbeddedStorageEvent extends BaseGetStorageEvent
{
    protected function setConsumers(string $path): void
    {
        $this->consumers = [
            new PathEmbeddedLocalStorageHandler(new LocalStorageDriver(), $path),
        ];
    }
}
