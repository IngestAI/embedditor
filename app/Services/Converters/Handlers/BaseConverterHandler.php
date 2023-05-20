<?php

namespace App\Services\Converters\Handlers;

abstract class BaseConverterHandler implements ConverterHandler
{
    protected string $rawFile;

    public function __construct(string $rawFile)
    {
        $this->rawFile = $rawFile;
    }

    abstract public function handle(string $convertedFile): ConverterHandler;
}
