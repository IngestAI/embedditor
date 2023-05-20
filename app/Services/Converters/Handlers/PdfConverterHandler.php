<?php

namespace App\Services\Converters\Handlers;

class PdfConverterHandler implements ConverterHandler
{

    public function handle(): ConverterHandler
    {
        include_once('Libraries/PDF2Text.php');
    }
}
