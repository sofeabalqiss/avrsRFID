<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;
    protected $fillable = ['visitor_id', 'check_in', 'check_out'];
    // Relationship to visitor
    public function visitor()
    {
        return $this->belongsTo(Visitor::class, 'visitor_id', 'id');
    }
}
