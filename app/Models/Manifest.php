<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Manifest extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'description',
        'status',
        'is_public',
        'has_files',
        'fields',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'status' => 'boolean',
        'is_public' => 'boolean',
        'has_files' => 'boolean',
        'fields' => 'array',
    ];

    public function deviRequests()
    {
        return $this->hasMany(DeviRequest::class);
    }
}
