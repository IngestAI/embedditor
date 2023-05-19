<?php

namespace App\Services\Storage\Events;


abstract class BaseDownloadStorageEvent implements StorageEvent
{
    protected array $consumers = [];

    private mixed $result;

    abstract protected function setConsumers(string $path, string $originalName): void;

    public function __construct(string $path, string $originalName)
    {
        $this->setConsumers($path, $originalName);

        $this->result = response()->json([]);
    }

    public function exec(): StorageEvent
    {
        foreach ($this->consumers as $consumer) {
            $consumer->handle();
            $result = $consumer->getResult();
            if ($result) {
                $this->result = $result;
            }
        }

        return $this;
    }

    public function getResult(): mixed
    {
        return $this->result;
    }
}
