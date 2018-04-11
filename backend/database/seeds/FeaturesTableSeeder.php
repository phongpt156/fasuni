<?php

use Illuminate\Database\Seeder;
use App\PackageWrapper\DateTime;

class FeaturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('features')->insert([
            [
                'name' => 'Màu sắc',
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ],
            [
                'name' => 'Size',
                'created_at' => DateTime::now(),
                'updated_at' => DateTime::now()
            ]
        ]);
    }
}
