<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    const ADMINNAME = 'Admin';
    const ADMIN = "1" ;
    const OWNER = '2' ; 
    const CUSTOMER = "3" ;
    const TOURISM = "4";
    const COASTAL = "5";
    const REVIVE = "6";
    const FCI = "7";
    const WEATHER = '8';
    const OTHER = "9";
    const EXPIRE = "1";
    const NOTEXPIRE = "0";
    const GOOGLE ="google"; 
    const GITHUB = "github";
    const TESTPY = "1";
    const DIOXIDEPY = "2";
    const TRAINGPY = "3";
    const WEATHERPY = "4";
    const CHATPY = "5";
    const MailRevive = "revivecarbon@gmail.com";

}
