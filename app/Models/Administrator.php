<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'account_id'];

    /**
     * Get the user that owns the Account.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user that owns the Account.
     */
    public function phones()
    {
        return $this->hasMany(Phone::class, 'user_id', 'user_id');
    }

    /**
     * Get the Administrator that role
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles', 'user_id','user_id');
        // return $this->hasMany(Role::class, 'user_id', 'user_id');
    }

    /**
     * Get the Account associated with the user.
     */
    public function account()
    {
        return $this->hasOne(Account::class, 'user_id', 'user_id');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saving(function ($user) {
            $user->created_by = auth()->user()->email; // Register the Created by column
        });
    }
}
