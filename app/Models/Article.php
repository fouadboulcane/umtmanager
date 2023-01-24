<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['title', 'description', 'price', 'unit', 'quantity'];

    protected $searchableFields = ['*'];

    public function devis()
    {
        return $this->belongsToMany(Devi::class);
    }
}
