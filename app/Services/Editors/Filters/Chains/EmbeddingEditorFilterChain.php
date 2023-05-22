<?php

namespace App\Services\Editors\Filters\Chains;

use App\Models\LibraryFile;
use App\Services\Editors\Filters\StripPunctEditorFilter;
use App\Services\Editors\Filters\StripSpecialEditorFilter;
use App\Services\Editors\Filters\StripTagEditorFilter;

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
