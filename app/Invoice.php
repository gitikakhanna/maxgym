<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Invoice extends Model
{
    protected $fillable = [
    	'member_id', 'name', 'package_from', 'package_till', 'duration', 'amount_paid', 'amount_due'
    ];
}
