<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Machine extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable = [
        'name',
        'owner_id',
        'location',
        'type',
        'warning',
        'carbon_footprint',
        'total_CF',
        'weather'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $dates =['deleted_at'];
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     
    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    
}
