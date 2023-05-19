<?php

namespace App\Services\Storage\Handlers\Exists;

use App\Services\Storage\Conditions\JsonDiskStorageCondition;
use App\Services\Storage\Drivers\LocalStorageDriver;
use App\Services\Storage\Handlers\BaseExistsStorageHandler;

class ExistsEmbeddedLocalStorageHandler extends BaseExistsStorageHandler
{
    protected function check(): bool
    {
        return true;
    }
}
