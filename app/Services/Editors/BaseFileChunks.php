<?php

namespace App\Services\Editors;

use App\Services\Storage\Adapters\EmbeddedStepService;
use App\Services\Storage\Adapters\StorageStepService;
use App\Services\Storage\Adapters\UploadedStepService;

class BaseFileChunks
{
    protected StorageStepService $storageService;
    protected EmbeddedStepService $embeddedStorageService;

    public function __construct(UploadedStepService $uploadedStepService, EmbeddedStepService $embeddedStepService)
    {
        $this->storageService = $uploadedStepService;
        $this->embeddedStorageService = $embeddedStepService;
    }
}
