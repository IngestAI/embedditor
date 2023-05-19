<?php

namespace App\Services\Ai\Completions;

class NullAiCompletion implements AiCompletion
{
    public function send(string $prompt, string $model, int $maxTokens, float $temperature): mixed
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
