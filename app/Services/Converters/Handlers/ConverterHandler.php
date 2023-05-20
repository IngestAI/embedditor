<?php

namespace App\Services\Converters\Handlers;

interface ConverterHandler
{
    public function handle(string $convertedFile): ConverterHandler;
}
