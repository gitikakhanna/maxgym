<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Attendance extends Model
{
    protected $fillable = [
    	'trainerid', 'name', 'attended_date', 'marking'
    ];
}
