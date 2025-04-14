<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Admin;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Création des rôles s'ils n'existent pas déjà
        if (!Role::where('name', 'superadmin')->exists()) {
            Role::create(['name' => 'superadmin', 'guard_name' => 'web']);
        }
        
        if (!Role::where('name', 'admin1')->exists()) {
            Role::create(['name' => 'admin1', 'guard_name' => 'web']);
        }
        
        if (!Role::where('name', 'admin2')->exists()) {
            Role::create(['name' => 'admin2', 'guard_name' => 'web']);
        }
        if (!Role::where('name', 'admin3')->exists()) {
            Role::create(['name' => 'admin3', 'guard_name' => 'web']);
        }
                             

        
        
        // Optionnel: Assigner le rôle superadmin au premier admin s'il n'a pas déjà de rôle
        $firstAdmin = Admin::first();
        if ($firstAdmin && $firstAdmin->roles()->count() === 0) {
            $firstAdmin->assignRole('superadmin');
            $this->command->info('Le rôle superadmin a été assigné au premier administrateur.');
        }
    }  


}