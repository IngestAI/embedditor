<?php

namespace App\Services\Ai\Chat;

interface AiChat
{
    public function send(array $data): mixed;

    public function getResult(): string;

    public function getTotalTokens(): int;
}
