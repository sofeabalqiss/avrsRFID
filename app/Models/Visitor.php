<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'ic_number',       // Corrected based on your clarification
        'name_printed',    // From database
        'address_1',       // Single address field from database
        'visitor_type',    // From database
        'vehicle_plate',
        'house_number',    // From database
        'rfid_id',          // Foreign key to rfids table
        'valid_from',
        'valid_until',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];

    public function rfid() {
        return $this->belongsTo(Rfid::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class, 'visitor_id', 'id');
    }

    public function lastVisit()
    {
        return $this->visits()->latest()->first();
    }
}
