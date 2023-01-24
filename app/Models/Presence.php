<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presence extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['arrival_date', 'departure_date', 'note', 'user_id'];

    protected $searchableFields = ['*'];

    protected $casts = [
        'arrival_date' => 'datetime',
        'departure_date' => 'datetime',
    ];

    public function teamMember()
    {
        return $this->belongsTo(User::class);
    }
}
