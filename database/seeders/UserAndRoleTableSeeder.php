<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserAndRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'admin']); 
        
        $userRole = Role::create(['name' => 'user']);
        // $deptRole = Role::create(['name' => 'department_head']);
        $supplyRole = Role::create(['name' => 'supply_officer']);
        $financeRole = Role::create(['name' => 'finance_officer']);
        
        $admin = User::create([ 
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $admin->assignRole('admin');
        $admin->assignRole('user');

        $dep = User::create([ 
            'name' => 'Crestian Amarga',
            'email' => 'amarga@rtciligan.com',
            'email_verified_at' => now(),
            'qualification_id' => 1,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $dep->assignRole('user'); 

        $sup = User::create([ 
            'name' => 'Makoy Delima',
            'email' => 'makoy@rtciligan.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $sup->assignRole('user');
        $sup->assignRole('supply_officer'); 

        $fin = User::create([ 
            'name' => 'Michael Cuento',
            'email' => 'michael@rtciligan.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $fin->assignRole('user'); 
        $fin->assignRole('finance_officer'); 
    }
}
