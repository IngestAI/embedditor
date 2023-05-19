<?php

namespace App\Services\Storage\Handlers\Upload;

use App\Services\Storage\Conditions\RawDiskStorageCondition;
use App\Services\Storage\Drivers\LocalStorageDriver;
use App\Services\Storage\Handlers\BaseUploadStorageHandler;

class UploadRawLocalStorageHandler extends BaseUploadStorageHandler
{
    protected function check(): bool
    {
        return true;
    }
}
