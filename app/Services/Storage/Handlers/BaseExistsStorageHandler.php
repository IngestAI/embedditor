<?php

namespace App\Services\Storage\Handlers;


use App\Services\Storage\Drivers\StorageDriver;

abstract class BaseExistsStorageHandler implements StorageHandler
{
    protected StorageDriver $driver;

    protected string $path;

    protected bool $isExists = true;

    abstract protected function check(): bool;

    public function __construct(StorageDriver $driver, string $path)
    {
        $this->driver = $driver;
        $this->path = $path;
    }

    public function handle(): void
    {
        if ($this->check()) {
            $this->isExists = $this->driver->exists($this->path);
        }
    }

    public function isSuccessful(): bool
    {
        return $this->isExists;
    }
}
