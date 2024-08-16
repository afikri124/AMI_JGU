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
            $auditee = User::create(array_merge([
                'email' => 'zidanazzahra916@gmail.com',
                'name' => 'Ziddan Azzahra',
                'username' => 'auditee',
                'gender' => 'M',
                'no_phone' => '081384810569'
            ], $default_user_value));
            $auditor = User::create(array_merge([
                'email' => 'rofiqabdul983@gmail.com',
                'name' => 'Muhammad Abdul Rofiq',
                'username' => 'auditor',
                'gender' => 'M',
                'no_phone' => '082258485039'
            ], $default_user_value));
            $lpm = User::create(array_merge([
                'email' => '092023090187@student.jgu.ac.id',
                'name' => 'Feni Dwi Lestari',
                'username' => 'lpm',
                'gender' => 'L',
                'no_phone' => '089602928926'
            ], $default_user_value));
            $approver = User::create(array_merge([
                'email' => 'approver@gmail.com',
                'name' => 'Wakil Rektor',
                'username' => 'approver',
            ], $default_user_value));
            //create role
            $role_admin = Role::create(['name' => 'admin', 'color' => '#000000', 'description' => 'Administrator']);
            $role_auditee = Role::create(['name' => 'auditee', 'color' => '#003285', 'description' => 'Audit Person']);
            $role_auditor = Role::create(['name' => 'auditor', 'color' => '#006769', 'description' => 'Audits Person']);
            $role_lpm = Role::create(['name' => 'lpm', 'color' => '#FF0000', 'description' => 'LPM Person']);
            $role_approver = Role::create(['name' => 'approver', 'color' => '#5C2FC2', 'description' => 'Apporverd']);
            //set default role
            $admin->assignRole('admin');
            $admin->assignRole('auditor');
            $admin->assignRole('auditee');
            $admin->assignRole('lpm');
            $admin->assignRole('approver');

            $auditee->assignRole('auditee');
            $auditee->assignRole('auditor');

            $auditor->assignRole('auditor');
            $auditor->assignRole('auditee');

            $lpm->assignRole('lpm');
            $lpm->assignRole('admin');

            $approver->assignRole('approver');

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
