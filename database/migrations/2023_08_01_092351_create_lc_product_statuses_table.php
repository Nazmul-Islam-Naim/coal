<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLcProductStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lc_product_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('lc_info_id');
            $table->foreign('lc_info_id')->references('id')->on('lc_info')->onDelete('cascade');
            $table->integer('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
            $table->string('lc_no')->unique();
            $table->decimal('total_quantity',15,2)->default(0)->nullable();
            $table->decimal('receive_quantity',15,2)->default(0)->nullable();
            $table->decimal('due_quantity',15,2)->default(0)->nullable();
            $table->date('date')->comment('lc opening date');
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
        Schema::dropIfExists('lc_product_statuses');
    }
}
