<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Packages extends Model
{
    protected $fillable = [
    	'package_name', 'duration', 'price',
    ];
}
