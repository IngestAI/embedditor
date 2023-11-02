<?php

namespace App\Services\Editors\Filters\Chains;

use App\Services\Editors\Filters\StripTagEditorFilter;

class PlaygroundSendFilterChain implements EditorFilterChain
{
    public function __construct(private string $rawData)
    {
    }

    public static function make(string $rawData)
    {
        return new static($rawData);
    }

    public function handle(): string
    {
        // removed hidden (red) text
        $text = preg_replace('/<span style="background-color: rgb\(230, 0, 0\);">([^<]+)<\/span>/', '', $this->rawData);

        // removed active (green) text
        $text = preg_replace('/<span style="background-color: rgb\(0, 138, 0\);">([^<]+)<\/span>/', '', $text);

        return (string) (new StripTagEditorFilter($text))->filter();
    }
}
