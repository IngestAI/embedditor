<?php

namespace App\Services\Ai\Embeddings;

use Exception;
use OpenAI;

class OpenAiEmbedding implements AiEmbedding
{
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
    }

    public function send(string $request, string $model): array
    {
        $client = OpenAI::client($this->apiKey);

        $response = $client->embeddings()->create([
            'model' => $model,
            'input' => $request,
        ]);

        return $response->embeddings[0]->embedding ?? [];
    }
}
