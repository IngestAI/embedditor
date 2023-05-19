<?php

namespace App\Services\Storage\Events;


abstract class BaseCopyStorageEvent implements StorageEvent
{
    protected array $consumers = [];

    protected array $results = [];

    abstract protected function setConsumers(string $path, string $existedFile): void;

    public function __construct(string $path, string $existedFile)
    {
        $this->setConsumers($path, $existedFile);
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
