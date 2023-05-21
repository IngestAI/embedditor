<?php

namespace App\Services\Ai\Models;

use App\Services\Converters\Handlers\ConverterHandler;
use App\Services\Converters\Handlers\CsvConverterHandler;
use App\Services\Converters\Handlers\PdfConverterHandler;
use App\Services\Converters\Handlers\TextConverterHandler;

final class AiModelResolver
{
    private string $slug;

    public function __construct(string $slug)
    {
        $this->slug = $slug;
    }

    public static function make(string $slug): AiModelResolver
    {
        return new static($slug);
    }

    public function resolve(string $query): ConverterHandler
    {
        switch ($this->slug) {
            case 'gpt-3.5-turbo':
                return new Gpt35TurboAiModel($this->query);
            case 'gpt-4':
                return new Gpt4AiModel($this->query);
            case 'text-davinci-003':
                return new TextDavinci003AiModel($this->query);
            case 'text-davinci-002':
                return new TextDavinci002AiModel($this->query);
            case 'text-curie-001':
                return new TextCuris001AiModel($this->query);
            case 'text-babbage-001':
                return new TextBabbage001AiModel($this->query);
            case 'text-ada-001':
                return new TextAda001AiModel($this->query);
        }

        return new NullAiModel($this->rawFile);
    }
}
