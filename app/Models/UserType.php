<?php

namespace App\Models;

use App\Traits\RolesAndPermissions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserType extends Model
{
    use HasFactory, RolesAndPermissions;

     /**
     * The roles relationship.
     * @return mixed
     */
    public function role()
    {
        return $this->hasOne(Role::class,'id','role_id');
    }
}
