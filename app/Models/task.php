<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class task extends Model
{
    use SoftDeletes; 

    protected $table= 'tasks';
    protected $fillable= ['title','descripcion','status','user_id'];

}