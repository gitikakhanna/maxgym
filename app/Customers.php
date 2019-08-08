<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Customers extends Model
{
    protected $fillable = [
    	'name', 'gender', 'email', 'address', 'contact', 'dob', 'joiningdate', 'due_date', 'package',
    ];
}
