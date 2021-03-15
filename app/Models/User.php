<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Traits\RolesAndPermissions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, RolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            $user->uuid = (string) Str::uuid(); // Create uuid when a new user is to be created
        });
    }

    /**
     * Get the Type associated with the user.
     */
    public function type()
    {
        return $this->hasOne(UserType::class);
    }

    /**
     * Get the Category associated with the user who created it.
     */
    public function category()
    {
        return $this->hasOne(Category::class);
    }

    /**
     * Get the Categories associated with the user who created it.
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Get the Sercice associated with the user who created it.
     */
    public function service()
    {
        return $this->hasOne(Service::class);
    }

    /**
     * Get the Services associated with the user who created it.
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Get the Account associated with the user.
     */
    public function account()
    {
        return $this->hasOne(Account::class);
    }

    /**
     * Get the Administrator associated with the user.
     */
    public function administrator()
    {
        return $this->hasOne(Administrator::class);
    }

    /**
     * Get the Administrator associated with the user.
     */
    public function logs()
    {
        return $this->hasMany(ActivityLog::class, 'user_id', 'id');
    }
    
    /**
     * Get the phone associated with the user.
     */
    public function phone()
    {
        return $this->hasOne(Phone::class);
    }

    /**
     * Get the phone associated with the user.
     */
    public function phones()
    {
        return $this->hasMany(Phone::class);
    }

    /**
     * Get the phone associated with the user.
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function estate()
    {
        return $this->hasOne(Estate::class);
    }

    public function estates()
    {
        return $this->hasMany(Estate::class);
    }

    public function payments()
    {
        return $this->hasMany(PaymentDisbursed::class, 'recipient_id');
    }
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function serviceRequest()
    {
        return $this->hasOne(ServiceRequest::class);
    }

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }
}
