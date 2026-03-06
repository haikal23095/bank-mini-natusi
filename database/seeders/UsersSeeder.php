<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
               'username' => 'admin',
               'name'=>'Administrator',
               'email'=>'administrator@gmail.com',
               'level'=>'admin',
               'password'=> bcrypt('admin'),
               'lihat_password'=> 'admin',
            ],
            [
                'username' => 'operator',
                'name'=>'Operator',
                'email'=>'operator@gmail.com',
                'level'=>'operator',
                'password'=> bcrypt('operator'),
                'lihat_password'=> 'operator',
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
