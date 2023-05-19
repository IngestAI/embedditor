<?php

namespace App\Services\Storage\Handlers\UploadStream;

use App\Services\Storage\Conditions\JsonDiskStorageCondition;
use App\Services\Storage\Drivers\LocalStorageDriver;
use App\Services\Storage\Handlers\BaseUploadStreamStorageHandler;

class UploadStreamEmbeddedLocalStorageHandler extends BaseUploadStreamStorageHandler
{
    protected function check(): bool
    {
        return true;
    }
}
