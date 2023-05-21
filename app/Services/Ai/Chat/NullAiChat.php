<?php

namespace App\Services\Ai\Chat;

class NullAiChat implements AiChat
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
