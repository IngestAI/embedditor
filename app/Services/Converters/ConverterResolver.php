<?php

namespace App\Services\Converters;

use App\Services\Converters\Handlers\ConverterHandler;
use App\Services\Converters\Handlers\CsvConverterHandler;
use App\Services\Converters\Handlers\PdfConverterHandler;
use App\Services\Converters\Handlers\TextConverterHandler;

final class ConverterResolver
{
    private string $rawFile;

    public function __construct(string $rawFile)
    {
        $this->rawFile = $rawFile;
    }

    public static function make(string $rawFile): ConverterResolver
    {
        return new static($rawFile);
    }

    public function resolve(): ConverterHandler
    {
        $extension = explode('.', basename($this->rawFile))[1] ?? '';
        switch ($extension) {
            case 'pdf':
                return new PdfConverterHandler($this->rawFile);
            case 'csv':
                return new CsvConverterHandler($this->rawFile);
        }

        return new TextConverterHandler($this->rawFile);
    }
}
