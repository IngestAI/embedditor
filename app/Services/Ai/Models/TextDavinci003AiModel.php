<?php

namespace App\Services\Ai\Models;

class TextDavinci003AiModel extends BaseAiModel
{

    public function __construct(string $query)
    {
        parent::__construct($query);

        $this->length = 4000;
    }
    /**
     * @throws \Exception
     */
    public function getData(): array
    {
        $difference = $this->getDifference();
        if ($difference < self::MIN_DIFFERENCE) {
            throw new \Exception('Error: Your request is too long');
        }

        return [
            'prompt' => $this->query,
            'model' => 'text-davinci-003',
            'max_tokens' => $difference,
            'temperature' => (float) 0.7,
        ];
    }
}
