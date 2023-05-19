<?php

namespace App\Services\Storage\Handlers\UploadStream;

use App\Services\Storage\Conditions\RawDiskStorageCondition;
use App\Services\Storage\Drivers\LocalStorageDriver;
use App\Services\Storage\Handlers\BaseUploadStreamStorageHandler;

class UploadStreamRawLocalStorageHandler extends BaseUploadStreamStorageHandler
{
    protected function check(): bool
    {
        return true;
    }
}
