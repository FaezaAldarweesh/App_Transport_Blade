<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class Employee extends Model
{
   use HasFactory,softDeletes;
   protected $fillable = ['id','name','em_job','phone','deleted_at'];
}
