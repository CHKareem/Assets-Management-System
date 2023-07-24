<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id')->unsigned()->index();
            $table->foreign('item_id')->references('id')->on('items');
            $table->integer('type_id')->unsigned()->index();
            $table->foreign('type_id')->references('id')->on('types');
            // $table->integer('center_id')->unsigned()->index();
            // $table->foreign('center_id')->references('id')->on('centers');
            // $table->integer('department_id')->unsigned()->index();
            // $table->foreign('department_id')->references('id')->on('departments');
            $table->string('codeNamaa');
            $table->string('description');
            $table->string('status');
            $table->integer('quantity')->unsigned()->default(0);
            $table->integer('realPrice')->unsigned()->default(0);
            $table->integer('expectedPrice')->nullable();
            $table->string('serialNumber')->nullable();
            $table->date('aquisitionDate');
            $table->string('aquisitionType');
            $table->string('fundedBy')->unsigned()->default(0);
            $table->string('partnerName')->nullable();
            $table->integer('documentNumber')->nullable();
            $table->longText('notes');
            $table->tinyInteger('inService')->unsigned()->default(1);
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
        Schema::dropIfExists('assets');
    }
}
