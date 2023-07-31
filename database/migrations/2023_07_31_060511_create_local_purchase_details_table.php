<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalPurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_purchase_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('local_purchase_id');
            $table->foreign('local_purchase_id')->references('id')->on('local_purchases')->onDelete('cascade');
            $table->integer('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
            $table->decimal('unit_price',15,2)->default(0)->nullable();
            $table->decimal('quantity',15,2)->default(0)->nullable();
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
        Schema::dropIfExists('local_purchase_details');
    }
}
