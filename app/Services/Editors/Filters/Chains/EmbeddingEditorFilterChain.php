<?php

namespace App\Services\Editors\Filters\Chains;

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
        $data = (string) (new StripTagEditorFilter($this->rawData))->filter();
        $data = (string) (new StripSpecialEditorFilter($data))->filter();

        return (string) (new StripPunctEditorFilter($data))->filter();
    }
}
