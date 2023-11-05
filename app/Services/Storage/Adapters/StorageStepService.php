<?php

namespace App\Services\Storage\Adapters;

use Psr\Http\Message\StreamInterface;

interface StorageStepService
{
    public function upload(string $path, string $file, string $visibility = ''): bool;
    public function uploadFromStream(string $path, $sourceStream): mixed;
    public function copy(string $path, string $existedFile): bool;
    public function download(string $path, string $originalName);
    public function exists(string $path): bool;
    public function get(string $path): mixed;
    public function delete(string $path): bool;

    public function url(string $path): string;

    public function path(string $path): string;
}
