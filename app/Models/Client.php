<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'address',
        'city',
        'state',
        'zipcode',
        'website',
        'tva_number',
        'currency_id',
        'rc',
        'nif',
        'art',
        'online_payment',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'online_payment' => 'boolean',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function devis()
    {
        return $this->hasMany(Devi::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function deviRequests()
    {
        return $this->hasMany(DeviRequest::class);
    }

    public function groupClients()
    {
        return $this->belongsToMany(User::class);
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable');
    }
}
