<?php

namespace App\Services\Converters\Handlers;

use App\Services\Converters\Handlers\Libraries\PDF2Text;
use App\Services\Storage\Adapters\UploadedStepService;

class PdfConverterHandler extends BaseConverterHandler
{

    public function handle(string $convertedFile): ConverterHandler
    {
        $storage = new UploadedStepService();

        $converter = new PDF2Text();
        $converter->setFilename($storage->path($this->rawFile));
        $converter->decodePDF();
        $storage->copy($convertedFile, $converter->output());

        return $this;
    }
}
