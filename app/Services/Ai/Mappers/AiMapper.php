<?php

namespace App\Services\Ai\Mappers;

interface AiMapper
{
    public function handle(): AiMapper;

    public function getResult(): string;
}
