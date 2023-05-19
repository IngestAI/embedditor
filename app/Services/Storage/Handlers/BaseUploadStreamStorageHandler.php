<?php

namespace App\Services\Storage\Handlers;


use App\Services\Storage\Drivers\StorageDriver;

abstract class BaseUploadStreamStorageHandler implements StorageHandler
{
    protected StorageDriver $driver;

    protected string $path;

    protected mixed $sourceStream;

    abstract protected function check(): bool;

    public function __construct(StorageDriver $driver, string $path, $sourceStream)
    {
        $this->driver = $driver;
        $this->path = $path;
        $this->sourceStream = $sourceStream;
    }

    public function handle(): void
    {
        if ($this->check()) {
            $this->driver->uploadFromStream($this->path, $this->sourceStream);
        }
    }

    public function isSuccessful(): bool
    {
        return true;
    }
}
