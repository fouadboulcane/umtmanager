<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserMeta extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'address',
        'address2',
        'phone',
        'gender',
        'user_id',
        'birthdate',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'user_metas';

    protected $casts = [
        'birthdate' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
