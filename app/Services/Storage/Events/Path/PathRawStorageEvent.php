<?php

namespace App\Services\Storage\Events\Path;

use App\Services\Storage\Drivers\LocalStorageDriver;
use App\Services\Storage\Events\BasePathStorageEvent;
use App\Services\Storage\Handlers\Path\PathRawLocalStorageHandler;


class PathRawStorageEvent extends BasePathStorageEvent
{
    protected function setConsumers(string $path): void
    {
        $this->consumers = [
            new PathRawLocalStorageHandler(new LocalStorageDriver(), $path),
        ];
    }
}
