<?php

namespace App\Services\Storage\Handlers\Download;

use App\Services\Storage\Conditions\JsonDiskStorageCondition;
use App\Services\Storage\Drivers\LocalStorageDriver;
use App\Services\Storage\Handlers\BaseDownloadStorageHandler;

class DownloadEmbeddedLocalStorageHandler extends BaseDownloadStorageHandler
{
    protected function check(): bool
    {
        return true;
    }
}
