<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);

        Role::firstOrCreate([
            'name' => 'Vendor',
            'guard_name' => 'web',
        ]);

        Role::firstOrCreate([
            'name' => 'Customer',
            'guard_name' => 'web',
        ]);
    }
}
