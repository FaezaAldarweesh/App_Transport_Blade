<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userAdmin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 11223344,
            'role' => "Admin",
        ]);

        $roleAdmin = Role::create(['name' => 'Admin']);
        $permissionsAdmin = Permission::pluck('id', 'id')->all();
        $roleAdmin->syncPermissions($permissionsAdmin);
        $userAdmin->assignRole($roleAdmin->id);

        $roleSupervisor = Role::create(['name' => 'supervisor']);
        $permissionsSupervisor = Permission::whereBetween('id', [71, 83])->pluck('id')->all();
        $roleSupervisor->syncPermissions($permissionsSupervisor);

        $roleParent = Role::create(['name' => 'parent']);
        $permissionsParent = Permission::whereBetween('id', [84, 85])->pluck('id')->all();
        $roleParent->syncPermissions($permissionsParent);
    }
}
