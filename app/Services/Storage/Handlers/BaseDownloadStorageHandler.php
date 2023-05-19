<?php

namespace App\Services\Storage\Handlers;


use App\Services\Storage\Drivers\StorageDriver;

abstract class BaseDownloadStorageHandler implements StorageHandler
{
    protected StorageDriver $driver;

    protected string $path, $originalName;

    protected mixed $result = '';

    abstract protected function check(): bool;

    public function __construct(StorageDriver $driver, string $path, string $originalName)
    {
        $this->driver = $driver;
        $this->path = $path;
        $this->originalName = $originalName;
    }

    public function handle(): void
    {
        if ($this->check()) {
            $this->result = $this->driver->download($this->path, $this->originalName);
        }
    }

    public function getResult(): mixed
    {
        return $this->result;
    }
}
