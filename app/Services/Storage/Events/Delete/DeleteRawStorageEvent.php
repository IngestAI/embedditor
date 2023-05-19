<?php

namespace App\Services\Storage\Events\Delete;

use App\Services\Storage\Drivers\LocalStorageDriver;
use App\Services\Storage\Events\BaseDeleteStorageEvent;
use App\Services\Storage\Handlers\Delete\DeleteRawLocalStorageHandler;


class DeleteRawStorageEvent extends BaseDeleteStorageEvent
{
    protected function setConsumers(string $path): void
    {
        $this->consumers = [
            new DeleteRawLocalStorageHandler(new LocalStorageDriver(), $path),
        ];
    }
}
