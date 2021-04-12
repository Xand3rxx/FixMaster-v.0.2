<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerateUniqueIdentity as Generator;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warranty extends Model
{
    use SoftDeletes, Generator;
    use HasFactory;

    protected $fillable = [
        'user_id','name', 'unique_id', 'percentage', 'warranty_type', 'duration', 'description'
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

    /**
     * Scope a query to only include active banches
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    //Scope to return all active services
    public function scopeAllWarranties($query){
        return $query->select('*')
            ->whereNull('deleted_at')
            ->orderBy('name', 'ASC');
    }

    public function scopeWarranties($query){
        return $query->select('*')
        ->orderBy('name', 'ASC');
    }
}
