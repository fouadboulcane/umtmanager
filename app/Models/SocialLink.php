<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialLink extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'facebook',
        'twitter',
        'linkedin',
        'google_plus',
        'digg',
        'youtube',
        'pinterest',
        'instagram',
        'github',
        'tumblr',
        'tiktok',
        'user_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'social_links';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
