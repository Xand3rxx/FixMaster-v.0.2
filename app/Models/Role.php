<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
// const ROLE_SLUG_ADMIN = 'admin-user';
     /**
     * The permissions that belong to the role.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'roles_permissions');
    }

    /**
     * The permissions that belong to the role.
     */
    public function users()
    {
        return $this->belongsToMany(User::class,'users_roles')->with('account');
    }
}
