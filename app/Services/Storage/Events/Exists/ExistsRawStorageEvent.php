<?php

namespace App\Services\Storage\Events\Exists;

use App\Services\Storage\Drivers\LocalStorageDriver;
use App\Services\Storage\Events\BaseExistsStorageEvent;
use App\Services\Storage\Handlers\Exists\ExistsRawLocalStorageHandler;


class ExistsRawStorageEvent extends BaseExistsStorageEvent
{
    protected function setConsumers(string $path): void
    {
        $this->consumers = [
            new ExistsRawLocalStorageHandler(new LocalStorageDriver(), $path),
        ];
    }
}
