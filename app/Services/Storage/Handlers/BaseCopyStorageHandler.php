<?php

namespace App\Services\Storage\Handlers;


use App\Services\Storage\Drivers\StorageDriver;

abstract class BaseCopyStorageHandler implements StorageHandler
{
    protected StorageDriver $driver;

    protected string $path, $existedFile;

    protected bool $isCopied = true;

    abstract protected function check(): bool;

    public function __construct(StorageDriver $driver, string $path, string $existedFile)
    {
        $this->driver = $driver;
        $this->path = $path;
        $this->existedFile = $existedFile;
    }

    public function handle(): void
    {
        if ($this->check()) {
            $this->isCopied = $this->driver->copy($this->path, $this->existedFile);
        }
    }

    public function isSuccessful(): bool
    {
        return $this->isCopied;
    }
}
