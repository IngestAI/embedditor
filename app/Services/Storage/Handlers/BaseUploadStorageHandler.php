<?php

namespace App\Services\Storage\Handlers;


use App\Services\Storage\Drivers\StorageDriver;

abstract class BaseUploadStorageHandler implements StorageHandler
{
    protected StorageDriver $driver;

    protected string $path, $file;

    protected bool $isUploaded = true;

    abstract protected function check(): bool;

    public function __construct(StorageDriver $driver, string $path, string $file)
    {
        $this->driver = $driver;
        $this->path = $path;
        $this->file = $file;
    }

    public function handle(): void
    {
        if ($this->check()) {
            $this->isUploaded = $this->driver->upload($this->path, $this->file);
        }
    }

    public function isSuccessful(): bool
    {
        return $this->isUploaded;
    }
}
