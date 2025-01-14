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
            'first_phone' => '0947601911',
            'secound_phone' => '0947601912',
            'location' => 'location',
            'email' => 'admin@gmail.com',
            'password' => 11223344,
            'role' => "Admin",
        ]);

        $userSupervisor = User::create([
            'name' => 'Supervisor',
            'first_phone' => '0947601913',
            'secound_phone' => '0947601914',
            'location' => 'location',
            'email' => 'super@gmail.com',
            'password' => 11223344,
            'role' => "supervisor",
        ]);

        $userParent = User::create([
            'name' => 'Parent',
            'first_phone' => '0947601915',
            'secound_phone' => '0947601916',
            'location' => 'location',
            'email' => 'parent@gmail.com',
            'password' => 11223344,
            'role' => "parent",
        ]);

        $roleAdmin = Role::create(['name' => 'Admin']);
        $permissionsAdmin = Permission::pluck('id', 'id')->all();
        $roleAdmin->syncPermissions($permissionsAdmin);
        $userAdmin->assignRole($roleAdmin->id);

        $roleSupervisor = Role::create(['name' => 'supervisor']);
        $permissionsSupervisor = Permission::whereBetween('id', [8, 20])->pluck('id')->all();
        $roleSupervisor->syncPermissions($permissionsSupervisor);
        $userSupervisor->assignRole($roleSupervisor->id);

        $roleParent = Role::create(['name' => 'parent']);
        $permissionsParent = Permission::whereBetween('id', [1, 13])->pluck('id')->all();
        $roleParent->syncPermissions($permissionsParent);
        $userParent->assignRole($roleParent->id);
    }
}
