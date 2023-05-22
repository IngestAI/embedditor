<?php

namespace App\Services\Editors\Filters;

class StripPunctEditorFilter implements EditorFilter
{
    private string $data;
    private string $filterData = '';

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    public function filter(): EditorFilter
    {
        $this->filterData = preg_replace('/[[:punct:]]/', ' ', $this->data);
        $this->filterData = preg_replace('/[ ]{2,}/', ' ', $this->filterData);

        return $this;
    }

    public function __toString(): string
    {
        return trim($this->filterData);
    }
}
