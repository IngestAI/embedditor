<?php

namespace App\Services\Storage\Handlers\Get;

use App\Models\User;
use App\Services\Storage\Conditions\JsonDiskStorageCondition;
use App\Services\Storage\Drivers\LocalStorageDriver;
use App\Services\Storage\Drivers\RedisStorageDriver;
use App\Services\Storage\Handlers\BaseGetStorageHandler;
use App\Services\Storage\Resolvers\EnvironmentStorageResolver;

class GetEmbeddedLocalStorageHandler extends BaseGetStorageHandler
{
    protected function check(): bool
    {
        return true;
    }
}
