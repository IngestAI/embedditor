<?php

namespace App\Services\Ai\Completions;

interface AiCompletion
{
    public function send(string $prompt, string $model, int $maxTokens, float $temperature): mixed;

    public function getResult(): string;

    public function getTotalTokens(): int;
}
