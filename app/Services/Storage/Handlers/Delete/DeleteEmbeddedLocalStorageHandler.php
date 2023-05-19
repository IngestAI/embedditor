<?php

namespace App\Services\Storage\Handlers\Delete;

use App\Services\Storage\Conditions\JsonDiskStorageCondition;
use App\Services\Storage\Drivers\LocalStorageDriver;
use App\Services\Storage\Handlers\BaseDeleteStorageHandler;

class DeleteEmbeddedLocalStorageHandler extends BaseDeleteStorageHandler
{
    protected function check(): bool
    {
        return true;
    }
}
