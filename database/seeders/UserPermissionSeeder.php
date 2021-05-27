<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = ['admin', 'pemilik', 'produksi'];
        foreach ($role as $key => $value) {
            Role::create([
                'name' => $value
            ]);
        }

        $user1 = User::create([
            'name' => 'Superadmin',
            'username' => 'superadmin',
            'email' => 'superadmin@tes.com',
            'password' => '123asdf123',
        ]);
        $user1->assignRole('admin');

        $user2 = User::create([
            'name' => 'Pemilik',
            'username' => 'pemilik',
            'email' => 'pemilik@tes.com',
            'password' => '123asdf123',
        ]);
        $user2->assignRole('pemilik');

        $user3 = User::create([
            'name' => 'Produksi',
            'username' => 'produksi',
            'email' => 'produksi@tes.com',
            'password' => '123asdf123',
        ]);
        $user3->assignRole('produksi');
    }
}
