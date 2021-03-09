<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the phone.
     */
    protected $fillable = ['user_id', 'account_id', 'country_id', 'number'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user that owns the phone.
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
