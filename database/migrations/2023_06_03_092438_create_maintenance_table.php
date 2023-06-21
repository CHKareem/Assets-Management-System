<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('maintenances', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->integer('asset_id')->unsigned()->index();
            $table->foreign('asset_id')->references('id')->on('assets');
            $table->date('sendDate');
            $table->date('receiveDate')->nullable();
            $table->string('statusBefore');
            $table->string('statusAfter');
            $table->string('documentType')->nullable();
            $table->integer('documentNumber')->nullable();
            $table->integer('technicalDisclosureNumber')->nullable();
            $table->integer('paymentPrice')->nullable();
            $table->tinyInteger('isPaid')->nullable();
            $table->tinyInteger('whereMaintained');
            $table->string('reason');
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
            Schema::dropIfExists('maintenances');
    }
};
