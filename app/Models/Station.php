<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Station extends Model
{
    use HasFactory,softDeletes;
    /**
    * The attributes that are mass assignable.
    * @var array<int, string>
    */
    protected $fillable = [
        'name',
        'path_id',
        'status',
        'time_go',
        'time_back',
        'latitude',
        'longitude'
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope('orderByTime', function (Builder $query) {
    //         $query->orderByRaw("COALESCE(time_go, time_back) ASC");
    //     });
    // }
    
    public function path (){

        return $this->belongsTo(Path::class,'path_id','id')->withTrashed();

    }
}
