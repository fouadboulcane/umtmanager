<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list anouncements']);
        Permission::create(['name' => 'view anouncements']);
        Permission::create(['name' => 'create anouncements']);
        Permission::create(['name' => 'update anouncements']);
        Permission::create(['name' => 'delete anouncements']);

        Permission::create(['name' => 'list articles']);
        Permission::create(['name' => 'view articles']);
        Permission::create(['name' => 'create articles']);
        Permission::create(['name' => 'update articles']);
        Permission::create(['name' => 'delete articles']);

        Permission::create(['name' => 'list categories']);
        Permission::create(['name' => 'view categories']);
        Permission::create(['name' => 'create categories']);
        Permission::create(['name' => 'update categories']);
        Permission::create(['name' => 'delete categories']);

        Permission::create(['name' => 'list clients']);
        Permission::create(['name' => 'view clients']);
        Permission::create(['name' => 'create clients']);
        Permission::create(['name' => 'update clients']);
        Permission::create(['name' => 'delete clients']);

        Permission::create(['name' => 'list currencies']);
        Permission::create(['name' => 'view currencies']);
        Permission::create(['name' => 'create currencies']);
        Permission::create(['name' => 'update currencies']);
        Permission::create(['name' => 'delete currencies']);

        Permission::create(['name' => 'list devis']);
        Permission::create(['name' => 'view devis']);
        Permission::create(['name' => 'create devis']);
        Permission::create(['name' => 'update devis']);
        Permission::create(['name' => 'delete devis']);

        Permission::create(['name' => 'list devirequests']);
        Permission::create(['name' => 'view devirequests']);
        Permission::create(['name' => 'create devirequests']);
        Permission::create(['name' => 'update devirequests']);
        Permission::create(['name' => 'delete devirequests']);

        Permission::create(['name' => 'list events']);
        Permission::create(['name' => 'view events']);
        Permission::create(['name' => 'create events']);
        Permission::create(['name' => 'update events']);
        Permission::create(['name' => 'delete events']);

        Permission::create(['name' => 'list expenses']);
        Permission::create(['name' => 'view expenses']);
        Permission::create(['name' => 'create expenses']);
        Permission::create(['name' => 'update expenses']);
        Permission::create(['name' => 'delete expenses']);

        Permission::create(['name' => 'list invoices']);
        Permission::create(['name' => 'view invoices']);
        Permission::create(['name' => 'create invoices']);
        Permission::create(['name' => 'update invoices']);
        Permission::create(['name' => 'delete invoices']);

        Permission::create(['name' => 'list leaves']);
        Permission::create(['name' => 'view leaves']);
        Permission::create(['name' => 'create leaves']);
        Permission::create(['name' => 'update leaves']);
        Permission::create(['name' => 'delete leaves']);

        Permission::create(['name' => 'list manifests']);
        Permission::create(['name' => 'view manifests']);
        Permission::create(['name' => 'create manifests']);
        Permission::create(['name' => 'update manifests']);
        Permission::create(['name' => 'delete manifests']);

        Permission::create(['name' => 'list notes']);
        Permission::create(['name' => 'view notes']);
        Permission::create(['name' => 'create notes']);
        Permission::create(['name' => 'update notes']);
        Permission::create(['name' => 'delete notes']);

        Permission::create(['name' => 'list payments']);
        Permission::create(['name' => 'view payments']);
        Permission::create(['name' => 'create payments']);
        Permission::create(['name' => 'update payments']);
        Permission::create(['name' => 'delete payments']);

        Permission::create(['name' => 'list posts']);
        Permission::create(['name' => 'view posts']);
        Permission::create(['name' => 'create posts']);
        Permission::create(['name' => 'update posts']);
        Permission::create(['name' => 'delete posts']);

        Permission::create(['name' => 'list presences']);
        Permission::create(['name' => 'view presences']);
        Permission::create(['name' => 'create presences']);
        Permission::create(['name' => 'update presences']);
        Permission::create(['name' => 'delete presences']);

        Permission::create(['name' => 'list projects']);
        Permission::create(['name' => 'view projects']);
        Permission::create(['name' => 'create projects']);
        Permission::create(['name' => 'update projects']);
        Permission::create(['name' => 'delete projects']);

        Permission::create(['name' => 'list sociallinks']);
        Permission::create(['name' => 'view sociallinks']);
        Permission::create(['name' => 'create sociallinks']);
        Permission::create(['name' => 'update sociallinks']);
        Permission::create(['name' => 'delete sociallinks']);

        Permission::create(['name' => 'list tasks']);
        Permission::create(['name' => 'view tasks']);
        Permission::create(['name' => 'create tasks']);
        Permission::create(['name' => 'update tasks']);
        Permission::create(['name' => 'delete tasks']);

        Permission::create(['name' => 'list teammembers']);
        Permission::create(['name' => 'view teammembers']);
        Permission::create(['name' => 'create teammembers']);
        Permission::create(['name' => 'update teammembers']);
        Permission::create(['name' => 'delete teammembers']);

        Permission::create(['name' => 'list tickets']);
        Permission::create(['name' => 'view tickets']);
        Permission::create(['name' => 'create tickets']);
        Permission::create(['name' => 'update tickets']);
        Permission::create(['name' => 'delete tickets']);

        Permission::create(['name' => 'list usermetas']);
        Permission::create(['name' => 'view usermetas']);
        Permission::create(['name' => 'create usermetas']);
        Permission::create(['name' => 'update usermetas']);
        Permission::create(['name' => 'delete usermetas']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
