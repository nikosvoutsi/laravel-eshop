<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessTable extends Migration
{
    public function up()
    {
        Schema::create('business', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('sector')->nullable();
            $table->primary('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('business');
    }
}