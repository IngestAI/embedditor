<?php

namespace App\Services\Ai\Completions;

class NullAiCompletion implements AiCompletion
{
    public function send(array $data): mixed
    {
        return [];
    }

    public function getResult(): string
    {
        return '';
    }

    public function getTotalTokens(): int
    {
        return 0;
    }
}
