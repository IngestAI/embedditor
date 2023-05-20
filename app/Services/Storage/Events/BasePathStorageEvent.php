<?php

namespace App\Services\Storage\Events;


abstract class BasePathStorageEvent implements StorageEvent
{
    protected array $consumers = [];

    private string $result = '';

    abstract protected function setConsumers(string $path): void;

    public function __construct(string $path)
    {
        $this->setConsumers($path);
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

    public function getResult(): string
    {
        return $this->result;
    }
}
