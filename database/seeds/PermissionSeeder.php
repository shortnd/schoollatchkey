<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // User

        // Child
        Permission::create(['name' => 'edit child']);
        Permission::create(['name' => 'delete child']);
        Permission::create(['name' => 'view child']);
        Permission::create(['name' => 'create child']);

        // School
        Permission::create(['name' => 'edit school']);
        Permission::create(['name' => 'delete school']);
        Permission::create(['name' => 'view school']);
        Permission::create(['name' => 'create school']);

        $parentRole = Role::create(['name' => 'parent'])->givePermissionTo(['view child']);
        $staffRole = Role::create(['name' => 'staff'])->givePermissionTo(['edit child', 'view child', 'delete child', 'create child']);
        $adminRole = Role::create(['name' => 'admin']);

        $parentRole;
        $staffRole;
        $adminRole;
    }
}
