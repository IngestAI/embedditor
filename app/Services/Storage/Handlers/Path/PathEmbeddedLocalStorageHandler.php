<?php

namespace App\Services\Storage\Handlers\Path;

use App\Services\Storage\Handlers\BasePathStorageHandler;

class PathEmbeddedLocalStorageHandler extends BasePathStorageHandler
{
    protected function check(): bool
    {
        return true;
    }
}
