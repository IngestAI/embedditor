<?php

namespace App\Services\Ai\Mappers;

class StripAiMapper implements AiMapper
{
    private string $rawData;

    private string $result;

    public function __construct(string $rawData)
    {
        $this->rawData = $rawData;
    }

    public static function make(string $rawData)
    {
        return new static($rawData);
    }

    public function handle(): AiMapper
    {
        $this->result = strtolower(preg_replace('/[,.]+/', ' ', $this->rawData));
        $this->result = preg_replace('/[ ]{2,}/', ' ', $this->result);

        return $this;
    }

    public function getResult(): string
    {
        return trim($this->result);
    }
}
