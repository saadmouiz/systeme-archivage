<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Créer les rôles s'ils n'existent pas déjà
        $superAdminRole = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $admin1Role = Role::firstOrCreate(['name' => 'admin1', 'guard_name' => 'web']);
        $admin2Role = Role::firstOrCreate(['name' => 'admin2', 'guard_name' => 'web']);
        $admin3Role = Role::firstOrCreate(['name' => 'admin3', 'guard_name' => 'web']);
        // Définition des comptes à créer
        $admins = [
            [
                'name' => 'Hani El Harraq',
                'email' => 'hani.elharraq@aiais.org',
                'password' => Hash::make('password123'),
                'is_active' => 1,
                'role' => 'superadmin',
            ],
            [
                'name' => 'Hind Echarqui',
                'email' => 'hind.echarqui@aiais.org',
                'password' => Hash::make('password123'),
                'is_active' => 1,
                'role' => 'admin1',
            ],
            [
                'name' => 'Chaimae Laqtib',
                'email' => 'chaimae.laqtib@aiais.org',
                'password' => Hash::make('password123'),
                'is_active' => 1,
                'role' => 'admin2',
            ],
            [
                'name' => 'Kaoutar Zehdi',
                'email' => 'kaoutar.zehdi@aiais.org',
                'password' => Hash::make('password123'),
                'is_active' => 1,
                'role' => 'admin3',
            ],
        ];

        // Création des administrateurs et assignation des rôles
        foreach ($admins as $adminData) {
            $admin = Admin::firstOrCreate(
                ['email' => $adminData['email']],
                [
                    'name' => $adminData['name'],
                    'password' => $adminData['password'],
                    'is_active' => $adminData['is_active'],
                ]
            );

            if (!$admin->hasRole($adminData['role'])) {
                $admin->assignRole($adminData['role']);
            }
        }
    }
}
