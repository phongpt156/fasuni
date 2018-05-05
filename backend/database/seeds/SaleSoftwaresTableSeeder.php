<?php

use Illuminate\Database\Seeder;
use App\PackageWrapper\DateTime;

class SaleSoftwaresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sale_softwares')->insert([
            'name' => 'KiotViet',
            'created_at' => DateTime::now(),
            'updated_at' => DateTime::now()
        ]);
    }
}
