<?php

namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;

trait RolesAndPermissions
{
    
    
    /**
     * The roles relationship.
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    /**
     * The permissions relationship.
     * @return mixed
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }
}
