<?php

use Illuminate\Database\Seeder;
use App\PackageWrapper\DateTime;

class FeatureValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('feature_values')->insert([
            [
                'name' => 'Đen',
                'value' => '#000',
                'feature_id' => 1,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'name' => 'Xanh lá cây',
                'value' => '#7cc576',
                'feature_id' => 1,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'name' => 'Hồng',
                'value' => '#fbced5',
                'feature_id' => 1,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'name' => 'Hồng Tím',
                'value' => '#ff00ff',
                'feature_id' => 1,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'name' => 'Trắng',
                'value' => '#fff',
                'feature_id' => 1,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'name' => 'XS',
                'value' => null,
                'feature_id' => 2,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'name' => 'S',
                'value' => null,
                'feature_id' => 2,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'name' => 'M',
                'value' => null,
                'feature_id' => 2,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'name' => 'L',
                'value' => null,
                'feature_id' => 2,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'name' => 'XL',
                'value' => null,
                'feature_id' => 2,
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ]
        ]);
    }
}
