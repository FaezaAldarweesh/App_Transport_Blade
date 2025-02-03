<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


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

    public function scopeFilter(Builder $query, $request)
    {
        if ($request->input('name') !== null) {
            $query->where('name', '=', $request->input('name'));
        }
        if ($request->input('type') !== null) {
            $query->where('type', '=', $request->input('type'));
        }

        return $query;
    }

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
    public function checkouts (){
        
        return $this->hasMany(Checkout::class);
    } 
    public function tripTrack(){
        return $this->hasMany(TripTrack::class);
    }
    public function transport(){
        return $this->hasMany(Transport::class);
    }
}
