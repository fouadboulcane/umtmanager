<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Scopes\Searchable;
use App\Models\Traits\FilamentTrait;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements HasAvatar, HasName
{
    use HasRoles;
    use Notifiable;
    use HasFactory;
    use Searchable;
    use HasApiTokens;
    use FilamentTrait;

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }

    protected $fillable = [
        'first_name',
        'last_name',
        'avatar_url',
        'email',
        'password',
        'enable_login',
    ];

    protected $searchableFields = ['*'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'enable_login' => 'boolean',
    ];

    protected $appends = [
        'fullname'
    ];

    public function teamMember()
    {
        return $this->hasOne(TeamMember::class, 'team_member_id');
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

    public function userMeta()
    {
        return $this->hasOne(UserMeta::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'member_id');
    }

    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'creator_id');
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
        return $this->belongsToMany(Client::class)->withPivot('main_contact');
    }

    public function tasks2()
    {
        return $this->belongsToMany(Task::class);
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
    }

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public static function getUsers()
    {
        $msgs = DB::table('messages')->select('sender_id', 'receiver_id')
            ->where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->get();
        $users = array();

        foreach($msgs as $msg){
            if($msg->sender_id == $msg->receiver_id) array_push($users, $msg->sender_id);
            elseif($msg->sender_id == Auth::id()) array_push($users, $msg->receiver_id);
            elseif($msg->receiver_id == Auth::id()) array_push($users, $msg->sender_id);
        }
        return array_unique($users);
    }

    public function getMessages($recipient_id)
    {
        $sent = Message::with('sender', 'receiver')
            // ->join('users', 'messages.sender_id', '=', 'users.id')
            // ->select('subject', 'body', 'sender_id', 'receiver_id', 'name', 'avatar_url')
            ->where('sender_id', Auth::id())
            ->where('receiver_id', $recipient_id);

        return Message::with('sender', 'receiver')
            // ->join('users', 'messages.sender_id', '=', 'users.id')
            // ->select('subject', 'body', 'sender_id', 'receiver_id', 'name', 'avatar_url')
            ->where('sender_id', $recipient_id)
            ->where('receiver_id', Auth::id())
            ->union($sent)
            // ->latest()
            // ->join('sender')
            ->get();
    }

    public function getFilamentName(): string 
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getFullnameAttribute(): string 
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
