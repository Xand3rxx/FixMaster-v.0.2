<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EstateDiscountHistory extends Model
{
    use HasFactory;


    
    protected $fillable = [
        'name',  'discount_id', 'estate_name', 'rate', 'notify', 'duration_start', 'duration_end','users','created_by'
    ];

    protected $softDelete = false;


    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }

}
