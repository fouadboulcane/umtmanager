<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Devi extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'start_date',
        'end_date',
        'tax',
        'tax2',
        'note',
        'client_id',
        'status',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // public function articles()
    // {
    //     return $this->belongsToMany(Article::class);
    // }

    public function articles()
    {
        return $this->morphToMany(Article::class, 'articleable')->withPivot('quantity');
    }
}
