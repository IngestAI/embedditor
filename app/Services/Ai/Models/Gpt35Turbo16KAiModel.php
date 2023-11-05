<?php

namespace App\Services\Ai\Models;

class Gpt35Turbo16KAiModel extends BaseAiModel
{
    public function getData(): array
    {
        $messages[] = ['role' => 'user', 'content' => $this->query];
        $messages[] = ['role' => 'system', 'content' => 'You are a helpful assistant'];
        $messages = array_reverse($messages);
        return [
            'model' => 'gpt-3.5-turbo-16k',
            'messages' => $messages,
        ];
    }
}
