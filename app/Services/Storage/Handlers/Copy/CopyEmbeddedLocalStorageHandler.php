<?php

namespace App\Services\Storage\Handlers\Copy;

use App\Services\Storage\Conditions\JsonDiskStorageCondition;
use App\Services\Storage\Drivers\LocalStorageDriver;
use App\Services\Storage\Handlers\BaseCopyStorageHandler;

class CopyEmbeddedLocalStorageHandler extends BaseCopyStorageHandler
{
    protected function check(): bool
    {
        return true;
    }
}
