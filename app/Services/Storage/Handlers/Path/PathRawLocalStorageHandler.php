<?php

namespace App\Services\Storage\Handlers\Path;


use App\Services\Storage\Handlers\BasePathStorageHandler;

class PathRawLocalStorageHandler extends BasePathStorageHandler
{
    protected function check(): bool
    {
        return true;
    }
}
