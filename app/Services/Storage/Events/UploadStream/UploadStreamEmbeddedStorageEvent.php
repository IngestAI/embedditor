<?php

namespace App\Services\Storage\Events\UploadStream;

use App\Services\Storage\Drivers\LocalStorageDriver;
use App\Services\Storage\Events\BaseUploadStreamStorageEvent;
use App\Services\Storage\Handlers\UploadStream\UploadStreamEmbeddedLocalStorageHandler;


class UploadStreamEmbeddedStorageEvent extends BaseUploadStreamStorageEvent
{
    protected function setConsumers(string $path, $sourceStream): void
    {
        $this->consumers = [
            new UploadStreamEmbeddedLocalStorageHandler(new LocalStorageDriver(), $path, $sourceStream),
        ];
    }
}
