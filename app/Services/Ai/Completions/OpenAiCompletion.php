<?php

namespace App\Services\Ai\Completions;

use OpenAI;

class OpenAiCompletion implements AiCompletion
{

    private string $apiKey;

    private string $result = '';

    private int $tokens = 0;

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
    }

    public function send(string $prompt, string $model, int $maxTokens, float $temperature): mixed
    {
        $client = OpenAI::client($this->apiKey);

        $response = $client->completions()->create([
            'prompt' => $prompt,
            'model' => $model,
            'max_tokens' => $maxTokens,
            'temperature' => $temperature,
        ]);

        $this->result = $response->choices[0]->text ?? '';
        $this->tokens = $response->usage->totalTokens ?? 0;

        return $response;
    }

    public function getResult(): string
    {
        return trim($this->result);
    }

    public function getTotalTokens(): int
    {
        return $this->tokens;
    }
}
