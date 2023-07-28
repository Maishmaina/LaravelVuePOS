<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable= ['name','email','phone','address','photo','salary','nid','joining_date'];
}
