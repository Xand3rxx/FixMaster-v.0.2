<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerateUniqueIdentity as Generator;

class Supplier extends Model
{
    use Generator;

    protected $fillable = [
        'unique_id', 'user_id', 'account_id', 'business_name', 'years_of_business', 'education_level', 'registered_identification_number', 'business_description', 
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['unique_id','created_at', 'updated_at'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($supplier) {
            $supplier->unique_id = static::generate('franchisees', 'SUP-', ''); // Create a Unique Supplier id
        });
    }

    /**
     * Get the user that owns the Account.
     */
    public function user()
    {
        return $this->belongsTo(User::class)->with(['account', 'phones', 'roles']);
    }
}
