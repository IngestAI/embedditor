<?php

namespace App\Services\Storage\Events;

interface StorageEvent
{
    public function exec(): StorageEvent;
}
