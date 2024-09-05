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
        $default_user_value = [
            'email_verified_at' => now(),
            'password' => bcrypt('adminadmin'),
        ];

        $users = [
            [
                'email' => 'no-reply@jgu.ac.id',
                'name' => 'Admin',
                'username' => 'admin',
                'roles' => ['admin', 'Auditor', 'Auditee', 'LPM', 'Approver'],
            ],
            [
                'email' => 'zidanazzahra916@gmail.com',
                'name' => 'Ziddan Azzahra',
                'username' => '092023090191',
                'gender' => 'M',
                'no_phone' => '081384810569',
                'nidn' => '092023090191',
                'roles' => ['Auditee', 'Auditor'],
            ],
            [
                'email' => 'rofiqabdul983@gmail.com',
                'name' => 'Muhammad Abdul Rofiq',
                'username' => '092023090180',
                'gender' => 'M',
                'no_phone' => '082258485039',
                'nidn' => '092023090180',
                'roles' => ['Auditor', 'Auditee'],
            ],
            [
                'email' => '092023090187@student.jgu.ac.id',
                'name' => 'Feni Dwi Lestari',
                'username' => '092023090187',
                'gender' => 'L',
                'no_phone' => '089602928926',
                'nidn' => '092023090187',
                'roles' => ['Auditee', 'admin', 'Auditor'],
            ],
            [
                'email' => 'approver@gmail.com',
                'name' => 'Wakil Rektor',
                'username' => 'Approver',
                'gender' => 'L',
                'no_phone' => '08960292567',
                'nidn' => '092023090190',
                'roles' => ['approver', 'Auditee', 'Auditor'],
            ],

            // dosen asli
            [
                'email' => 'ariep@jgu.ac.id',
                'name' => 'Ariep Jaenul',
                'username' => 'S092019030004',
                'password' => 'S092019030004',
                'roles' => ['admin', 'Auditor', 'Auditee']
            ],
            [
                'email' => 'yanuar@jgu.ac.id',
                'name' => 'Yanuar Zulardiansyah Arief',
                'username' => 'S092019110003',
                'password' => 'S092019110003',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'eddy@jgu.ac.id',
                'name' => 'Eddy Yusuf',
                'username' => 'S092012120001',
                'password' => 'S092012120001',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'adhes@jgu.ac.id',
                'name' => 'Adhes Gamayel',
                'username' => 'S092012120005',
                'password' => 'S092012120005',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'risma@jgu.ac.id',
                'name' => 'Risma Ekawati',
                'username' => 'S092012120083',
                'password' => 'S092012120083',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'ade@jgu.ac.id',
                'name' => 'Ade Sunardi',
                'username' => 'S092012120002',
                'password' => 'S092012120002',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'farmasita@jgu.ac.id',
                'name' => 'Rizki Farmasita Budiastuti',
                'username' => 'S092019020002',
                'password' => 'S092019020002',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'sinka@jgu.ac.id',
                'name' => 'Sinka Wilyanti',
                'username' => 'S092012120066',
                'password' => 'S092012120066',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'alfi@jgu.ac.id',
                'name' => 'Alfi Magfuriyah',
                'username' => 'S092019090007',
                'password' => 'S092019090007',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'yuni@jgu.ac.id',
                'name' => 'Yuni Pambreni',
                'username' => 'S092019090003',
                'password' => 'S092019090003',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'nawang_sari@jgu.ac.id',
                'name' => 'Ribut Nawang Sari',
                'username' => 'S092012120082',
                'password' => 'S092012120082',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'wahyono@jgu.ac.id',
                'name' => 'Mohammad Wahyono',
                'username' => 'S092019020001',
                'password' => 'S092019020001',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'dedyrutama@jgu.ac.id',
                'name' => 'Dedy Rutama',
                'username' => 'S092012120023',
                'password' => 'S092012120023',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'sukatja@jgu.ac.id',
                'name' => 'Sukatja',
                'username' => 'S092012120068',
                'password' => 'S092012120068',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'aulia@jgu.ac.id',
                'name' => 'Aulia Choiri Windari',
                'username' => 'S092020080005',
                'password' => 'S092020080005',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'kasum@jgu.ac.id',
                'name' => 'Kasum',
                'username' => 'S092017010001',
                'password' => 'S092017010001',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'mzaenudin@jgu.ac.id',
                'name' => 'Mohamad Zaenudin',
                'username' => 'S092019030006',
                'password' => 'S092019030006',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'luthfi@jgu.ac.id',
                'name' => 'Luthfi',
                'username' => 'S092014090001',
                'password' => 'S092014090001',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'riyan@jgu.ac.id',
                'name' => 'Riyan Ariyansah',
                'username' => 'S092019030001',
                'password' => 'S092019030001',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'brainvendra@jgu.ac.id',
                'name' => 'Brainvendra Widi Dionova',
                'username' => 'S092020080004',
                'password' => 'S092020080004',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'ida@jgu.ac.id',
                'name' => 'Ida Bagus Indra',
                'username' => 'S092019020003',
                'password' => 'S092019020003',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'ayu@jgu.ac.id',
                'name' => 'Ayu Nurul',
                'username' => 'S092018120001',
                'password' => 'S092018120001',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'sinta@jgu.ac.id',
                'name' => 'Sinta Restuasih',
                'username' => 'S092018090002',
                'password' => 'S092018090002',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'muhammad@jgu.ac.id',
                'name' => 'Muhammad Haikal Satria',
                'username' => 'S092019110002',
                'password' => 'S092019110002',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'legenda@jgu.ac.id',
                'name' => 'Legenda Prameswono P',
                'username' => 'S092019030012',
                'password' => 'S092019030012',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'devan@jgu.ac.id',
                'name' => 'Devan Junesco Vresdian',
                'username' => 'S092019030008',
                'password' => 'S092019030008',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'rum@jgu.ac.id',
                'name' => 'Rum Sapundani',
                'username' => 'S092014080001',
                'password' => 'S092014080001',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'mauludi@jgu.ac.id',
                'name' => 'Mauludi Manfaluthy',
                'username' => 'S092012120050',
                'password' => 'S092012120050',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'agung@jgu.ac.id',
                'name' => 'Agung Pangestu',
                'username' => 'S092020070001',
                'password' => 'S092020070001',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'untung@jgu.ac.id',
                'name' => 'Untung Suprihadi',
                'username' => 'S092016030001',
                'password' => 'S092016030001',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'anindya@jgu.ac.id',
                'name' => 'Anindya Ananda Hapsari',
                'username' => 'S092019030007',
                'password' => 'S092019030007',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'ummy@jgu.ac.id',
                'name' => 'Ummy Gusti Salamah',
                'username' => 'S092019030020',
                'password' => 'S092019030020',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'revita@jgu.ac.id',
                'name' => 'Revita Desi Hartin',
                'username' => 'S092019030015',
                'password' => 'S092019030015',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'feri@jgu.ac.id',
                'name' => 'Feri Nugroho',
                'username' => 'S092019030003',
                'password' => 'S092019030003',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'halimatuz@jgu.ac.id',
                'name' => 'Halimatuz Zuhriyah',
                'username' => 'S092020110004',
                'password' => 'S092020110004',
                'roles' => ['Auditor', 'Auditee'],
            ],
            [
                'email' => 'onki@jgu.ac.id',
                'name' => 'Onki Alexander',
                'username' => 'S092019030018',
                'password' => 'S092019030018',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'arisa@jgu.ac.id',
                'name' => 'Arisa Olivia',
                'username' => 'S092019030009',
                'password' => 'S092019030009',
                'roles' => ['admin', 'Auditor', 'Auditee'],
            ],
            [
                'email' => 'risna@jgu.ac.id',
                'name' => 'Risna Oktaviati',
                'username' => 'S092019030019',
                'password' => 'S092019030019',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'nora@jgu.ac.id',
                'name' => 'Nora Listiana',
                'username' => 'S092019030014',
                'password' => 'S092019030014',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'febria@jgu.ac.id',
                'name' => 'Febria Anjara',
                'username' => 'S092019030021',
                'password' => 'S092019030021',
                'roles' => ['admin', 'Auditor', 'Auditee', 'LPM'],
            ],
            [
                'email' => 'safira@jgu.ac.id',
                'name' => 'Safira Faizah',
                'username' => 'S092020080002',
                'password' => 'S092020080002',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'hadi@jgu.ac.id',
                'name' => 'Hadi Wijaya',
                'username' => 'S092019030010',
                'password' => 'S092019030010',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'dian@jgu.ac.id',
                'name' => 'Dian Nugraha',
                'username' => 'S092019030017',
                'password' => 'S092019030017',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'chairil@jgu.ac.id',
                'name' => 'R.M. Chairil Andri',
                'username' => 'S092019030016',
                'password' => 'S092019030016',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'aldi@jgu.ac.id',
                'name' => 'Muhamad Aldiansyah',
                'username' => 'S092021030024',
                'password' => 'S092021030024',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'nurul@jgu.ac.id',
                'name' => 'Nurul Aslamiah Istiqomah',
                'username' => 'S092020110003',
                'password' => 'S092020110003',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'benny@jgu.ac.id',
                'name' => 'Benny Efendie',
                'username' => 'S092020030001',
                'password' => 'S092020030001',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'dewi@jgu.ac.id',
                'name' => 'Dewi Rahmawati',
                'username' => 'S092019010001',
                'password' => 'S092019010001',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'alhara@jgu.ac.id',
                'name' => 'Alhara Yuwanda',
                'username' => 'S092015040001',
                'password' => 'S092015040001',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'widianingsih@jgu.ac.id',
                'name' => 'Widianingsih',
                'username' => 'S092020060001',
                'password' => 'S092020060001',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'enti@jgu.ac.id',
                'name' => 'Enti Hariadha',
                'username' => 'S092020060002',
                'password' => 'S092020060002',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'nopratilova@jgu.ac.id',
                'name' => 'Nopratilova',
                'username' => 'S092020080003',
                'password' => 'S092020080003',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'ahda@jgu.ac.id',
                'name' => 'Ahda Sabila Eddy Yusuf',
                'username' => 'S092021030018',
                'password' => 'S092021030018',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'rahmawati@jgu.ac.id',
                'name' => 'Rahmawati Ulfah',
                'username' => 'S092019090011',
                'password' => 'S092019090011',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'nurfitridewi@jgu.ac.id',
                'name' => 'Nur Fitri Dewi',
                'username' => 'S092019090008',
                'password' => 'S092019090008',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'agnemas@jgu.ac.id',
                'name' => 'Agnemas Yusoep Islami',
                'username' => 'S092019090009',
                'password' => 'S092019090009',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'zakia@jgu.ac.id',
                'name' => 'Zakia Maulida Antono',
                'username' => 'S092019090010',
                'password' => 'S092019090010',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'noviyanti@jgu.ac.id',
                'name' => 'Noviyanti',
                'username' => 'S092020110002',
                'password' => 'S092020110002',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'udriyah@jgu.ac.id',
                'name' => 'Udriyah',
                'username' => 'S092019090005',
                'password' => 'S092019090005',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'dwirachmawati@jgu.ac.id',
                'name' => 'Dwi Rachmawati',
                'username' => 'S092019030013',
                'password' => 'S092019030013',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'ahmadpitra@jgu.ac.id',
                'name' => 'Ahmad Pitra',
                'username' => 'S092021030019',
                'password' => 'S092021030019',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'dwi@jgu.ac.id',
                'name' => 'Dwi Rachmawati',
                'username' => 'S092019030013',

                'roles' => ['Auditee'],
            ],
            [
                'email' => 'ahmad_pitra@msu.edu.my',
                'name' => 'Ahmad Pitra',
                'username' => 'S092021030019',

                'roles' => ['Auditee'],
            ],
            [
                'email' => 'aliridho@jgu.ac.id',
                'name' => 'Ali Ridho',
                'username' => 'S092019040002',
                'password' => 'S092019040002',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'suciayusudari@jgu.ac.id',
                'name' => 'Suci Ayu Sudari',
                'username' => 'S092019090002',
                'password' => 'S092019090002',
                'roles' => ['Auditee'],
            ],
            [
                'email' => 'suci@jgu.ac.id',
                'name' => 'Suci Ayu Sudari',
                'username' => 'S092019090002',

                'roles' => ['Auditee'],
            ],
        ];

        $roles = [
            ['name' => 'admin', 'color' => '#000000', 'description' => 'Administrator'],
            ['name' => 'Auditee', 'color' => '#003285', 'description' => 'Auditee Person'],
            ['name' => 'Auditor', 'color' => '#006769', 'description' => 'Auditor Person'],
            ['name' => 'LPM', 'color' => '#FF0000', 'description' => 'LPM Person'],
            ['name' => 'Approver', 'color' => '#5C2FC2', 'description' => 'Approver'],
        ];

        // Create roles
        foreach ($roles as $roleData) {
            Role::create($roleData);
        }

        // Create users and assign roles
        foreach ($users as $userData) {
            $roles = $userData['roles'];
            unset($userData['roles']);
            if($userData['username'] != 'admin'){
                $default_user_value['password'] = bcrypt($userData['username']); // password default = username, kecuali user admin
            }
            $user = User::create(array_merge($userData, $default_user_value));
            $user->assignRole($roles);
        }

        // Create permission
        $permission = Permission::create(['name' => 'log-viewers.read']);

        // Assign permission to the admin
        $admin = User::where('email', 'no-reply@jgu.ac.id')->first();
        if ($admin) {
            $admin->givePermissionTo('log-viewers.read');
        }
    }
}
