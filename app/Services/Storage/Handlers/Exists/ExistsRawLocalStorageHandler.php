<?php

namespace App\Services\Storage\Handlers\Exists;

use App\Services\Storage\Conditions\RawDiskStorageCondition;
use App\Services\Storage\Drivers\LocalStorageDriver;
use App\Services\Storage\Handlers\BaseExistsStorageHandler;

class ExistsRawLocalStorageHandler extends BaseExistsStorageHandler
{
    protected function check(): bool
    {
        return true;
    }
}
