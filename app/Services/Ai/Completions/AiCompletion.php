<?php

namespace App\Services\Ai\Completions;

interface AiCompletion
{
    public function send(array $data): mixed;

    public function getResult(): string;

    public function getTotalTokens(): int;
}
