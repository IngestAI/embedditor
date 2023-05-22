<?php

namespace App\Services\Editors\Filters\Chains;

use App\Models\LibraryFile;
use App\Services\Editors\Filters\StripPunctEditorFilter;
use App\Services\Editors\Filters\StripSpecialEditorFilter;
use App\Services\Editors\Filters\StripTagEditorFilter;

class EmbeddingEditorFilterChain implements EditorFilterChain
{
    private string $rawData;

    private bool $isStripTag = false;

    private bool $isStripPunctuation = false;

    private bool $isStripSpecialChar = false;

    public function __construct(string $rawData, LibraryFile $libraryFile)
    {
        $this->rawData = $rawData;

        $this->isStripTag = $libraryFile->strip_tag;
        $this->isStripPunctuation = $libraryFile->strip_punctuation;
        $this->isStripSpecialChar = $libraryFile->strip_special_char;
    }

    public static function make(string $rawData, LibraryFile $libraryFile)
    {
        return new static($rawData, $libraryFile);
    }

    public function handle(): string
    {
        $data = $this->rawData;
        if ($this->isStripTag) {
            $data = (string) (new StripTagEditorFilter($data))->filter();
        }
        if ($this->isStripPunctuation) {
            $data = (string) (new StripSpecialEditorFilter($data))->filter();
        }
        if ($this->isStripSpecialChar) {
            $data = (string) (new StripPunctEditorFilter($data))->filter();
        }

        return $data;
    }
}
