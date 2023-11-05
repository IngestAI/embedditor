<?php

namespace App\Services\Storage\Handlers;


use App\Services\Storage\Drivers\StorageDriver;

abstract class BaseUploadStorageHandler implements StorageHandler
{
    protected bool $isUploaded = true;

    abstract protected function check(): bool;

    public function __construct(
        protected StorageDriver $driver,
        protected string $path,
        protected string $file,
        protected string $visibility = '')
    {
    }

    public function handle(): void
    {
        if ($this->check()) {
            $this->isUploaded = $this->driver->upload($this->path, $this->file, $this->visibility);
        }
    }

    public function isSuccessful(): bool
    {
        return $this->isUploaded;
    }
}
