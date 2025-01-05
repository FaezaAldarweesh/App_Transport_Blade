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
//Admin======================================================
            //parent(1,13)=========================================
            'students',
            'student management',
            'show student trip',
            'show student checkout',
            'absences / transfar',
            'update student status',
            'update student status transport',
    //supservisor(8,20)=============================================
            'show path stations',//
            'checkouts',
            'checkout management',
            'trips',
            'trip management',
            'show trip',
            //parent==========================================
            'update trip status',
            'all student trip',
            'add checkout',
            'show checkout',
            'update checkout',
            'destroy checkout',
            'update station status',
    //supservisor=============================================
            'add student',
            'update student',
            'destroy student',
            'trashed student management',
            'restore student',
            'forceDelete student',

            'drivers',
            'driver management',
            'add driver',
            'update driver',
            'destroy driver',
            'show driver trip',
            'trashed driver management',
            'restore driver',
            'forceDelete driver',

            'supervisors',
            'supervisor management',
            'add supervisor',
            'update supervisor',
            'destroy supervisor',
            'show supervisor trip',
            'trashed supervisor management',
            'restore supervisor',
            'forceDelete supervisor',

            'buses',
            'buse management',
            'add bus',
            'update bus',
            'destroy bus',
            'show bus trip',
            'trashed bus management',
            'restore bus',
            'forceDelete bus',    
         
            'paths',
            'path management',
            'add path',
            'update path',
            'destroy path',
            'trashed path management',
            'restore path',
            'forceDelete path',
            
            'role management',
            'show role',
            'add role',
            'update role',
            'destroy role',

            'users',
            'user management',
            'show user',
            'add user',
            'update user',
            'destroy user',
       
            'stations',
            'station management',
            'add station',
            'update station',
            'destroy station',
            'trashed station management',
            'restore station',
            'forceDelete station',
         
            'add trip',
            'update trip',
            'destroy trip',
            'trashed trip management',
            'restore trip',
            'forceDelete trip',
//Admin==========================================================
        ];

        foreach ($permissions as $permission) {

            Permission::create(['name' => $permission]);
        }
    }
}
