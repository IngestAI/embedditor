<?php

namespace App\Services\Editors\Filters\Chains;

use App\Models\LibraryFile;
use App\Services\Editors\Filters\LowerCaseEditorFilter;
use App\Services\Editors\Filters\StopWordEditorFilter;
use App\Services\Editors\Filters\StripPunctEditorFilter;
use App\Services\Editors\Filters\StripSpecialEditorFilter;
use App\Services\Editors\Filters\StripTagEditorFilter;

class ChunkEditorFilterChain implements EditorFilterChain
{
    private string $rawData;

    private bool $isLowerCase = false;

    private bool $isStopWords = false;

    private bool $isStripTag = false;

    private bool $isStripPunctuation = false;

    private bool $isStripSpecialChar = false;

    public function __construct(string $rawData, LibraryFile $libraryFile)
    {
        $this->rawData = $rawData;

        $this->isLowerCase = $libraryFile->lowercase;
        $this->isStopWords = $libraryFile->stop_word;
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
        if ($this->isLowerCase) {
            $data = (string) (new StripTagEditorFilter($data))->filter();
        }
        if ($this->isLowerCase) {
            $data = (string) (new StripSpecialEditorFilter($data))->filter();
        }
        if ($this->isLowerCase) {
            $data = (string) (new StripPunctEditorFilter($data))->filter();
        }
        if ($this->isLowerCase) {
            $data = (string) (new LowerCaseEditorFilter($data))->filter();
        }
        if ($this->isStopWords) {
            $data = (string) (new StopWordEditorFilter($data))->filter();
        }

        return $data;
    }
}
