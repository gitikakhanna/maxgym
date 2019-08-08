<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $fillable = [
    	'name', 'email', 'address', 'contact'
    ];
}
