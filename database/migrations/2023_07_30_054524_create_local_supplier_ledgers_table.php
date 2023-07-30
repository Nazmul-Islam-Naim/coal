<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalSupplierLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_supplier_ledgers', function (Blueprint $table) {
            $table->bigIncrements('id');  
            $table->unsignedBigInteger('local_supplier_id');
            $table->foreign('local_supplier_id')->references('id')->on('local_suppliers')->onDelete('cascade');
            $table->date('date');
            $table->string('reason',100);
            $table->decimal('amount', 15,2)->default(0)->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('local_supplier_ledgers');
    }
}
