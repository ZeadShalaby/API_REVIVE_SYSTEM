<?php

namespace App\Models;

use App\Models\Machine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class footprintfactory extends Model
{
    use HasFactory;

    protected $fillable = [
        'machine_id',
        'carbon_footprint',
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
    public function machine()
    {
        return $this->belongsTo(Machine::class, 'user_id');
    }
}
