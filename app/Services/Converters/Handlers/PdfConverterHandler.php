<?php

namespace App\Services\Converters\Handlers;

use App\Services\Storage\Adapters\UploadedStepService;
use Smalot\PdfParser\Parser;

class PdfConverterHandler extends BaseConverterHandler
{

    public function handle(string $convertedFile): ConverterHandler
    {
        $storage = new UploadedStepService();
        $parser = new Parser();
        $pdf = $parser->parseFile($storage->path($this->rawFile));

        $storage->copy($convertedFile, $pdf->getText());

        return $this;
    }
}
