<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permission::truncate();
        $manageUser = new Permission();
        $manageUser->name = 'Create New Administrator';
        $manageUser->slug = 'create-admin';
        $manageUser->save();

        $createTasks = new Permission();
        $createTasks->name = 'View Administrator';
        $createTasks->slug = 'view-administrators';
        $createTasks->save();

        $createTasks = new Permission();
        $createTasks->name = 'Create New CSE';
        $createTasks->slug = 'create-cse';
        $createTasks->save();

        $createTasks = new Permission();
        $createTasks->name = 'View CSE';
        $createTasks->slug = 'view-cse';
        $createTasks->save();

        $createTasks = new Permission();
        $createTasks->name = 'Create New Technician';
        $createTasks->slug = 'create-technician';
        $createTasks->save();

        $createTasks = new Permission();
        $createTasks->name = 'View Technicians';
        $createTasks->slug = 'view-technicians';
        $createTasks->save();

        $createTasks = new Permission();
        $createTasks->name = 'View Clients';
        $createTasks->slug = 'view-clients';
        $createTasks->save();

        $createTasks = new Permission();
        $createTasks->name = 'View QualityAssurance';
        $createTasks->slug = 'view-qa';
        $createTasks->save();
    }
}
