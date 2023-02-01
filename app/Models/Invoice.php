<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'billing_date',
        'due_date',
        'tax',
        'tax2',
        'note',
        'reccurent',
        'status',
        'project_id',
        'client_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'billing_date' => 'date',
        'due_date' => 'date',
        'reccurent' => 'boolean',
    ];

    protected $appends = [
        'invoice_id',
        'total',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function articles()
    {
        return $this->morphToMany(Article::class, 'articleable')->withPivot('quantity');
    }

    public function getTotalAttribute()
    {
        return $this->articles->sum('total');
    }

    public function getInvoiceIdAttribute()
    {
        return 'FA-' . sprintf('%04d', $this->id);
    }

    public function getPaidAttribute()
    {
        return $this->payments->sum('amount');
    }
}
