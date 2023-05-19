<?php

namespace App\Services\Storage\Handlers\Delete;

use App\Services\Storage\Conditions\RawDiskStorageCondition;
use App\Services\Storage\Drivers\LocalStorageDriver;
use App\Services\Storage\Handlers\BaseDeleteStorageHandler;

class DeleteRawLocalStorageHandler extends BaseDeleteStorageHandler
{
    protected function check(): bool
    {
        return true;
    }
}
