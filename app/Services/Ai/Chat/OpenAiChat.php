<?php

namespace App\Services\Ai\Chat;

use OpenAI;

class OpenAiChat implements AiChat
{

    private string $apiKey;

    private string $result = '';

    private int $tokens = 0;

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
    }

    public function send(array $data): mixed
    {
        $client = OpenAI::client($this->apiKey);

        $response = $client->chat()->create($data);

        $result = trim($response->choices[0]->text ?? '');

        if (strpos($result, "\n\n") !== false) {
            $result = '<p>' . str_replace("\n\n", '</p><p>', $result) . '</p>';
        }
        if (strpos($result, "\n") !== false) {
            $result = str_replace("\n", '<br>', $result);
        }
        $this->result = $result;

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
