<?php

use Illuminate\Database\Seeder;
use App\PackageWrapper\DateTime;

class OrderStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_statuses')->insert([
            [
                'name' => 'Phiếu tạm',
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'name' => 'Đang giao hàng',
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'name' => 'Hoàn thành',
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'name' => 'Đã hủy',
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ]
        ]);
    }
}
