<?php

namespace App\Services\Editors\Filters;

class LowerCaseEditorFilter implements EditorFilter
{
    private string $data;
    private string $filterData = '';

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    public function filter(): EditorFilter
    {
        $this->filterData = mb_strtolower($this->data);

        return $this;
    }

    public function __toString(): string
    {
        return trim($this->filterData);
    }
}
