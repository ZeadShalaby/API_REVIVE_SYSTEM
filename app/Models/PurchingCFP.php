<?php

namespace App\Models;

use App\Models\User;
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
        'expire'
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
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
