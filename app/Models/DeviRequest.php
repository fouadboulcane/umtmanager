<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeviRequest extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'content',
        'manifest_id',
        'client_id',
        'user_id',
        'status',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'devi_requests';

    protected $casts = [
        'content' => 'array',
    ];

    public function manifest()
    {
        return $this->belongsTo(Manifest::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function assignedMember()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
