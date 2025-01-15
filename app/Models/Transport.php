<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    * @var array<int, string>
    */
    protected $fillable = [
        'trip_id',
        'student_id',
        'station_id',
    ];

    public function student (){
        
        return $this->belongsTo(Student::class);
    }

    public function trip (){
        
        return $this->belongsTo(Trip::class);
    }

    public function station (){
        
        return $this->belongsTo(Station::class);
    }
}
