<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Leave extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'type',
        'duration',
        'start_date',
        'end_date',
        'reason',
        'status',
        'user_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'boolean',
    ];

    public function teamMember()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
