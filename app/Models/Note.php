<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Tags\HasTags;

class Note extends Model
{
    use HasFactory;
    use Searchable;
    use HasTags;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'noteable_id',
        'noteable_type',
        'attachments'
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function noteable()
    {
        return $this->morphTo();
    }
}
