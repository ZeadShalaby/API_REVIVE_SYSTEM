<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    const ADMIN = "1" ;
    const OWNER = '2' ; 
    const CUSTOMER = "3" ;
}