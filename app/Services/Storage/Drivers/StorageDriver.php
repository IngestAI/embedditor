<?php

namespace App\Services\Storage\Drivers;

use Psr\Http\Message\StreamInterface;

interface StorageDriver
{
    public function upload(string $path, string $file): bool;
    public function uploadFromStream(string $path, $sourceStream): mixed;
    public function copy(string $path, string $existedFile): bool;
    public function download(string $path, string $originalName): mixed;
    public function exists(string $path): bool;
    public function get(string $path): mixed;
    public function delete(string $path): bool;
}
