<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Tags\HasTags;

class Ticket extends Model
{
    use HasFactory;
    use Searchable;
    use HasTags;

    protected $fillable = [
        'title',
        'description',
        'type',
        'client_id',
        'user_id',
        'status',
        'attachments'
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function teamMember()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
