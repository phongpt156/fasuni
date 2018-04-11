<?php

use Illuminate\Database\Seeder;
use App\PackageWrapper\DateTime;

class ProductFeatureValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_feature_values')->insert([
            [
                'product_id' => 1,
                'feature_value_id' => 1,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'product_id' => 2,
                'feature_value_id' => 2,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'product_id' => 3,
                'feature_value_id' => 3,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'product_id' => 4,
                'feature_value_id' => 4,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'product_id' => 5,
                'feature_value_id' => 5,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'product_id' => 6,
                'feature_value_id' => 6,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'product_id' => 1,
                'feature_value_id' => 6,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'product_id' => 2,
                'feature_value_id' => 7,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'product_id' => 3,
                'feature_value_id' => 8,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'product_id' => 4,
                'feature_value_id' => 9,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'product_id' => 5,
                'feature_value_id' => 1,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'product_id' => 6,
                'feature_value_id' => 2,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
        ]);
    }
}
