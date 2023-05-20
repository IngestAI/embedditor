<?php

namespace App\Services\Storage\Handlers;


use App\Services\Storage\Drivers\StorageDriver;

abstract class BasePathStorageHandler implements StorageHandler
{
    protected StorageDriver $driver;

    protected string $path;

    protected mixed $result = '';

    abstract protected function check(): bool;

    public function __construct(StorageDriver $driver, string $path)
    {
        $this->driver = $driver;
        $this->path = $path;
    }

    public function handle(): void
    {
        if ($this->check()) {
            $this->result = $this->driver->path($this->path);
        }
    }

    public function getResult(): string
    {
        return (string) $this->result;
    }
}
