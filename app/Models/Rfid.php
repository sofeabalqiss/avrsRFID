<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rfid extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => 'string',
    ];

    // ✅ Allow mass assignment of these fields
    protected $fillable = [
        'rfid_string',
        'status',
        'type',
    ];

    public function activeVisitor(): HasOne
    {
        return $this->hasOne(Visitor::class)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->latest('valid_until');
    }

    public function latestVisitor(): HasOne
    {
        return $this->hasOne(Visitor::class)
            ->latest('valid_until');
    }

    public function visitors(): HasMany
    {
        return $this->hasMany(Visitor::class);
    }
}
