<?php

namespace App\Models;

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
}
