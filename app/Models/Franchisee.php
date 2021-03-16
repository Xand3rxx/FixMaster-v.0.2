<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerateUniqueIdentity as Generator;

class Franchisee extends Model
{
    use Generator;

    protected $table = "franchisees";

    protected $fillable = [
        'unique_id', 'cac_number', 'user_id', 'account_id', 'franchise_description', 'established_on'
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
        static::creating(function ($franchisee) {
            $franchisee->unique_id = static::generate('franchisees', 'FR-', ''); // Create a Unique Franchisee id
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
