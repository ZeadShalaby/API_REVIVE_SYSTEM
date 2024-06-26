<?php

namespace App\Models;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    const SECRET = "EI8m2bl8TFVjbwYmuopsNPd1"; 
    const SECRETMACHINE = "NPd1nyozbX9qGyfAqKkCDlDY5Fn8CGr";
    const ADMINNAME = 'Admin Revive';
    const ADMIN = 1 ;
    const OWNER = 2 ; 
    const CUSTOMER = 3 ;
    const TOURISM = 4;
    const COASTAL = 5;
    const REVIVE = 6;
    const FCI = 7;
    const WEATHER = 8;
    const OTHER = 9;
    const GREENTREE = 10;
    const EXPIRE = 0;
    const NOTEXPIRE = 1;
    const GOOGLE = 'google'; 
    const GITHUB = 'github';
    const TESTPY = 1;
    const DIOXIDEPY = 2;
    const TRAINGPY = 3;
    const WEATHERPY = 4;
    const CHATPY = 5;
    const FOOTPRINTFACTORY = 6;
    const TRAININGFOOTPRINTPERSON = 7;
    const TRAININGFOOTPRINTFACTORY = 8;
    const MailRevive = 'revivecarbon@gmail.com'; 
    const co2limit = 100;
    const free_dioxide = 2000; // ? its two tan 2t  = 2000 kg
}
