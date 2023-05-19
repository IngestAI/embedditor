<?php

namespace App\Services\Storage\Events\Upload;

use App\Services\Storage\Drivers\LocalStorageDriver;
use App\Services\Storage\Events\BaseUploadStorageEvent;
use App\Services\Storage\Handlers\Upload\UploadRawLocalStorageHandler;


class UploadRawStorageEvent extends BaseUploadStorageEvent
{
    protected function setConsumers(string $path, string $file): void
    {
        $this->consumers = [
            new UploadRawLocalStorageHandler(new LocalStorageDriver(), $path, $file),
        ];
    }
}
