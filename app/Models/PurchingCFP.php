<?php

namespace App\Models;

use App\Models\User;
use App\Models\Machine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchingCFP extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'machine_id',
        'seller_id',
        'carbon_footprint',
        'buyer_id',
        'expire',
        'updated_at'
    ];

       
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
       // 'updated_at',
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function machineseller()
    {
        return $this->belongsTo(Machine::class, 'machine_seller_id');
    }

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function machinebuyer()
    {
        return $this->belongsTo(Machine::class, 'machine_buyer_id');
    }
    
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
