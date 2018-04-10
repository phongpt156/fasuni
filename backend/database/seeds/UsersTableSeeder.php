<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\PackageWrapper\DateTime;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Thanh Phong',
            'first_name' => 'Phong',
            'last_name' => 'Phan',
            'email' => 'pthanhphong156@gmail.com',
            'password' => Hash::make('123456'),
            'gender' => 1,
            'api_token' => str_random(60),
            'is_admin' => 1,
            'created_at' => DateTime::now(),
            'updated_at' => DateTime::now()
        ]);
    }
}
