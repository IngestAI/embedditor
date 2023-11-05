<?php

namespace App\Services\Storage\Events\Url;

use App\Services\Storage\Drivers\LocalStorageDriver;
use App\Services\Storage\Events\BasePathStorageEvent;
use App\Services\Storage\Handlers\Url\UrlRawLocalStorageHandler;


class UrlRawStorageEvent extends BasePathStorageEvent
{
    protected function setConsumers(string $path): void
    {
        $this->consumers = [
            new UrlRawLocalStorageHandler(new LocalStorageDriver(), $path),
        ];
    }
}
