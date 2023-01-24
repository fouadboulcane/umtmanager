<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeamMember extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'job_title',
        'salary',
        'conditions',
        'n_ss',
        'recruitment_date',
        'send_info',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'team_members';

    protected $casts = [
        'recruitment_date' => 'date',
        'send_info' => 'boolean',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
