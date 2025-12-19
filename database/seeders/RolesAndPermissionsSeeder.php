<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{

    public function run(): void
    {
        //Creación de roles
        $superAdminRole = Role::create(['name' => 'super administrador']);
        $adminRole = Role::create(['name' => 'administrador']);
        $colaboradorRole = Role::create(['name' => 'colaborador']);
        $balanzaRole = Role::create(['name' => 'balanza']);

        //Creación de permisos
        $manageUsersPermission = Permission::create(['name' => 'manage users']);
        $manageSettingsPermission = Permission::create(['name' => 'manage settings']);
        $manageBalanza = Permission::create(['name' => 'ver balanza']);

        //Asignación de permisos y roles
        $superAdminRole->givePermissionTo($manageUsersPermission, $manageSettingsPermission);
        $adminRole->givePermissionTo($manageUsersPermission);
        $colaboradorRole->givePermissionTo($manageUsersPermission);
        $balanzaRole->givePermissionTo($manageBalanza);
    }
}
