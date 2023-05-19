<?php

namespace App\Services\Ai\Embeddings;

class NullAiEmbedding implements AiEmbedding
{
    public function send(string $request, string $model): array
    {
        return [];
    }
}
