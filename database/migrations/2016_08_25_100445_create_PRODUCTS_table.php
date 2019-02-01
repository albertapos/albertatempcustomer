<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePRODUCTSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::connection('mysql2')->create('PRODUCTS', function($table)
        {
            $table->increments('id');
            $table->string('itemType')->nullable();
            $table->string('itemName')->nullable();
            $table->string('unitName')->nullable();
            $table->string('departmentName')->nullable();
            $table->string('size')->nullable();
            $table->string('unitPerCase')->nullable();
            $table->string('caseCost')->nullable();
            $table->string('unitCost')->nullable();
            $table->string('sku')->nullable();
            $table->string('description')->nullable();
            $table->string('supplierName')->nullable();
            $table->string('categoryName')->nullable();
            $table->string('groupName')->nullable();
            $table->string('sellingUnit')->nullable();
            $table->string('sellingPrice')->nullable();
            $table->string('sequence')->nullable();
            $table->string('colorCode')->nullable();
            $table->string('salesItem')->nullable();
            $table->string('qtyOnHand')->nullable();
            $table->string('level2Price')->nullable();
            $table->string('level4Price')->nullable();
            $table->string('inventoryItem')->nullable();
            $table->string('age')->nullable();
            $table->string('bottleDeposit')->nullable();
            $table->string('reOrderPoint')->nullable();
            $table->string('level3Price')->nullable();
            $table->string('discount_per')->nullable();
            $table->string('foodItem')->nullable();
            $table->string('tax')->nullable();
            $table->string('bacCodeType')->nullable();
            $table->string('discount')->nullable();
            $table->string('orderQtyUpTo')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
