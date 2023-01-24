<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Scopes\Searchable;
use App\Models\Traits\FilamentTrait;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;
    use HasFactory;
    use Searchable;
    use HasApiTokens;
    use FilamentTrait;

    protected $fillable = [
        'name',
        'email',
        'password',
        'team_member_id',
        'enable_login',
    ];

    protected $searchableFields = ['*'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'enable_login' => 'boolean',
    ];

    public function teamMember()
    {
        return $this->belongsTo(TeamMember::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function createdEvents()
    {
        return $this->hasMany(Event::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function anouncements()
    {
        return $this->hasMany(Anouncement::class);
    }

    public function socialLinks()
    {
        return $this->hasMany(SocialLink::class);
    }

    public function userMetas()
    {
        return $this->hasMany(UserMeta::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'member_id');
    }

    public function deviRequests()
    {
        return $this->hasMany(DeviRequest::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }

    public function tasks2()
    {
        return $this->belongsToMany(Task::class);
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
    }
}
