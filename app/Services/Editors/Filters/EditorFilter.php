<?php

namespace App\Services\Editors\Filters;

interface EditorFilter
{
    public function filter(): EditorFilter;

    public function __toString(): string;
}
