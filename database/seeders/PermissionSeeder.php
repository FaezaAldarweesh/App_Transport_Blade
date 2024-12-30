<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $permissions = [
            //Admin==========================================
            'buses',
            'show bus',
            'add bus',
            'update bus',
            'destroy bus',
            'all trashed bus',
            'restore bus',
            'forceDelete bus',
            
            'drivers',
            'show driver',
            'add driver',
            'update driver',
            'destroy driver',
            'all trashed driver',
            'restore driver',
            'forceDelete driver',
            
            'employees',
            'show employee',
            'add employee',
            'update employee',
            'destroy employee',
            'all trashed employee',
            'restore employee',
            'forceDelete employee',
            
            'roles',
            'show role',
            'add role',
            'update role',
            'destroy role',
            
            'students',
            'show student',
            'add student',
            'update student',
            'destroy student',
            'all trashed student',
            'restore student',
            'forceDelete student',

            'supervisors',
            'show supervisor',
            'add supervisor',
            'update supervisor',
            'destroy supervisor',
            'all trashed supervisor',
            'restore supervisor',
            'forceDelete supervisor',
            
            'users',
            'show user',
            'add user',
            'update user',
            'destroy user',

            'paths',
            'show path',
            'add path',
            'update path',
            'destroy path',
            'all trashed path',
            'restore path',
            'forceDelete path',

            'add station',
            'update station',
            'destroy station',
            'all trashed station',
            'restore station',
            'forceDelete station',
            
            'add trip',
            'update trip',
            'destroy trip',
            'all trashed trip',
            'restore trip',
            'forceDelete trip',
            
            //Supervisor========================================

            'checkouts',
            'show checkout',
            'show trip checkout',
            'add checkout',
            'update checkout',
            'destroy checkout',
            
            'stations',
            'show station',
            'update station status',
            
            'trips',
            'show trip',
            'update trip status',
            'all student trip',
            
            //endSupervisor=====================================
            
            'update student status',
            'update student status transport',

            //endAdmin==========================================
        ];

        foreach ($permissions as $permission) {

            Permission::create(['name' => $permission]);
        }
    }
}
