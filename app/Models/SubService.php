<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubService extends Model
{
    use SoftDeletes;

    protected $table = 'sub_services';

    protected $fillable = [
        'user_id', 'service_id', 'name', 'first_hour_charge', 'subsequent_hour_charge'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'id'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Create a uuid when a new Sub Serivce uuid and url is to be created
        static::creating(function ($subService) {
            $subService->uuid = (string) Str::uuid();
        });
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}
