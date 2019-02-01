<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddMultistoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function ($table) {
            $table->string('primary_storeId')->nullable()->after('license_expdate');
            $table->string('multistore')->nullable()->after('primary_storeId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('stores', function ($t) {
            $t->dropColumn('primary_storeId');
            $t->dropColumn('multistore');
        });
    }
}
