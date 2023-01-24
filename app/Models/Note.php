<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'noteable_id',
        'noteable_type',
    ];

    protected $searchableFields = ['*'];

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function noteable()
    {
        return $this->morphTo();
    }
}
