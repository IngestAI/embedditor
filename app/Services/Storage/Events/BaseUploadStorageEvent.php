<?php

namespace App\Services\Storage\Events;


abstract class BaseUploadStorageEvent implements StorageEvent
{
    protected array $consumers = [];

    protected array $results = [];

    abstract protected function setConsumers(string $path, string $file): void;

    public function __construct(string $path, string $file)
    {
        $this->setConsumers($path, $file);
    }

    public function exec(): StorageEvent
    {
        foreach ($this->consumers as $consumer) {
            $consumer->handle();
            $result = $consumer->isSuccessful();
            $this->results[] = $result;
        }

        return $this;
    }

    public function getResult(): bool
    {
        return !in_array(false, $this->results);
    }
}
