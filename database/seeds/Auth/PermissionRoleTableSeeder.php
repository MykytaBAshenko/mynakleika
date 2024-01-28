<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Create Roles
        $admin = Role::create(['name' => config('access.users.admin_role')]);
        $customer = Role::create(['name' => config('access.users.customer_role')]);
        $manager = Role::create(['name' => config('access.users.manager_role')]);
        $accountant = Role::create(['name' => config('access.users.accountant_role')]);
        $dtp = Role::create(['name' => config('access.users.dtp_role')]);

        // Create Permissions
        $permissions = ['view backend', 'view manager', 'view customer', 'view accountant', 'view dtp'];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // ALWAYS GIVE ADMIN ROLE ALL PERMISSIONS
        $admin->givePermissionTo(Permission::all());

        // Assign Permissions to other Roles
        $customer->givePermissionTo('view customer');
        $manager->givePermissionTo('view manager');
        $dtp->givePermissionTo('view dtp');
        $accountant->givePermissionTo('view accountant');

        $this->enableForeignKeys();
    }
}
