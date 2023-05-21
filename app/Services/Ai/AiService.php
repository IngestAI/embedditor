<?php

namespace App\Services\Ai;

use App\Services\Ai\Chat\AiChat;
use App\Services\Ai\Chat\NullAiChat;
use App\Services\Ai\Chat\OpenAiChat;
use App\Services\Ai\Completions\AiCompletion;
use App\Services\Ai\Completions\NullAiCompletion;
use App\Services\Ai\Completions\OpenAiCompletion;
use App\Services\Ai\Embeddings\AiEmbedding;
use App\Services\Ai\Embeddings\NullAiEmbedding;
use App\Services\Ai\Embeddings\OpenAiEmbedding;

class AiService
{
    public static function createEmbeddingFactory(): AiEmbedding
    {
        $type = config('services.ai.embedding');

        if ($type === 'openai') {
            return new OpenAiEmbedding();
        }

        return new NullAiEmbedding();
    }

    public static function createCompletionFactory(): AiCompletion
    {
        $type = config('services.ai.completion');

        if  ($type === 'openai') {
            return new OpenAiCompletion();
        }

        return new NullAiCompletion();
    }

    public static function createChatFactory(): AiChat
    {
        $type = config('services.ai.completion');

        if  ($type === 'openai') {
            return new OpenAiChat();
        }

        return new NullAiChat();
    }
}
