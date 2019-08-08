<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Notifications extends Model
{
    protected $fillable = [
    	'customer_id', 'customer_name', 'package_id', 'due_date', 'action',
    ];
}
