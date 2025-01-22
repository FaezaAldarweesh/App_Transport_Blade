<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripTrack extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'location'
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
