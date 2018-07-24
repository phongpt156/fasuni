<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDistrictIdAndWardIdColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('district_id')->after('living_city_id')->nullable();
            $table->unsignedInteger('ward_id')->after('district_id')->nullable();

            $table->foreign('district_id')->references('id')->on('districts')->onDelete('set null');
            $table->foreign('ward_id')->references('id')->on('wards')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_district_id_foreign');
            $table->dropForeign('users_ward_id_foreign');

            $table->dropColumn('district_id');
            $table->dropColumn('ward_id');
        });
    }
}
