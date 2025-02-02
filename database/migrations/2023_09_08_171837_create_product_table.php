<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('category_id');
            $table->string('title', 45);
            $table->string('code', 10);
            $table->string('short_description', 250)->nullable();
            $table->text('long_description')->nullable();
            $table->decimal('price', 10, 2);
            $table->unsignedBigInteger('stock');
            $table->string('image_url', 250)->nullable();
            $table->decimal('avg_review', 3, 2)->nullable();
            $table->primary('product_id');
            $table->foreign('business_id')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('category_id')
                  ->references('category_id')
                  ->on('product_category')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product');
    }
}
