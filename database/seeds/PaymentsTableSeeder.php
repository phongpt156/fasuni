<?php

use Illuminate\Database\Seeder;
use App\PackageWrapper\DateTime;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payments')->insert([
            [
                'name' => 'Tiền mặt',
                'method' => 'Cash',
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'name' => 'Thẻ',
                'method' => 'Card',
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'name' => 'Chuyển khoản',
                'method' => 'Transfer',
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ]
        ]);
    }
}
