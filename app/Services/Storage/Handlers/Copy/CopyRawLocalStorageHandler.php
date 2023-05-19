<?php

namespace App\Services\Storage\Handlers\Copy;

use App\Services\Storage\Conditions\RawDiskStorageCondition;
use App\Services\Storage\Drivers\LocalStorageDriver;
use App\Services\Storage\Handlers\BaseCopyStorageHandler;

class CopyRawLocalStorageHandler extends BaseCopyStorageHandler
{
    protected function check(): bool
    {
        return true;
    }
}
