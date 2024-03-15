<?php

namespace App\Models;

use App\Models\Machine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Revive extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'machine_id',
        'co2',
        'co',
        'o2',
        'degree',
        'humidity',
        'expire',
    ];

    protected $hidden = [
        // 'updated_at',
        'deleted_at'
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
        return $this->belongsTo(Machine::class, 'machine_id');
    }
   
}
