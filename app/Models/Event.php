<?php

namespace App\Models;

use App\Models\User;
use Buildix\Timex\Traits\TimexTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\PermissionRegistrar;
use App\Models\Scopes\Searchable;
use Illuminate\Support\Facades\Auth;

class Event extends Model
{
    use HasFactory;
    use Searchable;
    use HasUuids;
    use TimexTrait;

    protected $guarded = [];

    protected $searchableFields = ['*'];

    // protected $hidden = ['organizer'];

    // protected $fillable = [
    //     'title',
    //     'description',
    //     'start_date',
    //     'end_date',
    //     'placement',
    //     'share_with',
    //     'repeat',
    //     'color',
    //     'status',
    //     'organizer',
    //     'client_id',
    // ];

    protected $casts = [
        'start' => 'date',
        'end' => 'date',
        'isAllDay' => 'boolean',
        'participants' => 'array',
        'attachments' => 'array',
        'status' => 'boolean'
    ];

    public function getTable()
    {
        return config('timex.tables.event.name', "timex_events");
    }

    public function __construct(array $attributes = [])
    {
        $attributes['organizer'] = Auth::id();

        parent::__construct($attributes);

    }

    public function category()
    {
        return $this->hasOne(self::getCategoryModel());
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function teamMembers()
    {
        return $this->belongsToMany(User::class);
    }

}
