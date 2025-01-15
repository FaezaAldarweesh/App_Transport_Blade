<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory,softDeletes;

    /**
    * The attributes that are mass assignable.
    * @var array<int, string>
    */
    protected $fillable = [
        'name',
        'user_id',
    ];


    public function user (){
        
        return $this->belongsTo(User::class,'user_id','id')->withTrashed();

    }

    public function trips (){
        
        return $this->belongsToMany(Trip::class) ->withPivot('status')->withPivot('time_arrive');
    }   
    
    public function transports (){
        
        return $this->hasMany(Transport::class);
    } 
}
