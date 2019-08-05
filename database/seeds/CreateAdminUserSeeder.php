<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = User::create([
            'name' => 'Sowa',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456789')
        ]);

        $role = Role::create(['name' => 'Admin']);

        $permissions = Permission::whereNotIn('id',[13])->get();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

        $user = User::create([
            'name' => 'Pracownik',
            'email' => 'pracownik@gmail.com',
            'password' => bcrypt('123456789')
        ]);

        $role = Role::create(['name' => 'Pracownik']);

        $permissions = Permission::whereIn('id',[5,6,7,8,9,10,12,22,23,24])->get();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

        $user = User::create([
            'name' => 'Klient1',
            'email' => 'klient1@gmail.com',
            'password' => bcrypt('123456789')
        ]);

        $role = Role::create(['name' => 'Klient']);

        $permissions = Permission::whereIn('id',[5,10,11,13,18,19,20,21,22,23])->get();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

        $user = User::create([
            'name' => 'Klient2',
            'email' => 'klient2@gmail.com',
            'password' => bcrypt('123456789')
        ]);

        $user->assignRole([$role->id]);
    }
}
