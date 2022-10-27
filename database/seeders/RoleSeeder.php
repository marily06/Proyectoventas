<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate(["name" => "Developer"]);
        Role::firstOrCreate(["name" => "Superadmin"]);

        $role= Role::firstOrCreate(["name" => "Admin"]);
        $role->syncPermissions(Permission::pluck('name')->toArray());

        Role::firstOrCreate(["name" => "Cliente"]);

    }
}
