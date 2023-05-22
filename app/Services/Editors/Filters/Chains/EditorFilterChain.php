<?php

namespace App\Services\Editors\Filters\Chains;

interface EditorFilterChain
{
    public function handle(): string;
}
