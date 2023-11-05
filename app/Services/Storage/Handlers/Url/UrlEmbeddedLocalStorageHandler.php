<?php

namespace App\Services\Storage\Handlers\Url;


use App\Services\Storage\Handlers\BaseUrlStorageHandler;

class UrlEmbeddedLocalStorageHandler extends BaseUrlStorageHandler
{
    protected function check(): bool
    {
        return true;
    }
}
