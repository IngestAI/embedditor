<?php

namespace App\Services\Storage\Events\Url;

use App\Services\Storage\Drivers\LocalStorageDriver;
use App\Services\Storage\Events\BaseGetStorageEvent;
use App\Services\Storage\Handlers\Url\UrlEmbeddedLocalStorageHandler;


class UrlEmbeddedStorageEvent extends BaseGetStorageEvent
{
    protected function setConsumers(string $path): void
    {
        $this->consumers = [
            new UrlEmbeddedLocalStorageHandler(new LocalStorageDriver(), $path),
        ];
    }
}
