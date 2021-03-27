<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerateUniqueIdentity as Generator;
use Illuminate\Support\Str;

class Warranty extends Model
{
    use SoftDeletes, Generator;

    protected $fillable = [
        'name', 'unique_id', 'amount', 'warranty_type', 'description'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Create a uuid when a new Warranty is to be created
        static::creating(function ($warranties) {
            // Create a Unique Warranty uuid id
            $warranties->uuid = (string) Str::uuid();

            // Create a Unique Warranty id
            $warranties->unique_id = static::generate('warranties', 'WAR-');

        });

    }
}
