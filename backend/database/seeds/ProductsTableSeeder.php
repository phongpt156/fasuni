<?php

use Illuminate\Database\Seeder;
use App\PackageWrapper\DateTime;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'id' => 1,
                'name' => 'Kodey Leather Biker Jacket',
                'price' => '276000',
                'gender' => 1,
                'master_product_id' => 1,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'id' => 2,
                'name' => 'Stens Leather Biker Jacket',
                'price' => '380000',
                'gender' => 1,
                'master_product_id' => 1,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'id' => 3,
                'name' => 'Kemble Suede Bomber',
                'price' => '328000',
                'gender' => 1,
                'master_product_id' => 1,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'id' => 4,
                'name' => 'Ellison Bomber Jacket',
                'price' => '358000',
                'gender' => 1,
                'master_product_id' => 4,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'id' => 5,
                'name' => 'Jasper Leather Biker Jacket',
                'price' => '298000',
                'gender' => 1,
                'master_product_id' => 4,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'id' => 6,
                'name' => 'Cargo Leather Biker Jacket',
                'price' => '318000',
                'gender' => 1,
                'master_product_id' => 4,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ]
        ]);
    }
}
