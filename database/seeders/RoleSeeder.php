<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate(['name' => 'Super Admin']);
        Role::firstOrCreate(['name' => 'Purchasing']);
        Role::firstOrCreate(['name' => 'Pengawas']);
        Role::firstOrCreate(['name' => 'Pemilik Area']);
        Role::firstOrCreate(['name' => 'SHE Officer']);
        Role::firstOrCreate(['name' => 'SHE Manager']);
        Role::firstOrCreate(['name' => 'Vendor']);
    }
}
