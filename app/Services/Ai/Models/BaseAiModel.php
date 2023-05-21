<?php

namespace App\Services\Ai\Models;

abstract class BaseAiModel implements AiModel
{
    protected const MIN_DIFFERENCE = 500;

    protected int $length = 0;

    protected string $query;
    public function __construct(string $query)
    {
        $this->query = $query;
    }

    abstract public function getData(): array;

    protected function getDifference(): int
    {
        $length = (int) round(strlen($this->query)/0.75/2);
        return $this->length - $length;
    }
}
