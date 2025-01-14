<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use HasFactory,softDeletes;
    /**
    * The attributes that are mass assignable.
    * @var array<int, string>
    */
    protected $fillable = [
        'name',
        'type',
        'path_id',
        'bus_id',
        'start_date',
        'end_date',
        'level',
        'status',
    ];

    public function path (){
        
        return $this->belongsTo(Path::class)->withTrashed();
    }
    public function students (){
        
        return $this->belongsToMany(Student::class) ->withPivot('status')->withPivot('time_arrive')->withTrashed();
    }

    public function users (){
        
        return $this->belongsToMany(User::class)->withTrashed();
    }

    public function drivers (){
        
        return $this->belongsToMany(Driver::class)->withTrashed();
    }

    public function bus (){
        
        return $this->belongsTo(Bus::class)->withTrashed();
    }
}
