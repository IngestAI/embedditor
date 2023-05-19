<?php

namespace App\Services\Ai\Embeddings;

interface AiEmbedding
{
    public function send(string $request, string $model): array;
}
