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

    public function __construct(string $rawData, LibraryFile $libraryFile)
    {
        $this->rawData = $rawData;

        $this->isLowerCase = $libraryFile->lowercase;
        $this->isStopWords = $libraryFile->stop_word;
    }

    public static function make(string $rawData, LibraryFile $libraryFile)
    {
        return new static($rawData, $libraryFile);
    }

    public function handle(): string
    {
        $data = (string) (new StripTagEditorFilter($this->rawData))->filter();
        $data = (string) (new StripSpecialEditorFilter($data))->filter();
        $data = (string) (new StripPunctEditorFilter($data))->filter();
        if ($this->isLowerCase) {
            $data = (string) (new LowerCaseEditorFilter($data))->filter();
        }
        if ($this->isStopWords) {
            $data = (string) (new StopWordEditorFilter($data))->filter();
        }

        return $data;
    }
}
