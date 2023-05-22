<?php

namespace App\Services\Editors\Filters;

class StripTagEditorFilter implements EditorFilter
{
    private string $data;
    private string $filterData = '';

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    public function filter(): EditorFilter
    {
        $this->filterData = strip_tags($this->data);

        return $this;
    }

    public function __toString(): string
    {
        return trim($this->filterData);
    }
}
