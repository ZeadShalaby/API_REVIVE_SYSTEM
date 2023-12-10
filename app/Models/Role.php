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
    const TOURISM = "4";
    const COASTAL = "5";
    const REVIVE = "6";
    const EXPIRE = "1";
    const NOTEXPIRE = "0";
    const GOOGLE ="google"; 
    const GITHUB = "github";
    const PATH_PYTHON = '/public/code_python/code_model/python.py';
    
   

}
