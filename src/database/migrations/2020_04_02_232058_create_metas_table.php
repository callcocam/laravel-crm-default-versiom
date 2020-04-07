<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metas', function (Blueprint $table) {
            $table->myId();
            $table->tenant();
            $table->user();
            $table->string('menu_id',100);
            $table->string('name',100);
            $table->string('slug',100);
            $table->string('description',255)->nullable();
            $table->status();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('menu_id')->references('id')->on('menus')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metas');
    }
}
