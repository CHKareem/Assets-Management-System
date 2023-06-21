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
        Schema::create('lost_stolens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('asset_id')->unsigned()->index();
            $table->foreign('asset_id')->references('id')->on('assets');
            $table->integer('asset_alter_id')->unsigned()->index()->nullable();
            $table->foreign('asset_alter_id')->references('id')->on('assets');
            $table->integer('documentNumber')->nullable();
            $table->date('lostDate')->nullable();
            $table->tinyInteger('isStolen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lost_stolens');
    }
};
