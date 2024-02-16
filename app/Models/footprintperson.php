<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class footprintperson extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'carbon_footprint',
    ];
  
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'updated_at',
    ];

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $dates =['delete_at'];
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
