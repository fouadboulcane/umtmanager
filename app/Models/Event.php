<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'placement',
        'share_with',
        'repeat',
        'color',
        'status',
        'user_id',
        'client_id',
    ];

    protected $searchableFields = ['*'];

    protected $hidden = ['user_id'];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'repeat' => 'boolean',
        'status' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function teamMembers()
    {
        return $this->belongsToMany(User::class);
    }
}
