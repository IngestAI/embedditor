<?php

namespace App\Services\Ai\Models;

class NullAiModel implements AiModel
{
    public function getData(): array
    {
        return [];
    }
}
