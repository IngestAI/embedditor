<?php

namespace App\Services\Ai\Models;

class Gpt4AiModel extends BaseAiModel
{
    public function getData(): array
    {
        $messages[] = ['role' => 'user', 'content' => $this->query];
        $messages[] = ['role' => 'system', 'content' => 'You are a helpful assistant'];
        $messages = array_reverse($messages);
        return [
            'model' => 'gpt-4',
            'messages' => $messages
        ];
    }
}
