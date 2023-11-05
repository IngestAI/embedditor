<?php

namespace App\Services\Storage\Drivers;

interface StorageDriver
{
    public const VISIBILITY_PUBLIC = 'public';

    public function upload(string $path, string $file, string $visibility = ''): bool;
    public function uploadFromStream(string $path, $sourceStream): mixed;
    public function copy(string $path, string $existedFile): bool;
    public function download(string $path, string $originalName): mixed;
    public function exists(string $path): bool;
    public function get(string $path): mixed;

    public function url(string $path): string;

    public function path(string $path): string;
    public function delete(string $path): bool;
}
