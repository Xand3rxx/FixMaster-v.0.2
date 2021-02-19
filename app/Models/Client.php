<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id', 'state_id', 'lga_id', 'estate_id', 'profession_id', 'first_name', 'middle_name', 'last_name', 'phone_number', 'occupation', 'avatar', 'full_address', 'discounted'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'user_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function lga()
    {
        return $this->belongsTo(Lga::class);
    }

    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }
}
