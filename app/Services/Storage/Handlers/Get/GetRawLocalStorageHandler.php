<?php

namespace App\Services\Storage\Handlers\Get;

use App\Services\Storage\Conditions\RawDiskStorageCondition;
use App\Services\Storage\Drivers\LocalStorageDriver;
use App\Services\Storage\Handlers\BaseGetStorageHandler;

class GetRawLocalStorageHandler extends BaseGetStorageHandler
{
    protected function check(): bool
    {
        return true;
    }
}
