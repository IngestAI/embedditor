<?php

namespace App\Services\Converters\Handlers;

use App\Services\Storage\Adapters\UploadedStepService;

class CsvConverterHandler extends BaseConverterHandler
{
    public function handle(string $convertedFile): ConverterHandler
    {
        $storage = new UploadedStepService();

        $storage->copy($convertedFile, $storage->get($this->rawFile));

        return $this;
    }
}
