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
        'main_contact'
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

    public function contacts()
    {
        return $this->belongsToMany(User::class)->withPivot('main_contact');
    }

    public function mainContact()
    {
        return $this->contacts->where('pivot.main_contact', 1);
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable');
    }

    public function invoiceAmount()
    {
        return $this->invoices->sum('total');
    }

    public function paidAmount()
    {
        return $this->invoices->sum('paid');
    }

    public function unpaidAmount()
    {
        return $this->invoiceAmount() - $this->paidAmount();
    }
}

