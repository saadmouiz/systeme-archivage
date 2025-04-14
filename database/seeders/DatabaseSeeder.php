<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ajouter la permission si elle n'existe pas
        if (!Permission::where('name', 'view_pointages')->exists()) {
            Permission::create(['name' => 'view_pointages']);
        }

        // Assigner la permission aux rôles
        $roleAdmin1 = Role::where('name', 'admin1')->first();
        $roleSuperAdmin = Role::where('name', 'superadmin')->first();

        if ($roleAdmin1) {
            $roleAdmin1->givePermissionTo('view_pointages');
        }

        if ($roleSuperAdmin) {
            $roleSuperAdmin->givePermissionTo('view_pointages');
        }
    }
}
