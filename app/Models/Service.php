<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    // column name of key
    protected $primaryKey = 'uuid';

    // type of key
    protected $keyType = 'string';

    // whether the key is automatically incremented or not
    public $incrementing = false;
    
    protected $fillable = [
        'user_id', 'category_id', 'name', 'url', 'description', 'status', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Create a uuid when a new serivce uuid and url is to be created 
        static::creating(function ($service) {
            $service->uuid = (string) Str::uuid(); 
            $service->url = (string) Str::uuid(); 
        });
    }

     /** 
     * Scope a query to only include active banches
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */    
    //Scope to return all services  
    public function scopeServicies($query){
        return $query->select('*')
        ->orderBy('name', 'ASC');
        // ->withTrashed();
    }

    /** 
     * Scope a query to only include active banches
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */    
    //Scope to return all active services  
    public function scopeActiveServicies($query){
        return $query->select('*')
        ->where('status', '=', 1)
        // ->whereNull('deleted_at')
        ->orderBy('name', 'ASC');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function users()
    {
        return $this->hasMany(User::class, 'user_id')->withDefault();
    }
    
    /**
     * Get the Account associated with the user.
     */
    public function account()
    {
        return $this->hasOne(Account::class, 'user_id', 'user_id');
    }
    
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'id', 'category_id');
    }
}
