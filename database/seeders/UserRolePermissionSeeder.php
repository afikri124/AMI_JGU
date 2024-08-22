<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use DB;
use App\Models\User;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $default_user_value = [
            'email_verified_at' => now(),
            'password' => bcrypt('adminadmin')
        ];
        // DB::beginTransaction();
        // try {
            //create user admin
            $admin = User::create(array_merge([
                'email' => '092023090191@student.jgu.ac.id',
                'name' => 'Admin',
                'username' => 'admin',
            ], $default_user_value));
            $zidan = User::create(array_merge([
                'email' => 'zidanazzahra916@gmail.com',
                'name' => 'Ziddan Azzahra',
                'username' => 'zidan',
                'gender' => 'M',
                'no_phone' => '081384810569',
                'nidn' => '092023090191',
            ], $default_user_value));
            $rofiq = User::create(array_merge([
                'email' => 'rofiqabdul983@gmail.com',
                'name' => 'Muhammad Abdul Rofiq',
                'username' => 'rofiq',
                'gender' => 'M',
                'no_phone' => '082258485039',
                'nidn' => '092023090180',
            ], $default_user_value));
            $feni = User::create(array_merge([
                'email' => '092023090187@student.jgu.ac.id',
                'name' => 'Feni Dwi Lestari',
                'username' => 'feni',
                'gender' => 'L',
                'no_phone' => '089602928926',
                'nidn' => '092023090187',
            ], $default_user_value));
            $approver = User::create(array_merge([
                'email' => 'approver@gmail.com',
                'name' => 'Wakil Rektor',
                'username' => 'approver',
                'gender' => 'L',
                'no_phone' => '08960292567',
                'nidn' => '092023090190',
            ], $default_user_value));
            //create role
            $role_admin = Role::create(['name' => 'admin', 'color' => '#000000', 'description' => 'Administrator']);
            $role_auditee = Role::create(['name' => 'auditee', 'color' => '#003285', 'description' => 'Auditee Person']);
            $role_auditor = Role::create(['name' => 'auditor', 'color' => '#006769', 'description' => 'Auditore Person']);
            $role_lpm = Role::create(['name' => 'lpm', 'color' => '#FF0000', 'description' => 'LPM Person']);
            $role_approver = Role::create(['name' => 'approver', 'color' => '#5C2FC2', 'description' => 'Approver']);
            //set default role
            $admin->assignRole('admin');
            $admin->assignRole('auditor');
            $admin->assignRole('auditee');
            $admin->assignRole('lpm');
            $admin->assignRole('approver');

            $zidan->assignRole('auditee');
            $zidan->assignRole('auditor');

            $rofiq->assignRole('auditor');
            $rofiq->assignRole('auditee');

            $feni->assignRole('lpm');
            $feni->assignRole('admin');

            $approver->assignRole('approver');
            $approver->assignRole('auditee');
            $approver->assignRole('auditor');

            //create permission
            $permission = Permission::create(['name' => 'log-viewers.read']);
            //set direct permissions
            $admin->givePermissionTo('log-viewers.read');
        //     DB::commit();
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        // }
    }
}
