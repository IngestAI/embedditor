<?php

namespace App\Services\Storage\Handlers;


use App\Services\Storage\Drivers\StorageDriver;

abstract class BaseDeleteStorageHandler implements StorageHandler
{
    protected StorageDriver $driver;

    protected string $path;

    protected bool $isDeleted = true;

    abstract protected function check(): bool;

    public function __construct(StorageDriver $driver, string $path)
    {
        $this->driver = $driver;
        $this->path = $path;
    }

    public function handle(): void
    {
        if ($this->check()) {
            $this->isDeleted = $this->driver->delete($this->path);
        }
    }

    public function isSuccessful(): bool
    {
        return $this->isDeleted;
    }
}
