<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Spatie\Tags\HasTags;

class Project extends Model
{
    use HasFactory;
    use Searchable;
    use HasTags;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'price',
        'client_id',
        'status',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected $appends = ['progress'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function doneTasks()
    {
        return $this->tasks->where('status', 'done');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable');
    }

    public function projectMembers()
    {
        // return $this->tasks->map(function($task) {
        //     $task->assignedMember;
        // });
        // $members = array();
 
        // $members = $this->tasks->map(function ($task) {
        //     return $task->collabMembers;
        // });
        // $mems = collect($members)->filter->all();
        // return $this->hasManyThrough(
        //     User::class,
        //     Task::class,
        //     'task_id',
        //     'id',
        //     'id',
        //     'user_id'
        // );

        return $this->hasMany(Task::class, 'project_id')->with('collabMembers');
        // $task_ids = Task::where('project_id', $this->id)->pluck('id');
        // $user_ids = DB::table('task_user')->whereIn('task_id', $task_ids)->pluck('user_id');
        // Log::info($user_ids);
        // return User::whereIn('id', $user_ids)->get();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getProgressAttribute()
    {
        $tasks = $this->tasks()->count();
        return $tasks ? 100* $this->doneTasks()->count() / $tasks : 0;
    }
}
