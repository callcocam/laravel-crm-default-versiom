<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->myId();
            $table->tenant();
            $table->user();
            $table->string('title',50);
            $table->string('name',100);
            $table->string('path',100)->nullable();
            $table->string('url',255)->nullable();
            $table->enum('auth',['yes','no'])->default('no');
            $table->string('icone')->nullable();
            $table->integer('ordering')->nullable()->default(1);
            $table->string('description')->nullable();
            $table->status();
            $table->softDeletes();
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
        Schema::dropIfExists('menus');
    }
}
