<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Article extends Model
{
    use HasFactory;
    use Searchable;
    // use SortableTrait;

    protected $fillable = ['title', 'description', 'price', 'unit', 'quantity'];

    protected $searchableFields = ['*'];

    protected $appends = ['total'];

    // public function devis()
    // {
    //     return $this->belongsToMany(Devi::class);
    // }

    public function devis()
    {
        return $this->morphedByMany(Devi::class, 'articleable')->withPivot('quantity');
    }

    public function invoices()
    {
        return $this->morphedByMany(Invoice::class, 'articleable')->withPivot('quantity');
    }

    public function getTotalAttribute()
    {
        return $this->price * $this->pivot->quantity;
    }
}
