<?php

namespace App\Services\Storage\Events\Upload;

use App\Services\Storage\Drivers\LocalStorageDriver;
use App\Services\Storage\Events\BaseUploadStorageEvent;
use App\Services\Storage\Handlers\Upload\UploadEmbeddedLocalStorageHandler;


class UploadEmbeddedStorageEvent extends BaseUploadStorageEvent
{
    protected function setConsumers(string $path, string $file, string $visibility = ''): void
    {
        $this->consumers = [
            new UploadEmbeddedLocalStorageHandler(new LocalStorageDriver(), $path, $file, $visibility),
        ];
    }
}
