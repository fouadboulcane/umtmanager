<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'description',
        'difficulty',
        'project_id',
        'status',
        'start_date',
        'end_date',
        'creator_id',
        'member_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function assignedMember()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function collabMembers()
    {
        return $this->belongsToMany(User::class);
    }
}
