<?php

namespace App\Services\Editors\Filters\Chains;

class EmbeddingEditorFilterChain implements EditorFilterChain
{
    private string $rawData;

    public function __construct(string $rawData)
    {
        $this->rawData = $rawData;
    }

    public static function make(string $rawData)
    {
        return new static($rawData);
    }

    public function handle(): string
    {
        return $this->rawData;
    }
}
