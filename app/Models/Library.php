<?php

namespace App\Models;

use App\Services\Ai\AiService;
use App\Services\Storage\Adapters\EmbeddedStepService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Library extends Model
{
    use HasFactory;

    public $fillable = ['name', 'temperature', 'chunk_size'];

    public function files(): HasMany
    {
        return $this->hasMany(LibraryFile::class, 'library_id');
    }

    public static function default()
    {
        return Library::first();
    }

    public function getRequestQuery(string $query)
    {
        if ($this->files->isEmpty()) return $query;

        $client = AiService::createEmbeddingFactory();
        $requestVector = $client->send($query, $this->embedded_model);
        $libraryData = array('texts' => [], 'vectors' => []);

        $storage = new EmbeddedStepService();
        foreach ($this->files as $libraryFile) {
            $pathJson = $libraryFile->getPathToSavingEmbeddedFile();
            if (!$storage->exists($pathJson)) continue;
            $fileData = json_decode($storage->get($pathJson), true);
            if (empty($fileData['texts']) || empty($fileData['vectors'])) continue;
            foreach ($fileData['texts'] as $key => $text) {
                $libraryData['texts'][] = $text;
                $libraryData['vectors'][] = (!empty($fileData['vectors'][$key]) ? $fileData['vectors'][$key] : []);
            }
        }

        if (empty($libraryData['texts']) || empty($libraryData['vectors'])) {
            return $query;
        }

        $score = [];
        foreach ($libraryData['vectors'] as $key => $libraryVector) {
            $result = array_map(function($x, $y) {
                return $x * $y;
            }, $requestVector, $libraryVector);
            $score[$key] = array_sum($result);
        }

        //arsort($score);

        $choosenVector = array_key_first($score);
        $secondVector = null;
        if ($this->chunk_size <= 1500) {
            $arrKeys = array_keys($score);
            if (!empty($arrKeys[1]) && !empty($libraryData['texts'][$choosenVector]) && strlen($libraryData['texts'][$choosenVector]) <= 2000) {
                $secondVector = $arrKeys[1];
            }
        }

        return 'Answer the question as truthfully as possible using the provided text'
            . "\n\n" . 'Context:' . "\n"
            . $libraryData['texts'][$choosenVector] .
            (!empty($libraryData['texts'][$secondVector]) ? "\n\n" . $libraryData['texts'][$secondVector] : '')
            . "\n\n" . 'Q: ' . $query . "\n" . 'A:';
    }
}
