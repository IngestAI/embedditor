<?php

namespace App\Services\Storage\Handlers\Url;


use App\Services\Storage\Handlers\BaseUrlStorageHandler;

class UrlRawLocalStorageHandler extends BaseUrlStorageHandler
{
    protected function check(): bool
    {
        return true;
    }
}
