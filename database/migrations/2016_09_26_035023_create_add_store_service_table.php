<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddStoreServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('stores', function ($table) {
            $table->string('pos')->nullable()->after('db_hostname');
            $table->string('kiosk')->nullable()->after('pos');
            $table->string('mobile')->nullable()->after('kiosk');
            $table->string('creditcard')->nullable()->after('mobile');
            $table->string('webstore')->nullable()->after('creditcard');
            $table->string('portal')->nullable()->after('webstore');
            $table->date('license_expdate')->nullable()->after('portal');
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
            $t->dropColumn('pos');
            $t->dropColumn('kiosk');
            $t->dropColumn('mobile');
            $t->dropColumn('creditcard');
            $t->dropColumn('webstore');
            $t->dropColumn('portal');
            $t->dropColumn('license_expdate');
        });
    }
}
